<?php
/**
 * Icons helper functions.
 *
 * Icons should be located in theme/assets/images/icons folder
 *
 * @package  WordPress
 */


 /**
  * Wrapper function to get svg icon from a file.
  * Returns inline svg markup.
  *
  * @param type|string $name
  * @return html
  */
 function wbkn_get_icon( $name = '' ) {
 	$file_location = locate_template( 'dist/images/icons/icon-' . $name . '.svg' );

 	if ( ! $file_location ) {
 		$file_location = locate_template( 'assets/images/icons/icon-' . $name . '.svg' ); // fallback for old theme
 	}

 	if ( $file_location ) {
 		return '<span class="icon icon-' . $name . '">' . file_get_contents( $file_location ) . '</span>';
 	} else {
 		var_dump( 'Icon not found' );
 	}
 }

 /**
  * Get all svg icons from theme icons folder.
  *
  * @return array $icons
  */
 function wbkn_get_all_icons() {
 	$icons = array();
 	$icons_dir = get_stylesheet_directory() . '/dist/images/icons';

 	// Read icons folder and every file in it
 	foreach( scandir( $icons_dir ) as $filename ) {
 		// Full path to current icon
 		$path = $icons_dir . '/' . $filename;

 		if ( is_file( $path ) ) {
 			$file_parts = pathinfo( $path );

 			// Check for proper file extension
 			if ( $file_parts['extension'] == 'svg' ) {
 				// Remove .svg extension so we get icon name
 				$name = str_replace( '.svg', '', $filename );

 				// Get icon's file content and save it to array
 				$icons[$name] = '<span class="icon icon-' . $name . '">' . file_get_contents( $path  ) . '</span>';
 			}
 		}
 	}

 	return $icons;
 }
