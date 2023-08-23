<?php

/**
 * @package   WooCommerce_Postal_codes_validation
 * @author    Slavko Tepavcevic <slavko.tepavcevic@gmail.com>
 * @copyright 2023 Twelve Legs Marketing - JobRack
 * @license   GPL 2.0+
 * @link      https://www.linkedin.com/in/slavkotepavcevic/
 *
 * Plugin Name:     WooCommerce Postal codes validation
 * Plugin URI:      https://www.linkedin.com/in/slavkotepavcevic/
 * Description:     Postal codes validation for WooCommerce
 * Version:         1.0.0
 * Author:          Slavko Tepavcevic
 * Author URI:      https://www.linkedin.com/in/slavkotepavcevic/
 * Text Domain:     woocommerce-postal-codes-validation
 * License:         GPL 2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path:     /languages
 * Requires PHP:    7.4
 */

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
	die( 'We\'re sorry, but you can not directly access this file.' );
}

define( 'WPCV_VERSION', '1.0.0' );
define( 'WPCV_TEXTDOMAIN', 'woocommerce-postal-codes-validation' );
define( 'WPCV_NAME', 'WooCommerce Postal codes validation' );
define( 'WPCV_PLUGIN_ROOT', plugin_dir_path( __FILE__ ) );
define( 'WPCV_PLUGIN_ABSOLUTE', __FILE__ );
define( 'WPCV_MIN_PHP_VERSION', '7.4' );
define( 'WPCV_WP_VERSION', '5.3' );

add_action(
	'init',
	static function () {
		load_plugin_textdomain( WPCV_TEXTDOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}
	);

if ( version_compare( PHP_VERSION, WPCV_MIN_PHP_VERSION, '<=' ) ) {
	add_action(
		'admin_init',
		static function () {
			deactivate_plugins( plugin_basename( __FILE__ ) );
		}
	);
	add_action(
		'admin_notices',
		static function () {
			echo wp_kses_post(
			sprintf(
				'<div class="notice notice-error"><p>%s</p></div>',
				__( '"WooCommerce Postal codes validation" requires PHP 7.4 or newer.', WPCV_TEXTDOMAIN )
			)
			);
		}
	);

	// Return early to prevent loading the plugin.
	return;
}

$woocommerce_postal_codes_validation_libraries = require WPCV_PLUGIN_ROOT . 'vendor/autoload.php'; //phpcs:ignore

require_once WPCV_PLUGIN_ROOT . 'functions/functions.php';
require_once WPCV_PLUGIN_ROOT . 'functions/debug.php';

if ( ! wp_installing() ) {
	register_activation_hook( WPCV_TEXTDOMAIN . '/' . WPCV_TEXTDOMAIN . '.php', array( new \WooCommerce_Postal_codes_validation\Backend\ActDeact, 'activate' ) );
	register_deactivation_hook( WPCV_TEXTDOMAIN . '/' . WPCV_TEXTDOMAIN . '.php', array( new \WooCommerce_Postal_codes_validation\Backend\ActDeact, 'deactivate' ) );
	add_action(
		'plugins_loaded',
		static function () use ( $woocommerce_postal_codes_validation_libraries ) {
			new \WooCommerce_Postal_codes_validation\Engine\Initialize( $woocommerce_postal_codes_validation_libraries );
		}
	);
}
