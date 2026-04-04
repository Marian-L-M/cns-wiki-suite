<?php
// This file is generated. Do not modify it manually.
return array(
	'infobox' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'cns-wiki-suite/infobox',
		'version' => '0.1.0',
		'title' => 'Infobox',
		'category' => 'widgets',
		'icon' => 'smiley',
		'description' => 'An infobox style block preset.',
		'example' => array(
			
		),
		'supports' => array(
			'html' => false,
			'interactivity' => true
		),
		'attributes' => array(
			'align' => array(
				'type' => 'string',
				'default' => 'full'
			),
			'bg_color' => array(
				'type' => 'string',
				'default' => 'var(--wp--preset--color--element-bg)'
			),
			'contrast_color' => array(
				'type' => 'string',
				'default' => 'var(--wp--preset--color--element-contrast)'
			),
			'infobox_title' => array(
				'type' => 'string'
			),
			'is_infobox_open' => array(
				'type' => 'boolean',
				'default' => true
			),
			'display_mode' => array(
				'type' => 'string',
				'default' => 'collapse__groups-mobile'
			),
			'text_color' => array(
				'type' => 'string',
				'default' => 'var(--wp--preset--color--text)'
			)
		),
		'allowedBlocks' => array(
			'cns-wiki-suite/infobox-group',
			'cns-wiki-suite/infobox-row',
			'core/paragraph',
			'core/heading',
			'core/list',
			'core/image'
		),
		'textdomain' => 'infobox',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'viewScriptModule' => 'file:./view.js'
	),
	'infobox-group' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'cns-wiki-suite/infobox-group',
		'parent' => array(
			'cns-wiki-suite/infobox'
		),
		'version' => '0.1.0',
		'title' => 'Infobox Group',
		'category' => 'widgets',
		'icon' => 'smiley',
		'description' => 'Group block to be used inside of a CNS infobox',
		'example' => array(
			
		),
		'supports' => array(
			'html' => false
		),
		'attributes' => array(
			'group_title' => array(
				'type' => 'string'
			),
			'is_group_open' => array(
				'type' => 'boolean',
				'default' => true
			),
			'bg_color' => array(
				'type' => 'string',
				'default' => '#f2f2f2'
			),
			'text_color' => array(
				'type' => 'string',
				'default' => '#000000'
			),
			'contrast_color' => array(
				'type' => 'string',
				'default' => 'var(--wp--preset--color--element-contrast)'
			),
			'display_mode' => array(
				'type' => 'string',
				'default' => 'inherit'
			)
		),
		'textdomain' => 'infobox',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'viewScriptModule' => 'file:./view.js'
	),
	'infobox-row' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'cns-wiki-suite/infobox-row',
		'parent' => array(
			'cns-wiki-suite/infobox'
		),
		'version' => '0.1.0',
		'title' => 'Infobox Row',
		'category' => 'widgets',
		'icon' => 'smiley',
		'description' => 'Infobox style table row',
		'example' => array(
			
		),
		'supports' => array(
			'html' => false
		),
		'attributes' => array(
			'mode' => array(
				'type' => 'string',
				'default' => 'datalist'
			),
			'items' => array(
				'type' => 'array',
				'default' => array(
					
				)
			)
		),
		'textdomain' => 'infobox',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'viewScriptModule' => 'file:./view.js'
	),
	'wiki-archive' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'cns-wiki-suite/wiki-archive',
		'version' => '0.1.0',
		'title' => 'Wiki Archive',
		'category' => 'widgets',
		'icon' => 'smiley',
		'description' => 'Example block scaffolded with Create Block tool.',
		'example' => array(
			
		),
		'supports' => array(
			'html' => false
		),
		'textdomain' => 'wiki-archive',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php',
		'viewScript' => 'file:./view.js'
	)
);
