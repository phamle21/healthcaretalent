<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_filter( 'woocommerce_get_price_html', function( $price ) {
	return '';
} );
add_filter( 'woocommerce_cart_item_price', '__return_false' );
add_filter( 'woocommerce_cart_item_subtotal', '__return_false' );

add_filter('woocommerce_is_purchasable', '__return_false');

add_action( 'woocommerce_after_shop_loop_item_title', 'action_function_name_9437' );
function action_function_name_9437(){
	global $product;
	if (!$product->get_price()) {
		echo '<span class="text-contact">'.__('Liên hệ', 'tried').'</span>';
	}
}

add_action( 'woocommerce_before_single_product', 'customise_product_page' );
function customise_product_page() {
    add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
}

add_filter( 'woocommerce_output_related_products_args', 'jk_related_products_args', 20 );
function jk_related_products_args( $args ) {
	$args['posts_per_page'] = 3; // 4 related products
	$args['columns'] = 3; // arranged in 2 columns
	return $args;
}
