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

namespace WooCommerce_Postal_codes_validation\Frontend;

use WooCommerce_Postal_codes_validation\Engine\Base;

/**
 * Add Postal codes validation at Checkout page
 */
class Checkout_Validation extends Base {

	/**
	 * Initialize the class.
	 *
	 * @return void|bool
	 */
	public function initialize() {
		parent::initialize();

		\add_filter( 'woocommerce_checkout_fields', array( self::class, 'remove_default_validation' ), 10, 1 );
		\add_action( 'woocommerce_after_checkout_validation', array( self::class, 'validate_postcode' ), 10, 2 );
		\add_action( 'wp_footer', array( self::class, 'js_validate_postcode' ) );
	}

	/**
	 * Remove default WooCommerce Postcode validation on the frontend
	 *
	 * @param array $fields The array with all the Checkout fields of the page.
	 * @since 1.0.0
	 * @return array
	 */
	public static function remove_default_validation( array $fields ) {
	    unset( $fields[ 'billing' ][ 'billing_postcode' ][ 'validate' ] );
	    unset( $fields[ 'shipping' ][ 'shipping_postcode' ][ 'validate' ] );
	    
	    return $fields;
	}

	/**
	 * Display WooCommerce error message
	 *
	 * @param array $fields The array with all the Checkout fields of the page.
	 * @param array $errors The array with all errors.
	 * @since 1.0.0
	 * @return void
	 */
	public static function validate_postcode( array $fields, $errors ) {
		$valid_post_codes = explode( ',', get_option( WPCV_TEXTDOMAIN . '_csv_data' ) );

		if ( in_array( $fields[ 'billing_postcode' ], $valid_post_codes, true ) !== false ) {
            return;
        }

        $errors->add( 'validation', '<strong>Postcode / ZIP</strong> is not a valid' );
	}
	
	public static function js_validate_postcode() {
	    if ( ! is_checkout() ) {
	        return;
        }

		?>
	<script>
	jQuery(function($){
		$( 'body' ).on( 'blur change', '#billing_postcode', function(){
			const wrapper = $(this).closest( '.form-row' );
			if( /^\d+$/.test( $(this).val() ) ) {
				wrapper.addClass( 'woocommerce-validated' );
			} else {
				wrapper.addClass( 'woocommerce-invalid' );
			}
		});
	});
	</script>
		<?php
	}

}
