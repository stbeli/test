<?php

/**
 * WooCommerce_Postal_codes_validation
 *
 * @package   WooCommerce_Postal_codes_validation
 * @author    Slavko Tepavcevic <slavko.tepavcevic@gmail.com>
 * @copyright 2023 Twelve Legs Marketing - JobRack
 * @license   GPL 2.0+
 * @link      https://www.linkedin.com/in/slavkotepavcevic/
 */

namespace WooCommerce_Postal_codes_validation\Cli;

use WooCommerce_Postal_codes_validation\Engine\Base;

if ( \defined( 'WP_CLI' ) && WP_CLI ) {

	/**
	 * WP CLI command for uploading CVS file
	 */
	class UploadCsv extends Base {

		/**
		 * Initialize the commands
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			\WP_CLI::add_command( 'pcv_uploadcsv', array( $this, 'uploadcsv' ) );
		}

		/**
		 * Initialize the class.
		 *
		 * @return void|bool
		 */
		public function initialize() {
			if ( !\apply_filters( 'woocommerce_postal_codes_validation_wpcv_enqueue_admin_initialize', true ) ) {
				return;
			}

			parent::initialize();
		}

		/**
		 * Upload CSV via WP-CLI pcv_uploadcsv xyz.csv command
		 *
		 * @since 1.0.0
		 * @param array $args The attributes.
		 * @return void
		 */
		public function uploadcsv( array $args ) {
			if ( $args[0] ) {
				ob_start();
				include sanitize_text_field( $args[0] );
				$csvcontents = ob_get_clean();
			
				update_option( WPCV_TEXTDOMAIN . '_csv_data', $csvcontents );
				\WP_CLI::success( $args[0] );
			} else {
				\WP_CLI::warning( 'Please define file name argument: wp-cli pcv_uploadcsv filename.csv' );
			}
		}

	}

}
