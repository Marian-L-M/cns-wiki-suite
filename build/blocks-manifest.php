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
	),
	'wiki-card' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'cns-wiki-suite/wiki-card',
		'version' => '0.1.0',
		'title' => 'Wiki Card',
		'category' => 'widgets',
		'icon' => 'index-card',
		'description' => 'Display a post as a card with thumbnail, title, excerpt and link. Designed for wiki post types.',
		'example' => array(
			
		),
		'supports' => array(
			'html' => false
		),
		'attributes' => array(
			'postId' => array(
				'type' => 'number',
				'default' => 0
			),
			'postType' => array(
				'type' => 'string',
				'default' => 'wiki'
			),
			'backgroundColor' => array(
				'type' => 'string',
				'default' => '#f0f0f0'
			),
			'textColor' => array(
				'type' => 'string',
				'default' => ''
			),
			'showThumbnail' => array(
				'type' => 'boolean',
				'default' => true
			),
			'showTitle' => array(
				'type' => 'boolean',
				'default' => true
			),
			'showCategories' => array(
				'type' => 'boolean',
				'default' => false
			),
			'showExcerpt' => array(
				'type' => 'boolean',
				'default' => true
			),
			'showTags' => array(
				'type' => 'boolean',
				'default' => false
			),
			'showLink' => array(
				'type' => 'boolean',
				'default' => true
			)
		),
		'textdomain' => 'wiki-card',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php'
	),
	'wiki-contents' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'cns-wiki-suite/wiki-contents',
		'version' => '0.1.0',
		'title' => 'Wiki Contents',
		'category' => 'widgets',
		'icon' => 'grid-view',
		'description' => 'A responsive grid of wiki cards. Populate manually or auto-fill with the newest wikis.',
		'example' => array(
			
		),
		'supports' => array(
			'html' => false
		),
		'allowedBlocks' => array(
			'cns-wiki-suite/wiki-card'
		),
		'attributes' => array(
			'mode' => array(
				'type' => 'string',
				'default' => 'manual'
			),
			'columnsMobile' => array(
				'type' => 'number',
				'default' => 1
			),
			'columnsTablet' => array(
				'type' => 'number',
				'default' => 2
			),
			'columnsDesktop' => array(
				'type' => 'number',
				'default' => 3
			),
			'numberOfPosts' => array(
				'type' => 'number',
				'default' => 3
			),
			'columnGap' => array(
				'type' => 'number',
				'default' => 16
			),
			'rowGap' => array(
				'type' => 'number',
				'default' => 16
			)
		),
		'textdomain' => 'wiki-contents',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php'
	)
);
