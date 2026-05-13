import { __ } from '@wordpress/i18n';
import {
	useBlockProps,
	InspectorControls,
	useInnerBlocksProps,
	store as blockEditorStore,
} from '@wordpress/block-editor';
import { useDispatch, useSelect } from '@wordpress/data';
import { createBlock } from '@wordpress/blocks';
import { useEffect } from '@wordpress/element';
import {
	PanelBody,
	PanelRow,
	RangeControl,
	RadioControl,
	TabPanel,
	TextControl,
} from '@wordpress/components';
import './editor.scss';

const ALLOWED_BLOCKS = [ 'cns-wiki-suite/wiki-card' ];

function GridTabs( { breakpoint, attributes, setAttributes } ) {
	const columnKey = `columns${ breakpoint }`;
	const rowKey    = `rows${ breakpoint }`;

	return (
		<>
			<RangeControl
				label={ __( 'Columns', 'wiki-contents' ) }
				value={ attributes[ columnKey ] }
				onChange={ ( v ) => setAttributes( { [ columnKey ]: v } ) }
				min={ 1 }
				max={ 6 }
				__nextHasNoMarginBottom
				__next40pxDefaultSize
			/>
			<RangeControl
				label={ __( 'Rows', 'wiki-contents' ) }
				value={ attributes[ rowKey ] }
				onChange={ ( v ) => setAttributes( { [ rowKey ]: v } ) }
				min={ 1 }
				max={ 12 }
				__nextHasNoMarginBottom
				__next40pxDefaultSize
			/>
		</>
	);
}

function NewestPreviewGrid( { columns, rows, columnGap, rowGap } ) {
	return (
		<div
			className="wiki-contents__grid wiki-contents__grid--preview"
			style={ {
				'--wiki-columns-desktop': columns,
				'--wiki-column-gap': columnGap,
				'--wiki-row-gap': rowGap,
			} }
		>
			{ Array( columns * rows )
				.fill( null )
				.map( ( _, i ) => (
					<div key={ i } className="wiki-contents__placeholder-cell">
						<span className="wiki-contents__placeholder-label">
							{ __( 'Wiki', 'wiki-contents' ) } { i + 1 }
						</span>
					</div>
				) ) }
		</div>
	);
}

export default function Edit( { attributes, setAttributes, clientId } ) {
	const {
		mode,
		columnsMobile,
		columnsTablet,
		columnsDesktop,
		rowsMobile,
		rowsTablet,
		rowsDesktop,
		columnGap,
		rowGap,
	} = attributes;

	const { replaceInnerBlocks } = useDispatch( blockEditorStore );
	const innerBlocks = useSelect(
		( select ) => select( blockEditorStore ).getBlocks( clientId ),
		[ clientId ]
	);

	// Keep inner block count in sync with desktop columns × rows when in manual mode.
	// Additions append empty cards; reductions trim from the end preserving selections.
	const totalCells = columnsDesktop * rowsDesktop;
	useEffect( () => {
		if ( mode !== 'manual' ) return;
		const current = innerBlocks.length;
		if ( current === totalCells ) return;

		if ( current < totalCells ) {
			const added = Array( totalCells - current )
				.fill( null )
				.map( () => createBlock( 'cns-wiki-suite/wiki-card', {} ) );
			replaceInnerBlocks( clientId, [ ...innerBlocks, ...added ], false );
		} else {
			replaceInnerBlocks( clientId, innerBlocks.slice( 0, totalCells ), false );
		}
	}, [ totalCells, mode ] );

	const gridStyle = {
		'--wiki-columns-desktop': columnsDesktop,
		'--wiki-columns-tablet':  columnsTablet,
		'--wiki-columns-mobile':  columnsMobile,
		'--wiki-column-gap':      columnGap,
		'--wiki-row-gap':         rowGap,
	};

	// Always mount InnerBlocks so WordPress state is preserved when toggling modes.
	// In newest mode the inner blocks container is hidden via CSS.
	const innerBlocksProps = useInnerBlocksProps(
		{
			className: 'wiki-contents__grid',
			style: {
				...gridStyle,
				...( mode === 'newest' ? { display: 'none' } : {} ),
			},
		},
		{
			allowedBlocks: ALLOWED_BLOCKS,
			templateLock: false,
		}
	);

	const blockProps = useBlockProps( { className: 'wiki-contents' } );

	return (
		<div { ...blockProps }>
			<InspectorControls>
				<PanelBody title={ __( 'Display Mode', 'wiki-contents' ) } initialOpen={ true }>
					<RadioControl
						selected={ mode }
						options={ [
							{ label: __( 'Manual selection', 'wiki-contents' ),  value: 'manual' },
							{ label: __( 'Newest wikis (auto)', 'wiki-contents' ), value: 'newest' },
						] }
						onChange={ ( val ) => setAttributes( { mode: val } ) }
					/>
				</PanelBody>

				<PanelBody title={ __( 'Grid Settings', 'wiki-contents' ) } initialOpen={ true }>
					<TabPanel
						tabs={ [
							{ name: 'Mobile',  title: __( 'Mobile',  'wiki-contents' ) },
							{ name: 'Tablet',  title: __( 'Tablet',  'wiki-contents' ) },
							{ name: 'Desktop', title: __( 'Desktop', 'wiki-contents' ) },
						] }
						initialTabName="Desktop"
					>
						{ ( tab ) => (
							<GridTabs
								breakpoint={ tab.name }
								attributes={ attributes }
								setAttributes={ setAttributes }
							/>
						) }
					</TabPanel>
					<PanelRow>
						<TextControl
							label={ __( 'Column gap', 'wiki-contents' ) }
							value={ columnGap }
							onChange={ ( v ) => setAttributes( { columnGap: v } ) }
							help={ __( 'Any CSS value: 1rem, 16px, 2%…', 'wiki-contents' ) }
							__nextHasNoMarginBottom
							__next40pxDefaultSize
						/>
					</PanelRow>
					<PanelRow>
						<TextControl
							label={ __( 'Row gap', 'wiki-contents' ) }
							value={ rowGap }
							onChange={ ( v ) => setAttributes( { rowGap: v } ) }
							help={ __( 'Any CSS value: 1rem, 16px, 2%…', 'wiki-contents' ) }
							__nextHasNoMarginBottom
							__next40pxDefaultSize
						/>
					</PanelRow>
				</PanelBody>
			</InspectorControls>

			{ mode === 'newest' && (
				<NewestPreviewGrid
					columns={ columnsDesktop }
					rows={ rowsDesktop }
					columnGap={ columnGap }
					rowGap={ rowGap }
				/>
			) }

			<div { ...innerBlocksProps } />
		</div>
	);
}
