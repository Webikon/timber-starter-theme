<?php
/**
 * Theme assets.
 *
 * @package  WordPress
 */

/**
 * Enqueue scripts and styles.
 */
function wbkn_assets() {
	// Enqueue our stylesheet and JS file with a jQuery dependency.
	// Load different assets depending on the environment (WP_DEBUG on LIVE env should be disabled).
	if ( WP_DEBUG ) {
		$min = '';
	} else {
		$min = '.min';
	}

	// Enqueue external assets here
	wp_enqueue_script( 'wbkn-picturefill', get_template_directory_uri() . '/dist/js/vendor/picturefill.' . $min . 'js', array( 'jquery' ), '0.0.1', true );

	// These assets should be loaded last, so enqueue external assets above this line
	wp_enqueue_style( 'wbkn-style', get_template_directory_uri() . '/dist/css/style.' . $min . 'css', array(), '0.0.1' );
	wp_enqueue_script( 'wbkn-theme', get_template_directory_uri() . '/dist/js/theme.' . $min . 'js', array( 'jquery' ), '0.0.1', true );

	// Delete this if comments are not used
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wbkn_assets' );

/**
 * Asynchronously load defined scripts
 *
 * Source: https://matthewhorne.me/defer-async-wordpress-scripts/
 */
function wbkn_async_script_atts( $tag, $handle ) {
	// add script handles to the array below
	$scripts_to_async = array( 'wbkn-picturefill' );

	foreach ( $scripts_to_async as $async_script ) {
		if ( $async_script == $handle ) {
			return str_replace( ' src', ' async="async" src', $tag );
		}
	}

	return $tag;
}
add_filter( 'script_loader_tag', 'wbkn_async_script_atts', 10, 2 );
