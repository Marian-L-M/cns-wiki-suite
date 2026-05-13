import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import {
	Button,
	ColorPalette,
	Modal,
	PanelBody,
	PanelRow,
	Placeholder,
	SearchControl,
	SelectControl,
	Spinner,
	ToggleControl,
} from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { store as coreDataStore, useEntityRecords } from '@wordpress/core-data';
import { useState } from '@wordpress/element';
import './editor.scss';

function PostSelectorModal( { currentPostType, onSelect, onClose } ) {
	const [ search, setSearch ] = useState( '' );
	const [ postType, setPostType ] = useState( currentPostType );

	const { records, isResolving } = useEntityRecords( 'postType', postType, {
		search,
		per_page: 10,
		_fields: 'id,title',
		status: 'publish',
	} );

	return (
		<Modal
			title={ __( 'Select a post', 'wiki-card' ) }
			onRequestClose={ onClose }
			className="wiki-card-modal"
		>
			<SelectControl
				label={ __( 'Post type', 'wiki-card' ) }
				value={ postType }
				options={ [
					{ label: __( 'Wiki', 'wiki-card' ), value: 'wiki' },
					{ label: __( 'Post', 'wiki-card' ), value: 'post' },
					{ label: __( 'Page', 'wiki-card' ), value: 'page' },
				] }
				onChange={ setPostType }
				__next40pxDefaultSize
			/>
			<SearchControl
				value={ search }
				onChange={ setSearch }
				placeholder={ __( 'Search…', 'wiki-card' ) }
				__next40pxDefaultSize
			/>
			<div className="wiki-card-modal__results">
				{ isResolving && <Spinner /> }
				{ ! isResolving && records?.length === 0 && (
					<p className="wiki-card-modal__empty">
						{ __( 'No posts found.', 'wiki-card' ) }
					</p>
				) }
				{ records?.map( ( post ) => (
					<button
						key={ post.id }
						className="wiki-card-modal__result"
						onClick={ () => onSelect( post.id, postType ) }
						type="button"
					>
						{ post.title?.rendered ?? post.title?.raw ?? `#${ post.id }` }
					</button>
				) ) }
			</div>
		</Modal>
	);
}

function CardPreview( { postId, postType, attributes } ) {
	const { backgroundColor, showThumbnail, showTitle, showExcerpt, showLink } =
		attributes;

	const { post, mediaUrl } = useSelect(
		( select ) => {
			const { getEntityRecord, getMedia } = select( coreDataStore );
			const p = getEntityRecord( 'postType', postType, postId );
			const mediaId = p?.featured_media;
			const media = mediaId ? getMedia( mediaId ) : null;
			return {
				post: p,
				mediaUrl:
					media?.media_details?.sizes?.medium?.source_url ||
					media?.source_url ||
					null,
			};
		},
		[ postId, postType ]
	);

	if ( ! post ) {
		return (
			<div className="wiki-card wiki-card--loading" style={ { backgroundColor } }>
				<Spinner />
			</div>
		);
	}

	const title = post.title?.rendered ?? '';
	const excerpt = post.excerpt?.rendered ?? '';

	return (
		<div className="wiki-card" style={ { backgroundColor } }>
			{ showThumbnail && mediaUrl && (
				<div className="wiki-card__thumbnail">
					<img src={ mediaUrl } alt={ title } />
				</div>
			) }
			{ showTitle && <h3 className="wiki-card__title">{ title }</h3> }
			{ showExcerpt && excerpt && (
				<div
					className="wiki-card__excerpt"
					dangerouslySetInnerHTML={ { __html: excerpt } }
				/>
			) }
			{ showLink && (
				<span className="wiki-card__link">
					{ __( 'Read more', 'wiki-card' ) }
				</span>
			) }
		</div>
	);
}

export default function Edit( { attributes, setAttributes } ) {
	const {
		postId,
		postType,
		backgroundColor,
		showThumbnail,
		showTitle,
		showExcerpt,
		showLink,
	} = attributes;

	const [ isModalOpen, setIsModalOpen ] = useState( false );

	const handleSelect = ( id, type ) => {
		setAttributes( { postId: id, postType: type } );
		setIsModalOpen( false );
	};

	return (
		<div { ...useBlockProps() }>
			<InspectorControls>
				<PanelBody title={ __( 'Card Settings', 'wiki-card' ) } initialOpen={ true }>
					<ToggleControl
						label={ __( 'Show thumbnail', 'wiki-card' ) }
						checked={ showThumbnail }
						onChange={ ( val ) => setAttributes( { showThumbnail: val } ) }
						__nextHasNoMarginBottom
					/>
					<ToggleControl
						label={ __( 'Show title', 'wiki-card' ) }
						checked={ showTitle }
						onChange={ ( val ) => setAttributes( { showTitle: val } ) }
						__nextHasNoMarginBottom
					/>
					<ToggleControl
						label={ __( 'Show excerpt', 'wiki-card' ) }
						checked={ showExcerpt }
						onChange={ ( val ) => setAttributes( { showExcerpt: val } ) }
						__nextHasNoMarginBottom
					/>
					<ToggleControl
						label={ __( 'Show read more link', 'wiki-card' ) }
						checked={ showLink }
						onChange={ ( val ) => setAttributes( { showLink: val } ) }
						__nextHasNoMarginBottom
					/>
				</PanelBody>
				<PanelBody title={ __( 'Color', 'wiki-card' ) } initialOpen={ false }>
					<PanelRow>
						<fieldset style={ { width: '100%' } }>
							<legend className="blocks-base-control__label">
								{ __( 'Background color', 'wiki-card' ) }
							</legend>
							<ColorPalette
								value={ backgroundColor }
								onChange={ ( val ) =>
									setAttributes( { backgroundColor: val ?? '#f0f0f0' } )
								}
							/>
						</fieldset>
					</PanelRow>
				</PanelBody>
				{ postId > 0 && (
					<PanelBody title={ __( 'Post', 'wiki-card' ) } initialOpen={ false }>
						<PanelRow>
							<Button
								variant="secondary"
								onClick={ () => setIsModalOpen( true ) }
							>
								{ __( 'Change post', 'wiki-card' ) }
							</Button>
						</PanelRow>
					</PanelBody>
				) }
			</InspectorControls>

			{ isModalOpen && (
				<PostSelectorModal
					currentPostType={ postType }
					onSelect={ handleSelect }
					onClose={ () => setIsModalOpen( false ) }
				/>
			) }

			{ postId === 0 ? (
				<Placeholder
					icon="index-card"
					label={ __( 'Wiki Card', 'wiki-card' ) }
					instructions={ __( 'Select a post to display as a card.', 'wiki-card' ) }
				>
					<Button variant="primary" onClick={ () => setIsModalOpen( true ) }>
						{ __( 'Select post', 'wiki-card' ) }
					</Button>
				</Placeholder>
			) : (
				<CardPreview postId={ postId } postType={ postType } attributes={ attributes } />
			) }
		</div>
	);
}
