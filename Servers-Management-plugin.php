<?php
/*
Plugin Name: Servers Management
Description: Adds a custom endpoint field to the Advanced tab in WooCommerce settings under Account Endpoints.
Version: 1.0
Author: Your Name
*/

// Ensure the plugin is only loaded in the context of WordPress and WooCommerce
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/* Add custom menu item and endpoint to WooCommerce My-Account page */

function my_custom_endpoints() {
    add_rewrite_endpoint( 'refunds-returns', EP_ROOT | EP_PAGES );
}

add_action( 'init', 'my_custom_endpoints' );

// so you can use is_wc_endpoint_url( 'refunds-returns' )
add_filter( 'woocommerce_get_query_vars', 'my_custom_woocommerce_query_vars', 0 );

function my_custom_woocommerce_query_vars( $vars ) {
	$vars['refunds-returns'] = 'refunds-returns';
	return $vars;
}

function my_custom_flush_rewrite_rules() {
    flush_rewrite_rules();
}

add_action( 'after_switch_theme', 'my_custom_flush_rewrite_rules' );

function my_custom_my_account_menu_items( $items ) {

	$new_item = array( 'refunds-returns' => __( 'Refunds & Returns', 'woocommerce' ) );
	
    // add item in 2nd place
	$items = array_slice($items, 0, 1, TRUE) + $new_item + array_slice($items, 1, NULL, TRUE);

    return $items;

}

add_filter( 'woocommerce_account_menu_items', 'my_custom_my_account_menu_items' );

function my_custom_endpoint_content() {
    //wc_get_template( 'refunds-returns.php');
    include (dirname(__FILE__)."refunds-returns.php");
}

add_action( 'woocommerce_account_refunds-returns_endpoint', 'my_custom_endpoint_content' );
