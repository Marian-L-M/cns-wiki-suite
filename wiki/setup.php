<?php

/**
 * Sets up the wiki post type and its block templates.
 *
 * @package CNS Wiki Suite
 */

defined('ABSPATH') || exit;

/**
 * Default content template for new wiki posts.
 *
 * On the Clouds and Spaceships theme this is the rich three-column layout
 * using the theme's section/tab blocks and sidebar template part. On any
 * other theme it degrades to a plain columns skeleton so new posts are
 * never born with unknown blocks.
 */
function cns_wiki_post_content_template(): array
{
    $is_cns_theme = get_template() === 'clouds-and-spaceships';

    $left_column = $is_cns_theme
        ? [['core/template-part', ['slug' => 'sidebar']]]
        : [['core/paragraph', ['placeholder' => __('Optional sidebar content…', 'cns-wiki-suite')]]];

    $center_column = $is_cns_theme
        ? [
            [
                'cns-theme/cns-section',
                [
                    'title'         => '',
                    'titleLevel'    => 'h1',
                    'showUnderline' => true,
                ],
                [
                    ['cns-theme/cns-tab', ['label' => 'Option 1'], [
                        ['core/paragraph', ['placeholder' => 'Option 1 content goes here...']],
                    ]],
                    ['cns-theme/cns-tab', ['label' => 'Option 2'], [
                        ['core/paragraph', ['placeholder' => 'Option 2 content goes here...']],
                    ]],
                    ['cns-theme/cns-tab', ['label' => 'Option 3'], [
                        ['core/paragraph', ['placeholder' => 'Option 3 content goes here...']],
                    ]],
                ],
            ],
        ]
        : [['core/paragraph', ['placeholder' => __('Write your wiki article…', 'cns-wiki-suite')]]];

    return [
        [
            'core/columns',
            [
                'className'    => 'cns-col__wrapper',
                'lock'         => ['move' => true, 'remove' => true],
                'templateLock' => 'all',
            ],
            [
                // Left column — sidebar navigation
                [
                    'core/column',
                    [
                        'className'    => 'cns-col cns-col__side cns-col__left cns-col__sidebar',
                        'lock'         => ['move' => true, 'remove' => true],
                        'templateLock' => false,
                    ],
                    $left_column,
                ],
                // Center column — content
                [
                    'core/column',
                    [
                        'className'    => 'cns-col cns-col__center',
                        'lock'         => ['move' => true, 'remove' => true],
                        'templateLock' => false,
                    ],
                    $center_column,
                ],
                // Right column — per-post infobox
                [
                    'core/column',
                    [
                        'className'    => 'cns-col cns-col__side cns-col__right cns-col__wiki',
                        'lock'         => ['move' => true, 'remove' => true],
                        'templateLock' => false,
                    ],
                    [
                        ['cns-wiki-suite/infobox', []],
                    ],
                ],
            ],
        ],
    ];
}

function cns_wiki_register_post_type()
{
    $labels = [
        'name'                  => _x('Wikis', 'Post type general name', 'cns-wiki-suite'),
        'singular_name'         => _x('Wiki', 'Post type singular name', 'cns-wiki-suite'),
        'menu_name'             => _x('Wikis', 'Admin Menu text', 'cns-wiki-suite'),
        'name_admin_bar'        => _x('Wiki', 'Add New on Toolbar', 'cns-wiki-suite'),
        'add_new'               => __('Add New', 'cns-wiki-suite'),
        'add_new_item'          => __('Add New wiki', 'cns-wiki-suite'),
        'new_item'              => __('New wiki', 'cns-wiki-suite'),
        'edit_item'             => __('Edit wiki', 'cns-wiki-suite'),
        'view_item'             => __('View wiki', 'cns-wiki-suite'),
        'all_items'             => __('All wikis', 'cns-wiki-suite'),
        'search_items'          => __('Search wikis', 'cns-wiki-suite'),
        'parent_item_colon'     => __('Parent wikis:', 'cns-wiki-suite'),
        'not_found'             => __('No wikis found.', 'cns-wiki-suite'),
        'not_found_in_trash'    => __('No wikis found in Trash.', 'cns-wiki-suite'),
        'featured_image'        => _x('Wiki Cover Image', 'Overrides the "Featured Image" phrase for this post type.', 'cns-wiki-suite'),
        'set_featured_image'    => _x('Set cover image', 'Overrides the "Set featured image" phrase for this post type.', 'cns-wiki-suite'),
        'remove_featured_image' => _x('Remove cover image', 'Overrides the "Remove featured image" phrase for this post type.', 'cns-wiki-suite'),
        'use_featured_image'    => _x('Use as cover image', 'Overrides the "Use as featured image" phrase for this post type.', 'cns-wiki-suite'),
        'archives'              => _x('Wiki archives', 'The post type archive label used in nav menus.', 'cns-wiki-suite'),
        'insert_into_item'      => _x('Insert into wiki', 'Overrides the "Insert into post" phrase (media).', 'cns-wiki-suite'),
        'uploaded_to_this_item' => _x('Uploaded to this wiki', 'Overrides the "Uploaded to this post" phrase (media).', 'cns-wiki-suite'),
        'filter_items_list'     => _x('Filter wikis list', 'Screen reader text for the filter links.', 'cns-wiki-suite'),
        'items_list_navigation' => _x('Wikis list navigation', 'Screen reader text for the pagination.', 'cns-wiki-suite'),
        'items_list'            => _x('Wikis list', 'Screen reader text for the items list.', 'cns-wiki-suite'),
    ];
    $args = [
        'labels'             => $labels,
        'description'        => 'Wiki custom post type.',
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => ['slug' => cns_get_wiki_setting( 'archive_slug', 'wiki' )],
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'supports'           => ['title', 'editor', 'author', 'thumbnail', 'excerpt'],
        'taxonomies'         => ['category', 'post_tag'],
        'show_in_rest'       => true,
        'template'           => cns_wiki_post_content_template(),
        'template_lock'      => 'insert',
    ];

    register_post_type('wiki', $args);
}
add_action('init', 'cns_wiki_register_post_type');


function cns_wiki_register_block_templates()
{
    $templates_dir = plugin_dir_path( dirname( __FILE__ ) ) . 'templates/';

    $single  = $templates_dir . 'single-wiki.html';
    $archive = $templates_dir . 'archive-wiki.html';

    if ( file_exists( $single ) ) {
        register_block_template('cns-wiki-suite//single-wiki', [
            'title'       => __('Single Wiki', 'cns-wiki-suite'),
            'description' => __('Template for single wiki posts', 'cns-wiki-suite'),
            'post_types'  => ['wiki'],
            'content'     => file_get_contents( $single ),
        ]);
    }

    if ( file_exists( $archive ) ) {
        register_block_template('cns-wiki-suite//archive-wiki', [
            'title'       => __('Wiki Archive', 'cns-wiki-suite'),
            'post_types'  => ['wiki'],
            'content'     => file_get_contents( $archive ),
        ]);
    }
}
add_action('init', 'cns_wiki_register_block_templates');
