<?php
/**
 * Get rid of unnecessary WP ballast!
 */

function wbkn_theme_cleanup() {
	// Launch head cleanup
	add_action( 'init', 'wbkn_head_cleanup' );

	// Remove WP version from RSS
	add_filter( 'the_generator', 'wbkn_rss_version' );

	// If comments are not used, remove related styles
	// Remove pesky injected css for recent comments widget
	add_filter( 'wp_head', 'wbkn_remove_wp_widget_recent_comments_style', 1 );
	// Clean up comment styles in the head
	add_action( 'wp_head', 'wbkn_remove_recent_comments_style', 1 );

	// Clean up gallery output in wp
	add_filter( 'gallery_style', 'wbkn_gallery_style' );

	// Remove Emojis
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
}
add_action( 'after_setup_theme', 'wbkn_theme_cleanup' );

/**
 * Clean WP_HEAD
 *
 * Courtesy of http://cubiq.org/clean-up-and-optimize-wordpress-for-your-next-theme
 */
function wbkn_head_cleanup() {
	// If RSS feeds are not used, use this hooks to remove feed links
	// Category feeds
	// remove_action( 'wp_head', 'feed_links_extra', 3 );
	// Post and comment feeds
	// remove_action( 'wp_head', 'feed_links', 2 );

	// EditURI link
	remove_action( 'wp_head', 'rsd_link' );
	// Windows live writer
	remove_action( 'wp_head', 'wlwmanifest_link' );
	// Index link
	remove_action( 'wp_head', 'index_rel_link' );
	// Previous link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	// Start link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	// Links for adjacent posts
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	// WP version
	remove_action( 'wp_head', 'wp_generator' );
	// Remove WP version from css
	add_filter( 'style_loader_src', 'wbkn_remove_wp_assets_version', 0 );
	// Remove WP version from scripts
	add_filter( 'script_loader_src', 'wbkn_remove_wp_assets_version', 0 );
}

/**
 * Remove WP version from RSS
 */
function wbkn_rss_version() {
	return '';
}

/**
 * Remove WP version from assets
 */
function wbkn_remove_wp_assets_version( $src ) {
	if ( strpos( $src, 'ver=' ) ) {
		$src = remove_query_arg( 'ver', $src );
	}

	return $src;
}


/**
 * Remove injected CSS for recent comments widget
 */
function wbkn_remove_wp_widget_recent_comments_style() {
	if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
		remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
	}
}

/**
 * Remove injected CSS from recent comments widget
 */
function wbkn_remove_recent_comments_style() {
	global $wp_widget_factory;

	if ( isset( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'] ) ) {
		remove_action( 'wp_head',
			array ( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
	}
}

/**
 * Remove injected CSS from WP gallery
 */
function wbkn_gallery_style( $css ) {
	return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );
}
