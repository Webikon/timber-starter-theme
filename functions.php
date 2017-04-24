<?php
/**
 * Theme functions and definitions.
 *
 * @package WordPress
 */

/**
 * If the Timber plugin isn't activated, print a notice in the admin.
 */
if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
		echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
	} );

	return;
}

/**
 * Create our version of the TimberSite object
 */
class StarterSite extends TimberSite {
	/**
	 * This function applies some fundamental WordPress setup, as well as our functions to include custom post types and taxonomies.
	 */
	function __construct() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on _s, use a find and replace
		 * to change '_s' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'wbkn', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Editor style for nicer typography in TinyMCE editor.
		if ( WP_DEBUG ) {
			add_editor_style( get_template_directory_uri() . '/dist/css/editor-style.css' );
		} else {
			add_editor_style( get_template_directory_uri() . '/dist/css/editor-style.min.css' );
		}

		// Timber global context.
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );

		// Custom twig functions.
		add_filter( 'get_twig', array( $this, 'add_to_twig' ) );

		// Uncomment any of this if needed.
		add_action( 'init', array( $this, 'register_menus' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		add_action( 'init', array( $this, 'register_widgets' ) );

		parent::__construct();
	}


	/**
	 * Abstracting long chunks of code.
	 *
	 * The following included files only need to contain the arguments and register_whatever functions.
	 * They are applied to WordPress in these functions that are hooked to init above.
	 * The point of having separate files is solely to save space in this file. Think of them as a standard PHP include or require.
	 */
	function register_post_types() {
		require get_template_directory() . '/lib/custom-types.php';
	}

	/**
	 * Get taxonomies registration file.
	 */
	function register_taxonomies() {
		require get_template_directory() . '/lib/taxonomies.php';
	}

	/**
	 * Get menus registration file.
	 */
	function register_menus() {
		require get_template_directory() . '/lib/menus.php';
	}

	/**
	 * Get widget registration file.
	 */
	function register_widgets() {
		require get_template_directory() . '/lib/widgets.php';
	}


	/**
	 * Access data site-wide.
	 * This function adds data to the global context of your site.
	 * In less-jargon-y terms, any values in this function are available on any view of your website.
	 * Anything that occurs on every page should be added here.
	 */
	function add_to_context( $context ) {
		// Our menu occurs on every page, so we add it to the global context.
		$context['menu'] = new TimberMenu();

		// This 'site' context below allows you to access main site information like the site title or description.
		$context['site'] = $this;

		return $context;
	}

	/**
	 * Here you can add your own fuctions to Twig. Don't worry about this section if you don't come across a need for it.
	 * See more here: http://twig.sensiolabs.org/doc/advanced.html
	 *
	 * @param object $twig
	 */
	function add_to_twig( $twig ) {
		$twig->addExtension( new Twig_Extension_StringLoader() );
		$twig->addFilter( 'myfoo', new Twig_Filter_Function( 'myfoo' ) );

		return $twig;
	}
}

new StarterSite();


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wbkn_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'wbkn_content_width', 640 );
}
add_action( 'after_setup_theme', 'wbkn_content_width', 0 );


/**
 * Load css and js.
 */
require get_template_directory() . '/lib/assets.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/lib/extras.php';
