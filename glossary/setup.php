<?php

/**
 * Sets up the glossary post type, taxonomy, and frontend term rendering.
 *
 * The glossary is opt-in: nothing here registers unless the
 * `glossary_enabled` setting is on (CNS → Wiki tab).
 *
 * @package CNS Wiki Suite
 */

defined('ABSPATH') || exit;

function cns_wiki_glossary_enabled(): bool
{
    return (bool) cns_get_wiki_setting('glossary_enabled', false);
}

// ── Post type & taxonomy ──────────────────────────────────────────────────────

function cns_wiki_register_glossary_post_type(): void
{
    if (! cns_wiki_glossary_enabled()) {
        return;
    }

    register_taxonomy('glossary_category', ['glossary'], [
        'labels' => [
            'name'          => _x('Glossary Categories', 'taxonomy general name', 'cns-wiki-suite'),
            'singular_name' => _x('Glossary Category', 'taxonomy singular name', 'cns-wiki-suite'),
            'search_items'  => __('Search glossary categories', 'cns-wiki-suite'),
            'all_items'     => __('All glossary categories', 'cns-wiki-suite'),
            'edit_item'     => __('Edit glossary category', 'cns-wiki-suite'),
            'update_item'   => __('Update glossary category', 'cns-wiki-suite'),
            'add_new_item'  => __('Add new glossary category', 'cns-wiki-suite'),
            'new_item_name' => __('New glossary category name', 'cns-wiki-suite'),
            'menu_name'     => __('Categories', 'cns-wiki-suite'),
        ],
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'rewrite'           => ['slug' => cns_get_wiki_setting('glossary_slug', 'glossary') . '-category'],
    ]);

    $labels = [
        'name'                  => _x('Glossary', 'Post type general name', 'cns-wiki-suite'),
        'singular_name'         => _x('Glossary Entry', 'Post type singular name', 'cns-wiki-suite'),
        'menu_name'             => _x('Glossary', 'Admin Menu text', 'cns-wiki-suite'),
        'name_admin_bar'        => _x('Glossary Entry', 'Add New on Toolbar', 'cns-wiki-suite'),
        'add_new'               => __('Add New', 'cns-wiki-suite'),
        'add_new_item'          => __('Add new glossary entry', 'cns-wiki-suite'),
        'new_item'              => __('New glossary entry', 'cns-wiki-suite'),
        'edit_item'             => __('Edit glossary entry', 'cns-wiki-suite'),
        'view_item'             => __('View glossary entry', 'cns-wiki-suite'),
        'all_items'             => __('All entries', 'cns-wiki-suite'),
        'search_items'          => __('Search glossary entries', 'cns-wiki-suite'),
        'not_found'             => __('No glossary entries found.', 'cns-wiki-suite'),
        'not_found_in_trash'    => __('No glossary entries found in Trash.', 'cns-wiki-suite'),
        'archives'              => _x('Glossary', 'The post type archive label used in nav menus.', 'cns-wiki-suite'),
    ];

    register_post_type('glossary', [
        'labels'             => $labels,
        'description'        => 'Glossary entry custom post type.',
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => ['slug' => cns_get_wiki_setting('glossary_slug', 'glossary'), 'with_front' => false],
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 21,
        'menu_icon'          => 'dashicons-book-alt',
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt'],
        'taxonomies'         => ['glossary_category'],
        'show_in_rest'       => true,
        'template_lock'      => false,
    ]);
}
add_action('init', 'cns_wiki_register_glossary_post_type');

/**
 * Glossary definitions use the classic (TinyMCE) editor — plain rich text,
 * no blocks. show_in_rest stays true so the inline-format picker can search
 * entries via the REST API.
 */
add_filter('use_block_editor_for_post_type', function ($use_block_editor, $post_type) {
    return 'glossary' === $post_type ? false : $use_block_editor;
}, 10, 2);

// ── Archive block template ────────────────────────────────────────────────────

