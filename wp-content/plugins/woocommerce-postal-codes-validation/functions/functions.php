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

/**
 * Get the settings of the plugin in a filterable way
 *
 * @since 1.0.0
 * @return array
 */
function wpcv_get_settings() {
	return apply_filters( 'wpcv_get_settings', get_option( WPCV_TEXTDOMAIN . '-settings' ) );
}
