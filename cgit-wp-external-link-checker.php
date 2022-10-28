<?php

/**
 * Plugin Name: Castlegate IT WP External Link Checker
 * Plugin URI:  https://github.com/castlegateit/cgit-wp-external-link-checker
 * Description: WordPress external link identification tool.
 * Version:     1.0.0
 * Author:      Castlegate IT
 * Author URI:  https://www.castlegateit.co.uk/
 * License:     MIT
 * License URI: https://opensource.org/licenses/MIT
 * Update URI:  https://github.com/castlegateit/cgit-wp-external-link-checker
 */

use Castlegate\ExternalLinkChecker\Plugin;

if (!defined('ABSPATH')) {
    wp_die('Access denied');
}

define('CGIT_WP_EXTERNAL_LINK_CHECKER_VERSION', '1.0.0');
define('CGIT_WP_EXTERNAL_LINK_CHECKER_PLUGIN_DIR', __DIR__);

require_once __DIR__ . '/vendor/autoload.php';

Plugin::init();
