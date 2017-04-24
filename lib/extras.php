<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package  WordPress
 */

/**
 * Flush out the transients used in _s_categorized_blog.
 */
function wbkn_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'wbkn_categories' );
}
add_action( 'edit_category', 'wbkn_category_transient_flusher' );
add_action( 'save_post', 'wbkn_category_transient_flusher' );
