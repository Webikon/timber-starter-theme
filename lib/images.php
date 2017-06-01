<?php
/**
 * Image enhancements and customizations
 */

// Reset post thumbnail size, because Timmy register its own sizes
set_post_thumbnail_size( 0, 0 );

/**
 * Register Timmy image sizes
 * @return array $image_sizes
 */
function get_image_sizes() {
	$image_sizes = array();

	/**
	 * The thumbnail size is used to show thumbnails in the backend.
	 * You should always have an entry with the 'thumbnail' key.
	 */
	$image_sizes['thumbnail'] = array(
		'resize' => array( 150, 150 ),
		'name' => 'Thumbnail',
		'post_types' => array( 'all' ),
	);

	$image_sizes['medium'] = array(
		'resize' => array( 300 ),
		'name' => 'Medium',
		'post_types' => array( 'all' ),
	);

	$image_sizes['large'] = array(
		'resize' => array( 1000 ),
		'srcset' => array(
			array( 640 ),
			array( 480 ),
		),
		'name' => 'Large',
		'post_types' => array( 'all' ),
	);


	return $image_sizes;
}

/**
 * Add rel="lightbox" to content images links
 * Works nicely with http://lokeshdhakar.com/projects/lightbox2/
 *
 * Source: http://www.wprecipes.com/how-to-automatically-add-rellightbox-to-all-images-embedded-in-a-post/
 */
function wbkn_content_images_lightbox_rel( $content ) {
	global $post;

	$pattern = "/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
	$replacement = '<a$1href=$2$3.$4$5 rel="lightbox" title="' . $post->post_title . '"$6>';
	$content = preg_replace( $pattern, $replacement, $content );

	return $content;
}
add_filter( 'the_content', 'wbkn_content_images_lightbox_rel', 99 );

/**
 * Wrap images with figure tag. Courtesy of Interconnectit http://interconnectit.com/2175/how-to-remove-p-tags-from-images-in-wordpress/
 */
function wbkn_img_unautop( $pee ) {
	$pee = preg_replace( '/<p>\\s*?(<a .*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s', '<figure>$1</figure>', $pee );

	return $pee;
}
add_filter( 'the_content', 'wbkn_img_unautop', 30 );

/**
 * Customized the output of caption, you can remove the filter to restore back to the WP default output.
 * Courtesy of DevPress. http://devpress.com/blog/captions-in-wordpress/
 */
function wbkn_cleaner_caption( $output, $attr, $content ) {
	/* We're not worried abut captions in feeds, so just return the output here. */
	if ( is_feed() ) {
		return $output;
	}

	/* Set up the default arguments. */
	$defaults = array (
		'id'      => '',
		'align'   => 'alignnone',
		'width'   => '',
		'caption' => ''
	);
	/* Merge the defaults with user input. */
	$attr = shortcode_atts( $defaults, $attr );
	/* If the width is less than 1 or there is no caption, return the content wrapped between the [caption]< tags. */
	if ( 1 > $attr['width'] || empty( $attr['caption'] ) ) {
		return $content;
	}
	/* Set up the attributes for the caption <div>. */
	$attributes = ' class="figure ' . esc_attr( $attr['align'] ) . '"';
	/* Open the caption <div>. */
	$output = '<figure' . $attributes . '>';
	/* Allow shortcodes for the content the caption was created for. */
	$output .= do_shortcode( $content );
	/* Append the caption text. */
	$output .= '<figcaption>' . $attr['caption'] . '</figcaption>';
	/* Close the caption </div>. */
	$output .= '</figure>';

	/* Return the formatted, clean caption. */
	return $output;
}
add_filter( 'img_caption_shortcode', 'wbkn_cleaner_caption', 10, 3 );

/**
 * Clean the output of attributes of images in editor. Courtesy of SitePoint. http://www.sitepoint.com/wordpress-change-img-tag-html/
 */
function wbkn_image_tag_class( $class, $id, $align, $size ) {
	$align = 'align' . esc_attr( $align );

	return $align;
}
add_filter( 'get_image_tag_class', 'wbkn_image_tag_class', 0, 4 );

/**
 * Remove width and height in editor, for a better responsive world.
 */
function wbkn_image_editor( $html, $id, $alt, $title ) {
	return preg_replace( array (
			'/\s+width="\d+"/i',
			'/\s+height="\d+"/i',
			'/alt=""/i'
		), array (
			'',
			'',
			'',
			'alt="' . $title . '"'
		), $html );
}
add_filter( 'get_image_tag', 'wbkn_image_editor', 0, 4 );
