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
 * This is the *editable* portion of a wiki article only: the center content
 * column (section/tabs) and the per-post infobox column. The surrounding page
 * chrome — the left navigation sidebar and the outer layout wrapper — lives in
 * the single-wiki.html block template, so it renders on the front end without
 * appearing in the post editor (matching how normal posts behave).
 *
 * On the Clouds and Spaceships theme this uses the theme's section/tab blocks.
 * On any other theme it degrades to a plain columns skeleton so new posts are
 * never born with unknown blocks.
 */
function cns_wiki_post_content_template(): array
{
    $is_cns_theme = get_template() === 'clouds-and-spaceships';

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
                'className'    => 'cns-col__inner-wrapper',
                'isStackedOnMobile' => true,
                'lock'         => ['move' => true, 'remove' => true],
                'templateLock' => 'all',
            ],
            [
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
        'supports'           => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'],
        'taxonomies'         => ['category', 'post_tag'],
        'show_in_rest'       => true,
        'template'           => cns_wiki_post_content_template(),
        'template_lock'      => 'insert',
    ];

    register_post_type('wiki', $args);
}
add_action('init', 'cns_wiki_register_post_type');


/**
 * Substitutes the placeholder thumbnail (CNS → Wiki tab) for wiki posts that
 * have no cover image. Hooking post_thumbnail_id covers every consumer at
 * once — wiki cards, the archive's post-featured-image block, and theme
 * templates. Frontend only, so the admin list and editor still show which
 * wikis genuinely lack a cover image.
 */
function cns_wiki_placeholder_thumbnail_id( $thumbnail_id, $post )
{
    if ( $thumbnail_id || is_admin() ) {
        return $thumbnail_id;
    }

    $post = get_post( $post );
    if ( ! $post || 'wiki' !== $post->post_type ) {
        return $thumbnail_id;
    }

    $placeholder = absint( cns_get_wiki_setting( 'placeholder_thumb_id', 0 ) );

    return $placeholder && wp_attachment_is_image( $placeholder ) ? $placeholder : $thumbnail_id;
}
add_filter( 'post_thumbnail_id', 'cns_wiki_placeholder_thumbnail_id', 10, 2 );


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
