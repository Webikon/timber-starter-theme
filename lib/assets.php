<?php
/**
 * Theme assets.
 *
 * @package  WordPress
 */

/**
 * Enqueue scripts and styles.
 */
function wbkn_scripts() {
	// Enqueue our stylesheet and JS file with a jQuery dependency.
	// Load different assets depending on the environment (WP_DEBUG on LIVE env should be disabled).
	if ( WP_DEBUG ) {
		wp_enqueue_style( 'wbkn-style', get_template_directory_uri() . '/dist/css/style.css', array(), '0.0.1' );
		wp_enqueue_script( 'wbkn-theme', get_template_directory_uri() . '/dist/js/theme.js', array( 'jquery' ), '0.0.1', true );
	} else {
		wp_enqueue_style( 'wbkn-style', get_template_directory_uri() . '/dist/css/style.min.css', array(), '0.0.1' );
		wp_enqueue_script( 'wbkn-theme', get_template_directory_uri() . '/dist/js/theme.min.js', array( 'jquery' ), '0.0.1', true );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wbkn_scripts' );
