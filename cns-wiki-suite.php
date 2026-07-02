<?php

/**
 * Plugin Name:       CNS Wiki Suite
 * Description:       A block toolset to create wiki like experience. Optimized for the Clouds and Spaceships theme.
 * Version:           0.1.0
 * Requires at least: 6.8
 * Requires PHP:      8.0
 * Author:            Marian Maschke
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       cns-wiki-suite
 *
 * @package CNS Wiki Suite
 */

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

define('CNS_WIKI_SUITE_DIR', plugin_dir_path(__FILE__));

/**
 * Registers all blocks from the build manifest.
 *
 * @see https://make.wordpress.org/core/2025/03/13/more-efficient-block-type-registration-in-6-8/
 */
function cns_wiki_register_blocks(): void
{
	if (file_exists(__DIR__ . '/build/blocks-manifest.php')) {
		wp_register_block_types_from_metadata_collection(__DIR__ . '/build/blocks', __DIR__ . '/build/blocks-manifest.php');
	} elseif (defined('WP_DEBUG') && WP_DEBUG) {
		trigger_error('CNS Wiki Suite: block manifest not found — run `npm run build` in the plugin directory.', E_USER_NOTICE);
	}
}
add_action('init', 'cns_wiki_register_blocks');

// Setup wiki post type
require __DIR__ . '/wiki/setup.php';

// CNS theme admin panel integration
require __DIR__ . '/admin/cns-wiki-admin.php';

// ── Lifecycle hooks ───────────────────────────────────────────────────────────

function cns_wiki_suite_activate(): void
{
	cns_wiki_register_post_type();
	flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'cns_wiki_suite_activate');

function cns_wiki_suite_deactivate(): void
{
	if (post_type_exists('wiki')) {
		unregister_post_type('wiki');
	}
	flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'cns_wiki_suite_deactivate');
