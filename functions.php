<?php
/** 
 * Functions for theme MyHero
 * Sets up theme defaults and registers support for various WordPress features.
 * 
 * @package    ClassicPress
 * @subpackage MyHero
 * @since      1.0.0
 *
 */
 if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if ( !defined ( 'MYHERO_VER' ) ) { define ( 'MYHERO_VER', '1.0.0' ); }

/** 
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * Create your own myhero_child_setup() function to override in a child theme.
 * 
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * @since Hello Theme 1.0
 */
if ( ! function_exists( 'myhero_theme_setup' ) ) :

function myhero_theme_setup() {
    /**
     * Not used in ClassicPress < 2.0 
     * to output valid HTML5.
     */ 
    if ( function_exists( 'is_classicpress' ) && version_compare( '2.0', $cp_version, '<' ) ) {
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        )); 
    }
           
    /**
	* Make theme available for translation.
	* Translations can be added to the /languages/ directory.
	*/
    load_theme_textdomain( 'hello-theme', get_template_directory_uri() . '/languages' );

    // This theme uses wp_nav_menu() in two locations.
    register_nav_menus(
        array(
            'primary-menu' => __( 'Primary Main Menu', 'myhero' ),
        )
    );
}

add_action( 'after_setup_theme', 'myhero_theme_setup' );
endif;


/**
 * `wp_body_open` Tag may or may not be needed but accommodate for it.
 * 
 * @since 1.0
 */
if ( ! function_exists( 'wp_body_open' ) ) :
    /**
    * Add backwards compatibility support for wp_body_open function.
    */
    function wp_body_open() {
        do_action( 'wp_body_open' );
    }
endif;

/** 
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 *
 * @since 1.0
 */
function myhero_theme_content_width()
{
	$GLOBALS['content_width'] = apply_filters( 'myhero_content_width', 680 );
}
add_action( 'after_setup_theme',        'myhero_theme_content_width', 0 ); 

/** 
 * Enqueues scripts and styles.
 *
 * @since 1.0.0 
 */
function myhero_theme_enqueue_styles() {
	wp_enqueue_style( 
		'myhero-style', 
		get_stylesheet_directory_uri() .'/style.css',
		array(),
		MYHERO_VER
	);
    
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 
			'comment-reply' 
		);
	}
}
add_action( 'wp_enqueue_scripts',       'myhero_theme_enqueue_styles' );

/**
 * Getting mods to output to hero section
 * @since 1.0.0
 * @return Array
 * 
 */

    /**
 * Retrieve all Hero section settings in a single array.
 *
 * @return array
 */
function myhero_get_hero_mods() {
	$text_domain = 'myhero'; // Updated text domain from hello-theme

	return array(
		'title'          => get_theme_mod( 'hero_title', get_bloginfo( 'name' ) ),
		'subtitle'       => get_theme_mod( 'hero_subtitle', get_bloginfo( 'description' ) ),
		'btn_prim_text'  => get_theme_mod( 'hero_btn_primary_text', __( 'Get Started', $text_domain ) ),
		'btn_prim_url'   => get_theme_mod( 'hero_btn_primary_url', '#primary-cta' ),
		'btn_sec_text'   => get_theme_mod( 'hero_btn_secondary_text', __( 'Learn More', $text_domain ) ),
		'btn_sec_url'    => get_theme_mod( 'hero_btn_secondary_url', '#secondary-cta' ),
		'bg_type'        => get_theme_mod( 'hero_bg_type', 'none' ),
		'bg_image'       => get_theme_mod( 'hero_bg_image', '' ),
		'bg_video'       => get_theme_mod( 'hero_bg_video', '' ),
	);
}

/** 
 * Customizer
 * suport footer background & text color
 * header background & color
 * page background & color
 */

/* Adding files here to apply to the following functions below */
require get_template_directory() . '/inc/customizer.php';
