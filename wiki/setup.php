<?php

/**
 * Sets up the wiki post type and taxonomy
 *
 * @package CNS Wiki Suite
 */



function cns_post_tax_init()
{
    $labels = [
        'name'                  => _x('Wikis', 'Post type general name', 'wiki'),
        'singular_name'         => _x('Wiki', 'Post type singular name', 'wiki'),
        'menu_name'             => _x('Wikis', 'Admin Menu text', 'wiki'),
        'name_admin_bar'        => _x('Wiki', 'Add New on Toolbar', 'wiki'),
        'add_new'               => __('Add New', 'wiki'),
        'add_new_item'          => __('Add New wiki', 'wiki'),
        'new_item'              => __('New wiki', 'wiki'),
        'edit_item'             => __('Edit wiki', 'wiki'),
        'view_item'             => __('View wiki', 'wiki'),
        'all_items'             => __('All wikis', 'wiki'),
        'search_items'          => __('Search wikis', 'wiki'),
        'parent_item_colon'     => __('Parent wikis:', 'wiki'),
        'not_found'             => __('No wikis found.', 'wiki'),
        'not_found_in_trash'    => __('No wikis found in Trash.', 'wiki'),
        'featured_image'        => _x('Wiki Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'wiki'),
        'set_featured_image'    => _x('Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'wiki'),
        'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'wiki'),
        'use_featured_image'    => _x('Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'wiki'),
        'archives'              => _x('Wiki archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'wiki'),
        'insert_into_item'      => _x('Insert into wiki', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'wiki'),
        'uploaded_to_this_item' => _x('Uploaded to this wiki', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'wiki'),
        'filter_items_list'     => _x('Filter wikis list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'wiki'),
        'items_list_navigation' => _x('Wikis list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'wiki'),
        'items_list'            => _x('Wikis list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'wiki'),
    ];
    $args = [
        'labels'             => $labels,
        'description'        => 'Wiki custom post type.',
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => ['slug' => 'wiki'],
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'supports'           => ['title', 'editor', 'author', 'thumbnail', 'excerpt'],
        'taxonomies'         => ['category', 'post_tag'],
        'show_in_rest'       => true,
        // Wiki - Three column standard layout
        'template'           => [
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
                            'className'     => 'cns-col cns-col__side cns-col__left cns-sidebar',
                            'lock'          => ['move' => true, 'remove' => true],
                            'templateLock'  => false,
                            'allowedBlocks' => ['core/list', 'core/heading'],
                        ],
                        [
                            ['core/list', [], [
                                ['core/list-item', ['content' => '<a href="/Wiki">Wiki</a>']],
                                ['core/list-item', ['content' => '<a href="#">Link two</a>']],
                            ]],
                        ],
                    ],
                    // Center column — content
                    [
                        'core/column',
                        [
                            'className'    => 'cns-col cns-col__center',
                            'lock'         => ['move' => true, 'remove' => true],
                            'templateLock' => false,
                        ],
                        [
                            ['core/post-title', ['level' => 1]],
                            ['core/heading', ['level' => 2, 'content' => 'Introduction']],
                            ['core/paragraph', ['placeholder' => 'Write a quick introduction on what this wiki article is about...']],
                            ['core/separator', []],
                            ['core/heading', ['level' => 2, 'placeholder' => 'Section Placeholder']],
                            ['core/paragraph', ['placeholder' => 'Group your contents into easy sections']],
                        ],
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
        ],
        'template_lock'      => 'insert',
    ];

    register_post_type('wiki', $args);
}
add_action('init', 'cns_post_tax_init');


function insert_cns_wiki_suite_templates()
{
    $templates_dir = plugin_dir_path( dirname( __FILE__ ) ) . 'templates/';

    register_block_template('cns-wiki-suite//single-wiki', [
        'title'       => 'Single Wiki',
        'description' => 'Template for single wiki posts',
        'post_types'  => ['wiki'],
        'content'     => file_get_contents( $templates_dir . 'single-wiki.html' ),
    ]);

    register_block_template('cns-wiki-suite//archive-wiki', [
        'title'       => 'Wiki Archive',
        'post_types'  => ['wiki'],
        'content'     => file_get_contents( $templates_dir . 'archive-wiki.html' ),
    ]);
};

add_action('init', 'insert_cns_wiki_suite_templates');
