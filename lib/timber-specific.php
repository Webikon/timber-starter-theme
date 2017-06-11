<?php

if ( file_exists( get_template_directory() . '/vendor/autoload.php' ) ) {
	// Load composer files
	require_once( get_template_directory() . '/vendor/autoload.php' );

} else {
	// If the composer autoload not exists, print a notice in the admin.
	add_action( 'admin_notices', function() {
		echo '<div class="error"><p>Timber not found. Make sure you ran <strong>composer install</strong> in your theme.</p></div>';
	} );

	return;
}

// Initialize Timber
$timber = new \Timber\Timber();


/**
 * Access data site-wide.
 * This function adds data to the global context of your site.
 * In less-jargon-y terms, any values in this function are available on any view of your website.
 * Anything that occurs on every page should be added here.
 */
function wbkn_add_to_context( $context ) {
	// Our menu occurs on every page, so we add it to the global context.
	$context['menu'] = new TimberMenu( 'primary' );

	// All registered icons
	$context['icons'] = wbkn_get_all_icons();

	// This 'site' context below allows you to access main site information like the site title or description.
	$context['site'] = new TimberSite();

	return $context;
}
add_filter( 'timber_context', 'wbkn_add_to_context' );

/**
 * Here you can add your own fuctions to Twig. Don't worry about this section if you don't come across a need for it.
 * See more here: http://twig.sensiolabs.org/doc/advanced.html
 *
 * @param object $twig
 */
function wbkn_add_to_twig( $twig ) {
	$twig->addExtension( new Twig_Extension_StringLoader() );
	$twig->addFilter( 'myfoo', new Twig_Filter_Function( 'myfoo' ) );

	return $twig;
}
// add_filter( 'get_twig', 'wbkn_add_to_twig' );
