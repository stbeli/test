<?php

/**
 * WooCommerce_Postal_codes_validation
 *
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * @package   WooCommerce_Postal_codes_validation
 * @author    Slavko Tepavcevic <slavko.tepavcevic@gmail.com>
 * @copyright 2023 Twelve Legs Marketing - JobRack
 * @license   GPL 2.0+
 * @link      https://www.linkedin.com/in/slavkotepavcevic/
 */

// If uninstall not called from WordPress, then exit.
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

/**
 * Loop for uninstall
 *
 * @return void
 */
function wpcv_uninstall_multisite() {
	if ( is_multisite() ) {
		/** @var array<\WP_Site> $blogs */
		$blogs = get_sites();

		if ( !empty( $blogs ) ) {
			foreach ( $blogs as $blog ) {
				switch_to_blog( (int) $blog->blog_id );
				wpcv_uninstall();
				restore_current_blog();
			}

			return;
		}
	}

	wpcv_uninstall();
}

/**
 * What happen on uninstall?
 *
 * @global WP_Roles $wp_roles
 * @return void
 */
function wpcv_uninstall() { // phpcs:ignore
}

wpcv_uninstall_multisite();
