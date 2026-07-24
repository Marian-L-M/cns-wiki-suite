import { __ } from "@wordpress/i18n";
import { useState } from "@wordpress/element";
import {
  useBlockProps,
  InspectorControls,
  URLInput,
} from "@wordpress/block-editor";
import {
  Button,
  Modal,
  PanelBody,
  PanelRow,
  SelectControl,
  TextControl,
  TextareaControl,
  ToggleControl,
  __experimentalNumberControl as NumberControl,
} from "@wordpress/components";
import { pencil, trash } from "@wordpress/icons";
import "./editor.scss";

export default function Edit({ attributes, setAttributes }) {
  const DRAFT_DEFAULTS = {
	title: "",
	text: "",
	linkUrl: "",
	linkText: "",
	linkNewTab: false,
	order: 0,
  };

  const { items } = attributes;
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [editingIndex, setEditingIndex] = useState(null);
  const [draft, setDraft] = useState(DRAFT_DEFAULTS);

  // New items land at the end of the current order sequence.
  const nextOrder = items.length
	? Math.max(...items.map((item) => item.order ?? 0)) + 1
	: 1;

  function openAddModal() {
	setDraft({ ...DRAFT_DEFAULTS, order: nextOrder });
	setEditingIndex(null);
	setIsModalOpen(true);
  }

  function openEditModal(index) {
	const item = items[index];
	setDraft({
	  title: item.dt,
	  text: item.ddText,
	  linkUrl: item.linkUrl || "",
	  linkText: item.linkText || "",
	  linkNewTab: item.linkNewTab || false,
	  order: item.order ?? 0,
	});
	setEditingIndex(index);
	setIsModalOpen(true);
  }

  function closeModal() {
	setIsModalOpen(false);
  }

  function saveItem() {
	const newItem = {
	  id: editingIndex !== null ? items[editingIndex].id : String(Date.now()),
	  dt: draft.title,
	  ddText: draft.text,
	  linkUrl: draft.linkUrl,
	  linkText: draft.linkText,
	  linkNewTab: draft.linkNewTab,
	  order: draft.order,
	};

	if (editingIndex !== null) {
	  setAttributes({
		items: items.map((item, i) => (i === editingIndex ? newItem : item)),
	  });
	} else {
	  setAttributes({ items: [...items, newItem] });
	}

	closeModal();
  }

  function removeItem(index) {
	setAttributes({ items: items.filter((_, i) => i !== index) });
  }

  return (
	<div {...useBlockProps()}>
	  <InspectorControls>
		<PanelBody
		  title={__("Infobox Row Settings", "cns-wiki-suite")}
		  initialOpen={true}
		>
		  <PanelRow>
			{/* <SelectControl
			  label={__("Display Mode", "cns-wiki-suite")}
			  value={mode}
			  options={MODES}
			  onChange={(value) => setAttributes({ mode: value })}
			/> */}
		  </PanelRow>
		</PanelBody>
	  </InspectorControls>

	  {isModalOpen && (
		<Modal
		  title={
			editingIndex !== null
			  ? __("Edit Item", "cns-wiki-suite")
			  : __("Add Item", "cns-wiki-suite")
		  }
		  onRequestClose={closeModal}
		  className="infobox-row__modal"
		>
		  <TextControl
			label={__("Title", "cns-wiki-suite")}
			value={draft.title}
			onChange={(value) =>
			  setDraft((prev) => ({ ...prev, title: value }))
			}
		  />
		  <TextareaControl
			label={__("Description", "cns-wiki-suite")}
			value={draft.text}
			onChange={(value) => setDraft((prev) => ({ ...prev, text: value }))}
			rows={4}
		  />
		  <NumberControl
			label={__("Order", "cns-wiki-suite")}
			help={__(
			  "Lower numbers appear first in the list.",
			  "cns-wiki-suite"
			)}
			value={draft.order}
			min={0}
			onChange={(value) => {
			  const parsed = parseInt(value, 10);
			  setDraft((prev) => ({
				...prev,
				order: Number.isFinite(parsed) ? parsed : 0,
			  }));
			}}
		  />
		  <div className="infobox-row__url-field">
			<label className="components-base-control__label">
			  {__("Search post or add url", "cns-wiki-suite")}
			</label>
			<URLInput
			  value={draft.linkUrl}
			  onChange={(url) =>
				setDraft((prev) => ({ ...prev, linkUrl: url }))
			  }
			  placeholder={__("Search pages or paste URL…", "cns-wiki-suite")}
			/>
		  </div>
		  {draft.linkUrl && (
			<>
			  <TextControl
				label={__("Link text", "cns-wiki-suite")}
				value={draft.linkText}
				onChange={(value) =>
				  setDraft((prev) => ({ ...prev, linkText: value }))
				}
				placeholder={__("Defaults to URL if empty", "cns-wiki-suite")}
			  />
			  <ToggleControl
				label={__("Open in new tab", "cns-wiki-suite")}
				checked={draft.linkNewTab}
				onChange={(value) =>
				  setDraft((prev) => ({ ...prev, linkNewTab: value }))
				}
			  />
			</>
		  )}
		  <div className="infobox-row__modal-actions">
			<Button variant="primary" onClick={saveItem}>
			  {__("Save", "cns-wiki-suite")}
			</Button>
			<Button variant="secondary" onClick={closeModal}>
			  {__("Cancel", "cns-wiki-suite")}
			</Button>
		  </div>
		</Modal>
	  )}

	  <dl className="infobox-row__list">
		{items.length === 0 && (
		  <p className="infobox-row__empty">
			{__("Add info item below", "cns-wiki-suite")}
		  </p>
		)}
		{items
		  .map((item, index) => ({ item, index }))
		  .sort((a, b) => (a.item.order ?? 0) - (b.item.order ?? 0))
		  .map(({ item, index }) => (
		  <div key={item.id} className="infobox-row__item">
			<dt>{item.dt || <em>{__("(empty term)", "cns-wiki-suite")}</em>}</dt>
			<dd>
			  <span>
				{item.ddText}
				{item.linkUrl && (
				  <>
					{" "}
					<a href={item.linkUrl}>{item.linkText || item.linkUrl}</a>
				  </>
				)}
			  </span>
			  <span className="infobox-row__item-actions">
				  <Button
					size="small"
					icon={pencil}
					label={__("Edit item", "cns-wiki-suite")}
					onClick={() => openEditModal(index)}
				  />
				  <Button
					size="small"
					icon={trash}
					isDestructive
					label={__("Remove item", "cns-wiki-suite")}
					onClick={() => removeItem(index)}
				  />
				</span>
			</dd>
		  </div>
		))}
	  </dl>

	  <Button
		variant="primary"
		onClick={openAddModal}
		className="infobox-row__add-btn"
	  >
		+ Add row
	  </Button>
	</div>
  );
}
