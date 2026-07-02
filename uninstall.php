<?php

/**
 * Runs when the plugin is deleted from the WordPress admin.
 *
 * Removes plugin options. Wiki posts are intentionally kept — they are the
 * user's content; delete them manually if desired.
 */

defined('WP_UNINSTALL_PLUGIN') || exit;

delete_option('cns_wiki_settings');
delete_option('cns_wiki_needs_flush');
