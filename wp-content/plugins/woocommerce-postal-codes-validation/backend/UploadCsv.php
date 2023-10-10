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

namespace WooCommerce_Postal_codes_validation\Backend;

use WooCommerce_Postal_codes_validation\Engine\Base;

/**
 * Activate and deactive method of the plugin and relates.
 */
class UploadCsv extends Base {
	
	/**
	 * Initialize the class.
	 *
	 * @return void|bool
	 */
	public function initialize() {
		if ( !parent::initialize() ) {
			return;
		}

		\add_action( 'woocommerce_settings_tabs_array', array( $this, 'pcvalidation_setting_tab' ), 21 );
		\add_action( 'woocommerce_settings_pcvalidation', array( $this, 'settings_content' ) );
		\add_action( 'woocommerce_settings_save_pcvalidation', array( $this, 'save_csv' ), 10 );
	}

	/**
	 * Add new WooCommerce Settings tab after Shipping
	 *
	 * @param array $tabs WC Settings tabs.
	 * @return array
	 */
	public function pcvalidation_setting_tab( array $tabs ) {
		$pcvalidation_tab = array( 'pcvalidation' => 'Postal codes validation' );
	 	$tabs             = array_slice( $tabs, 0, 3, true ) + $pcvalidation_tab + array_slice( $tabs, 3, null, true );

	 	return $tabs;
	}

	/**
	 * Content for WooCcmmerce -> Settings -> (tab) Postal codes validation
	 *
	 * @return void|bool
	 */
	public function settings_content() {
		?><h3><?php esc_html_e( 'Postal codes validation', WPCV_TEXTDOMAIN ); ?></h3>
		<p><?php esc_html_e( 'Upload CSV file via below form or use wp-cli pcv_uploadcsv filename.csv command', WPCV_TEXTDOMAIN ); ?></p>
		<input type="file" name="upload_file" accept="text/plain" />
        <?php
	}

	/**
	 * Update db option
	 *
	 * @return void|bool
	 */
	public function save_csv() {
		// Nonce is already checked
		if ( isset( $_FILES['upload_file']['tmp_name'] ) ) { // phpcs:ignore
			ob_start();
			include esc_url_raw( $_FILES['upload_file']['tmp_name'] ); // phpcs:ignore
			$csvcontents = ob_get_clean();

			\update_option( WPCV_TEXTDOMAIN . '_csv_data', sanitize_text_field( $csvcontents ) );
		} else {
			wp_die( esc_html( 'CSV file is not valid!' ), WPCV_TEXTDOMAIN ); // phpcs:ignore
		}
	}

}
