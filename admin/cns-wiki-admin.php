<?php
/**
 * CNS Wiki Suite — CNS admin panel integration.
 *
 * Registers the Wiki tab on the Clouds And Spaceships settings page
 * provided by the CNS theme. If the theme is not active the filter
 * never fires and this file is a harmless no-op.
 */

defined( 'ABSPATH' ) || exit;

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
