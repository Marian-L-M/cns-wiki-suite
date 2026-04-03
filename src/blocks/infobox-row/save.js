import { useBlockProps } from "@wordpress/block-editor";

function renderLink( item ) {
	if ( ! item.linkUrl ) return null;
	return (
		<>
			{ " " }
			<a
				href={ item.linkUrl }
				{ ...( item.linkNewTab
					? { target: "_blank", rel: "noreferrer" }
					: {} ) }
			>
				{ item.linkText || item.linkUrl }
			</a>
		</>
	);
}

export default function save( { attributes } ) {
	const { mode, items } = attributes;

	const renderDatalist = () => (
		<dl className="infobox-row__list">
			{ items.map( ( item ) => (
				<div key={ item.id } className="infobox-row__item">
					<dt>{ item.dt }</dt>
					<dd>
						{ item.ddText }
						{ renderLink( item ) }
					</dd>
				</div>
			) ) }
		</dl>
	);

	const renderTable = () => (
		<table className="infobox-row__table">
			<tbody>
				{ items.map( ( item ) => (
					<tr key={ item.id }>
						<th scope="row">{ item.dt }</th>
						<td>
							{ item.ddText }
							{ renderLink( item ) }
						</td>
					</tr>
				) ) }
			</tbody>
		</table>
	);

	return (
		<div { ...useBlockProps.save() }>
			{ mode === "table" ? renderTable() : renderDatalist() }
		</div>
	);
}
