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
if ( ! function_exists( 'myhero_start_theme_setup' ) ) :

function myhero_start_theme_setup() {
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
       
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let ClassicPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );

	/*
	 * Enable support for custom logo.
	 *
	 *  @since Myhero 1.0
	 */
	add_theme_support('custom-logo',array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array( 'site-title', 'site-description' ),
       'unlink-homepage-logo' => true,
    ));

    /**
	* Make theme available for translation.
	* Translations can be added to the /languages/ directory.
	*/
    load_theme_textdomain( 'MYHERO', get_template_directory_uri() . '/languages' );

    // This theme uses wp_nav_menu() in two locations.
    register_nav_menus(
        array(
            'primary-menu' => __( 'Primary Main Menu', 'myhero' ),
        )
    );
}
add_action( 'after_setup_theme', 'myhero_start_theme_setup' );
endif;

/**
 * Support for logo upload, output. 
 *
 * @since 1.0.1 
 */
function myhero_theme_custom_logo() {
    $output = '';

    if ( function_exists( 'the_custom_logo' ) ) {
        $custom_logo_id = get_theme_mod( 'custom_logo' );
        $logo           = wp_get_attachment_image_src( $custom_logo_id , 'medium' );

        if ( has_custom_logo() ) {
            $output = '<div class="header-logo">
			<img src="'. esc_url( $logo[0] ) .'" alt="'. get_bloginfo( 'name' ) .'" 
			class="myhero-attachment-logo"/>
			</div>'; 
        } else { 
            $output = ''; 
        }
    }
        // Output sanitized in header to assure all html displays.
        return $output;
}

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

	wp_enqueue_script( 
		'myhero-script', 
		get_template_directory_uri() . '/inc/myhero-script.js', 
		array(), 
		MYHERO_VER, 
		true 
	);
}
add_action( 'wp_enqueue_scripts',       'myhero_theme_enqueue_styles' );

/**
 * Display breadcrumbs navigation for MyHero theme.
 */
function myhero_breadcrumbs() {
	// Do not display on the front page
	if ( is_front_page() ) {
		return;
	}

	$delimiter   = ' &raquo; '; // Separator symbol
	$home_title  = __( 'Home', 'myhero' );
	$before      = '<span class="breadcrumb-current">';
	$after       = '</span>';

	echo '<nav class="breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumb', 'myhero' ) . '">';
	echo '<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( $home_title ) . '</a>' . $delimiter;

	if ( is_category() ) {
		single_cat_title();
	} elseif ( is_single() ) {
		$category = get_the_category();
		if ( ! empty( $category ) ) {
			$last_category = end( $category );
			echo get_category_parents( $last_category->term_id, true, $delimiter );
		}
		echo $before . get_the_title() . $after;
	} elseif ( is_page() && ! is_front_page() ) {
		global $post;
		if ( $post->post_parent ) {
			$ancestors = array_reverse( get_post_ancestors( $post->ID ) );
			foreach ( $ancestors as $ancestor ) {
				echo '<a href="' . esc_url( get_permalink( $ancestor ) ) . '">' . esc_html( get_the_title( $ancestor ) ) . '</a>' . $delimiter;
			}
		}
		echo $before . get_the_title() . $after;
	} elseif ( is_archive() ) {
		echo $before . get_the_archive_title() . $after;
	} elseif ( is_search() ) {
		echo $before . sprintf( __( 'Search Results for: %s', 'myhero' ), get_search_query() ) . $after;
	} elseif ( is_404() ) {
		echo $before . __( 'Page Not Found', 'myhero' ) . $after;
	}

	echo '</nav>';
}

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
 * Registers a widget area.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 * @since 1.0
 */
function myhero_theme_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Sidebar', 'solo' ),
			'id'            => 'sidebar-page',
			'description'   => __( 'Add widgets here to appear in your sidebar.', 'solo' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init',             'myhero_theme_widgets_init' );

/** 
 * Customizer
 * suport footer background & text color
 * header background & color
 * page background & color
 */

/* Adding files here to apply to the following functions below */
require get_template_directory() . '/inc/customizer.php';
