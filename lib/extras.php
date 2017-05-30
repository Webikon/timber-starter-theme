<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package  WordPress
 */

/**
 * Redirect missing and unnecessary pages.
 */
function wbkn_redirect_missing_archives() {
	global $wp_query, $post;

	if ( is_attachment() ) {
		$post_parent = $post->post_parent;

		if ( $post_parent ) {
			wp_redirect( get_permalink( $post->post_parent ), 301 );
			exit;
		}

		$wp_query->set_404();

		return;
	}

	if ( is_author() || is_date() ) {
		$wp_query->set_404();
	}
}
add_action( 'template_redirect', 'wbkn_redirect_missing_archives' );
