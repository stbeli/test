<?php
/**
 * GeneratePress child theme functions and definitions.
 *
 * Add your custom PHP in this file.
 * Only edit this file if you have direct access to it on your server (to fix errors if they happen).
 */

/**
 * Remove the order field from checkout.
 */
add_filter( 'woocommerce_enable_order_notes_field', '__return_false', 9999 );