import { __ } from "@wordpress/i18n";
import {
  useBlockProps,
  InnerBlocks,
  InspectorControls,
  ColorPalette,
} from "@wordpress/block-editor";
import {
  SelectControl,
  PanelBody,
  PanelRow,
  TextControl,
} from "@wordpress/components";
import "./editor.scss";

export default function Edit({ attributes, setAttributes }) {
  const { bg_color, text_color, contrast_color, display_mode } = attributes;

  const onChangeBGColor = (hexColor) => {
	setAttributes({ bg_color: hexColor });
  };

  const onChangeTextColor = (hexColor) => {
	setAttributes({ text_color: hexColor });
  };
  const onChangeContrastColor = (hexColor) => {
	setAttributes({ contrast_color: hexColor });
  };

  function updateInfoboxTitle(value) {
	setAttributes({ infobox_title: value });
  }

  const TEMPLATE = [
	["core/image", {}],
	[
	  "cns-wiki-suite/infobox-group",
	  {
		group_title: "Infobox group title",
	  },
	],
	["core/paragraph", { placeholder: "Enter a short description..." }],
  ];

  return (
	<div
	  {...useBlockProps()}
	  style={{ backgroundColor: bg_color, color: text_color }}
	>
	  <InspectorControls>
		<PanelBody title="Display Settings" initialOpen={true}>
		  <PanelRow>
			<SelectControl
			  label={__("Mobile display", "infobox")}
			  value={attributes.display_mode}
			  options={[
				{
				  label: "Collapse Groups on Mobile",
				  value: "collapse__groups-mobile",
				},
				{ label: "Always Collapse Groups", value: "collapse__groups" },
				{
				  label: "Collapse Everything on Mobile",
				  value: "collapse__all-mobile",
				},
				{
				  label: "Always Collapse Everything",
				  value: "collapse__all",
				},
				{ label: "Always Expanded", value: "expanded__all" },
			  ]}
			  onChange={(value) => setAttributes({ display_mode: value })}
			  __next40pxDefaultSize
			/>
		  </PanelRow>
		</PanelBody>
		<PanelBody title="Color Settings" initialOpen={false}>
		  <PanelRow>
			<div>
			  <h1>Test v002</h1>
			  <fieldset>
				<legend className="blocks-base-control__label">
				  {__("Background color", "block-development-examples")}
				</legend>
				<ColorPalette
				  value={attributes.bg_color}
				  onChange={onChangeBGColor}
				/>
			  </fieldset>
			  <fieldset>
				<legend className="blocks-base-control__label">
				  {__("Text color", "block-development-examples")}
				</legend>
				<ColorPalette
				  value={attributes.text_color}
				  onChange={onChangeTextColor}
				/>
			  </fieldset>
			  <fieldset>
				<legend className="blocks-base-control__label">
				  {__("Contrast color", "block-development-examples")}
				</legend>
				<ColorPalette
				  value={attributes.contrast_color}
				  onChange={onChangeContrastColor}
				/>
			  </fieldset>
			</div>
		  </PanelRow>
		</PanelBody>
	  </InspectorControls>
	  <div className="infobox">
		<h2
		  className="infobox__title"
		  style={{ backgroundColor: contrast_color }}
		>
		  <TextControl
			placeholder="Infobox title"
			value={attributes.infobox_title}
			onChange={updateInfoboxTitle}
			style={{ fontSize: "20px", color: text_color }}
		  />
		</h2>
		<div className="infobox__content">
		  <InnerBlocks template={TEMPLATE} />
		</div>
	  </div>
	</div>
  );
}