function cns_wiki_register_glossary_template(): void
{
    if (! cns_wiki_glossary_enabled()) {
        return;
    }

    $template = plugin_dir_path(dirname(__FILE__)) . 'templates/archive-glossary.html';

    if (file_exists($template)) {
        register_block_template('cns-wiki-suite//archive-glossary', [
            'title'       => __('Glossary Archive', 'cns-wiki-suite'),
            'description' => __('Template for the glossary archive page', 'cns-wiki-suite'),
            'post_types'  => ['glossary'],
            'content'     => file_get_contents($template),
        ]);
    }
}
add_action('init', 'cns_wiki_register_glossary_template');

// ── Tooltip / link rendering ──────────────────────────────────────────────────

/**
 * Returns the short definition used as tooltip text for a glossary entry:
 * the manual excerpt if set, otherwise a trimmed plain-text definition.
 */
function cns_wiki_glossary_tooltip_text(WP_Post $entry): string
{
    if (has_excerpt($entry)) {
        return wp_strip_all_tags($entry->post_excerpt);
    }
    return wp_trim_words(wp_strip_all_tags($entry->post_content), 30);
}

/**
 * Rewrites inline glossary terms at render time.
 *
 * The editor format stores only `data-glossary-id` (plus a snapshot href).
 * Here we refresh the href against the entry's current permalink and inject
 * the current definition as `data-cns-tooltip`, so tooltips never go stale.
 * Terms pointing at missing/unpublished entries are downgraded to plain text
 * styling (no dead link).
 */
function cns_wiki_glossary_render_terms(string $content): string
{
    if (! cns_wiki_glossary_enabled() || false === strpos($content, 'data-glossary-id')) {
        return $content;
    }

    $processor = new WP_HTML_Tag_Processor($content);

    while ($processor->next_tag(['tag_name' => 'a', 'class_name' => 'cns-glossary-term'])) {
        $entry_id = (int) $processor->get_attribute('data-glossary-id');
        $entry    = $entry_id ? get_post($entry_id) : null;

        if (! $entry || 'glossary' !== $entry->post_type || 'publish' !== $entry->post_status) {
            $processor->remove_attribute('href');
            $processor->add_class('cns-glossary-term--missing');
            continue;
        }

        $processor->set_attribute('href', get_permalink($entry));
        $processor->set_attribute('data-cns-tooltip', cns_wiki_glossary_tooltip_text($entry));
    }

    return $processor->get_updated_html();
}
add_filter('the_content', 'cns_wiki_glossary_render_terms', 20);

// ── Assets ────────────────────────────────────────────────────────────────────

/**
 * Glossary term styling (dotted underline + CSS tooltip) for frontend and
 * editor canvas, plus the optional text-colour override from settings.
 */
function cns_wiki_glossary_enqueue_styles(): void
{
    if (! cns_wiki_glossary_enabled()) {
        return;
    }

    wp_enqueue_style(
        'cns-wiki-glossary-term',
        plugins_url('assets/css/glossary-term.css', dirname(__FILE__)),
        [],
        '0.1.0'
    );

    $color = sanitize_hex_color((string) cns_get_wiki_setting('glossary_text_color', ''));
    if ($color) {
        wp_add_inline_style(
            'cns-wiki-glossary-term',
            ':root{--cns-glossary-color:' . $color . ';}'
        );
    }
}
add_action('enqueue_block_assets', 'cns_wiki_glossary_enqueue_styles');

/**
 * Editor-only script registering the glossary inline format (toolbar button).
 */
function cns_wiki_glossary_enqueue_format(): void
{
    if (! cns_wiki_glossary_enabled()) {
        return;
    }

    $asset_file = CNS_WIKI_SUITE_DIR . 'build/formats/glossary.asset.php';
    if (! file_exists($asset_file)) {
        return;
    }

    $asset = include $asset_file;
    wp_enqueue_script(
        'cns-wiki-glossary-format',
        plugins_url('build/formats/glossary.js', dirname(__FILE__)),
        $asset['dependencies'],
        $asset['version'],
        true
    );
}
add_action('enqueue_block_editor_assets', 'cns_wiki_glossary_enqueue_format');
