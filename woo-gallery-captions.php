<?php 
/*
Plugin Name: Gallery Captions for WooCommerce
Plugin URI: 
Description: Adds captions to the default WooCommerce gallery on the single-product page.
Version: 1.0
Author: John Beales
Author URI: http://johnbeales.com
Text Domain: jb-gcw
WC tested up to: 3.8

*/


function gcw_insert_captions( $html, $attachment_id ) {

	$captions = '';

	$title = get_post_field( 'post_title', $attachment_id );
	if( !empty( $title ) ) {
		$captions .= '<h5>' . esc_html( $title ) . '</h5>';
	}

	$description = get_post_field( 'post_excerpt', $attachment_id );
	if( !empty( $description ) ) {
		$captions .= '<p>' . esc_html( $description ) . '</p>';
	}

	if( !empty( $captions ) ) {
		$captions = '<div class="gcw-caption">' . $captions . '</div>';
		
		$html = preg_replace('~<\/div>$~', $captions . '</div>', $html );
	}

	return $html;
}

add_filter( 'woocommerce_single_product_image_thumbnail_html', 'gcw_insert_captions', 10, 2 );
