<?php
/**
 * CNS Wiki Suite — CNS admin panel integration.
 *
 * Registers the Wiki tab on the Clouds And Spaceships settings page
 * provided by the CNS theme. If the theme is not active the filter
 * never fires and this file is a harmless no-op.
 */

defined( 'ABSPATH' ) || exit;

// ── Settings helper ───────────────────────────────────────────────────────────

function cns_get_wiki_setting( string $key, $default = null ) {
    static $settings = null;
    if ( null === $settings ) {
        $settings = (array) get_option( 'cns_wiki_settings', [] );
    }
    return array_key_exists( $key, $settings ) ? $settings[ $key ] : $default;
}

// ── Settings API registration ─────────────────────────────────────────────────

add_action( 'admin_init', 'cns_wiki_register_settings' );

function cns_wiki_register_settings(): void {
    register_setting(
        'cns_wiki_settings_group',
        'cns_wiki_settings',
        [ 'sanitize_callback' => 'cns_sanitize_wiki_settings' ]
    );
}

function cns_sanitize_wiki_settings( $input ): array {
    $input  = is_array( $input ) ? $input : [];
    $output = [];

    // Archive
    $raw_slug             = preg_replace( '/[^a-z0-9\-]/', '', strtolower( $input['archive_slug'] ?? 'wiki' ) );
    $output['archive_slug']     = $raw_slug ?: 'wiki';
    $output['archive_per_page'] = max( 1, (int) ( $input['archive_per_page'] ?? 12 ) );

    $valid_orders            = [ 'date_desc', 'date_asc', 'title_asc' ];
    $order                   = sanitize_key( $input['archive_order'] ?? 'date_desc' );
    $output['archive_order'] = in_array( $order, $valid_orders, true ) ? $order : 'date_desc';

    // Grid defaults
    $output['grid_columns_desktop'] = min( 6, max( 1, (int) ( $input['grid_columns_desktop'] ?? 3 ) ) );
    $output['grid_columns_tablet']  = min( 4, max( 1, (int) ( $input['grid_columns_tablet']  ?? 2 ) ) );
    $output['grid_columns_mobile']  = min( 2, max( 1, (int) ( $input['grid_columns_mobile']  ?? 1 ) ) );
    $output['grid_column_gap']      = min( 64, max( 0, (int) ( $input['grid_column_gap'] ?? 16 ) ) );
    $output['grid_row_gap']         = min( 64, max( 0, (int) ( $input['grid_row_gap']    ?? 16 ) ) );

    // Infobox colours
    $output['infobox_bg_color']       = sanitize_hex_color( $input['infobox_bg_color']       ?? '' ) ?? '';
    $output['infobox_contrast_color'] = sanitize_hex_color( $input['infobox_contrast_color'] ?? '' ) ?? '';
    $output['infobox_border_color']   = sanitize_hex_color( $input['infobox_border_color']   ?? '' ) ?? '';

    return $output;
}

// ── Flush rewrites when slug changes ─────────────────────────────────────────
//
// flush_rewrite_rules() must run AFTER the CPT is registered with the new slug.
// On the request that saves the option, init has already fired with the old slug,
// so flushing immediately would bake the old slug into the rules. Instead we set
// a flag here, and flush on the next init once the CPT registers with the new slug.

add_action( 'update_option_cns_wiki_settings', 'cns_wiki_schedule_rewrite_flush', 10, 2 );

function cns_wiki_schedule_rewrite_flush( $old_value, $new_value ): void {
    if ( ( $old_value['archive_slug'] ?? 'wiki' ) !== ( $new_value['archive_slug'] ?? 'wiki' ) ) {
        update_option( 'cns_wiki_needs_flush', true );
    }
}

// Flag on first-ever save too.
add_action( 'add_option_cns_wiki_settings', static function (): void {
    update_option( 'cns_wiki_needs_flush', true );
} );

// Priority 99 — runs after cns_post_tax_init (priority 10) has registered the
// CPT with the new slug, so the flushed rules reflect the correct permalink.
add_action( 'init', 'cns_wiki_flush_if_needed', 99 );

function cns_wiki_flush_if_needed(): void {
    if ( get_option( 'cns_wiki_needs_flush' ) ) {
        delete_option( 'cns_wiki_needs_flush' );
        flush_rewrite_rules();
    }
}

// ── Infobox colour overrides ──────────────────────────────────────────────────

// enqueue_block_assets fires on both the frontend and in the editor.
add_action( 'enqueue_block_assets', 'cns_wiki_enqueue_infobox_styles' );

function cns_wiki_enqueue_infobox_styles(): void {
    $bg       = (string) cns_get_wiki_setting( 'infobox_bg_color',       '' );
    $contrast = (string) cns_get_wiki_setting( 'infobox_contrast_color', '' );
    $border   = (string) cns_get_wiki_setting( 'infobox_border_color',   '' );

    if ( ! $bg && ! $contrast && ! $border ) {
        return;
    }

    $rules = '';
    if ( $bg )       $rules .= '--wp--preset--color--element-bg:' . sanitize_hex_color( $bg ) . ';';
    if ( $contrast ) $rules .= '--wp--preset--color--element-contrast:' . sanitize_hex_color( $contrast ) . ';';
    if ( $border )   $rules .= 'border-color:' . sanitize_hex_color( $border ) . ';';

    $css = '.wp-block-cns-wiki-suite-infobox{' . $rules . '}';

    wp_register_style( 'cns-wiki-infobox-overrides', false );
    wp_enqueue_style( 'cns-wiki-infobox-overrides' );
    wp_add_inline_style( 'cns-wiki-infobox-overrides', $css );
}

// ── Archive query overrides ───────────────────────────────────────────────────

add_action( 'pre_get_posts', 'cns_wiki_archive_query' );

function cns_wiki_archive_query( WP_Query $query ): void {
    if ( is_admin() || ! $query->is_main_query() || ! $query->is_post_type_archive( 'wiki' ) ) {
        return;
    }

    $query->set( 'posts_per_page', (int) cns_get_wiki_setting( 'archive_per_page', 12 ) );

    switch ( cns_get_wiki_setting( 'archive_order', 'date_desc' ) ) {
        case 'date_asc':
            $query->set( 'orderby', 'date' );
            $query->set( 'order', 'ASC' );
            break;
        case 'title_asc':
            $query->set( 'orderby', 'title' );
            $query->set( 'order', 'ASC' );
            break;
        default:
            $query->set( 'orderby', 'date' );
            $query->set( 'order', 'DESC' );
    }
}

// ── Admin tab registration ────────────────────────────────────────────────────

add_filter( 'cns_admin_tabs', function ( array $tabs ): array {
    $tabs['wiki'] = [
        'menu_title' => __( 'Wiki', 'cns-wiki-suite' ),
        'title'      => __( 'CNS Wiki Suite', 'cns-wiki-suite' ),
        'capability' => 'manage_options',
        'callback'   => 'cns_wiki_admin_render_tab',
        'priority'   => 20,
    ];
    return $tabs;
} );

function cns_wiki_admin_render_tab(): void {
    include __DIR__ . '/partials/tab-wiki.php';
}
