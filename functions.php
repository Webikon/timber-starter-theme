<?php
/**
 * Theme functions and definitions.
 *
 * @package WordPress
 */

/*
* Get Timber setup file.
*/
require get_template_directory() . '/lib/timber-specific.php';

/*
* Get Theme cleanup file.
*/
require get_template_directory() . '/lib/cleanup.php';

/*
* Get Theme setup file.
*/
require get_template_directory() . '/lib/theme-setup.php';

/*
* Get CPT registration file.
*/
require get_template_directory() . '/lib/cpts.php';

/**
* Get taxonomies registration file.
*/
require get_template_directory() . '/lib/taxonomies.php';

/**
 * Load css and js.
 */
require get_template_directory() . '/lib/assets.php';

/**
 * Get Widgets registrations.
 */
require get_template_directory() . '/lib/widgets.php';

/**
 * Get Menus registrations.
 */
require get_template_directory() . '/lib/menus.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/lib/extras.php';

/**
 * Image enhancements and customizations.
 */
require get_template_directory() . '/lib/images.php';

/**
 * Icons helper functions.
 */
require get_template_directory() . '/lib/icons.php';
