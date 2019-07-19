<?php
/*
 * Plugin Name: Better Footnotes
 * Description: Simple yet powerful footnotes integration on your WordPress site.
 * Version: 1.0
 * Author: Nashwan Doaqan
 * Author URI: https://profiles.wordpress.org/alex-ye/
 * Text Domain: better-footnotes
 * Domain Path: /locales
 *
 * This plugin is based on Advanced Footnotes plugin v1.1.2 by Yunus Tabakoğlu.
*/

/**
 * Plugin's version.
 * 
 * @var   float
 * @since 1.0
 */
define('BetterFootnotes\PLUGIN_VERSION', '1.0');

/**
 * Plugin's codename.
 * 
 * @var   string
 * @since 1.0
 */
define('BetterFootnotes\PLUGIN_CODENAME', 'better_footnotes');

/**
 * Plugin's directory URL.
 * 
 * @var   string
 * @since 1.0
 */
define('BetterFootnotes\PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Plugin's directory path.
 * 
 * @var   string
 * @since 1.0
 */
define('BetterFootnotes\PLUGIN_PATH', plugin_dir_path(__FILE__));

require trailingslashit(BetterFootnotes\PLUGIN_PATH) . 'vendor/autoload.php';

BetterFootnotes\Main::instance();

if (is_admin()) {
    BetterFootnotes\Admin::instance();
}
