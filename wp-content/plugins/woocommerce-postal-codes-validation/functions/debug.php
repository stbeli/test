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
 * Log text inside the debugging plugins.
 *
 * @param string $text The text.
 * @return void
 */
function wpcv_log( string $text ) {
	global $wpcv_debug;
	$wpcv_debug->log( $text );
}
