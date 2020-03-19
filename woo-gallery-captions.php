<?php
/**
 * Gallery Captions for WooCommerce
 *
 * @package WooGalleryCaptions
 *
 * Plugin Name: Gallery Captions for WooCommerce
 * Plugin URI:
 * Description: Adds captions to the default WooCommerce gallery on the single-product page.
 * Version: 1.0
 * Author: John Beales
 * Author URI: https://johnbeales.com
 * Text Domain: woo-gallery-captions
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * WC tested up to: 4.0
 * WC requires at least: 3.4
 *
 * Woo: 5502332:a8b3958b67b6d4afefe1398b6a056044
 * 
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Alters the HTML using the woocommerce_single_product_image_thumbnail_html
 * filter to add captions.
 *
 * @param  string $html          The HTML input that gets the captions inserted
 *                               into it.
 * @param  int    $attachment_id The Post ID of the image that the $html is showing.
 * @return string                The HTML to show the image, with caption HTML added.
 */
function gcw_insert_captions( $html, $attachment_id ) {

	$captions = '';

	$title = get_post_field( 'post_title', $attachment_id );
	if ( ! empty( $title ) ) {
		$captions .= '<h5>' . esc_html( $title ) . '</h5>';
	}

	$caption = get_post_field( 'post_excerpt', $attachment_id );
	if ( ! empty( $caption ) ) {
		$captions .= '<p>' . esc_html( $caption ) . '</p>';
	}

	if ( ! empty( $captions ) ) {
		$captions = '<div class="gcw-caption">' . $captions . '</div>';
		$html     = preg_replace( '~<\/div>$~', $captions . '</div>', $html );
	}

	return $html;
}

add_filter( 'woocommerce_single_product_image_thumbnail_html', 'gcw_insert_captions', 10, 2 );

/**
 * Enqueue Javascript that switches captions when WooCommerce switches the image
 * when a new variation is selected.
 *
 * @return void
 */
function gcw_enquque_js() {

	// check if WooCommerce is actually running.
	if ( ! did_action( 'before_woocommerce_init' ) ) {
		return;
	}
	if ( is_product() ) {
		$product = wc_get_product();
		if ( $product->get_type() === 'variable' ) {
			wp_enqueue_script( 'gcw-variable-product', plugins_url( 'js/gcw-variable-product.js', __FILE__ ), array( 'jquery' ), '1', true );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'gcw_enquque_js' );



/**
 * If this extension was just activated this shows an Admin Notice saying the
 * plugin was activated and that no more congifuration is needed.
 *
 * @return void
 */
function gcw_maybe_show_activated_notice() {
	$do_notice = get_transient( 'gcw-do-welcome' );
	if ( $do_notice ) {
		$notice_text = __( 'Gallery Captions for WooCommerce is now active. No more configuration is required.', 'woo-gallery-captions' );
		echo '<div class="notice notice-success"><p>' . esc_html( $notice_text ) . '</p></div>';
		delete_transient( 'gcw-do-welcome' );
	}
}
add_action( 'admin_notices', 'gcw_maybe_show_activated_notice' );


/**
 * Sets the transient that tells the plugin to show the activated notice.
 *
 * @return void
 */
function gcw_add_activated_notice() {
	set_transient( 'gcw-do-welcome', 'do_welcome' );
}
register_activation_hook( __FILE__, 'gcw_add_activated_notice' );



