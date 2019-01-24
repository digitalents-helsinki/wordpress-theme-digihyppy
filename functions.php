<?php
require_once( __DIR__ . '/vendor/autoload.php');
$timber = new Timber\Timber();

/**
 * Sets the directories (inside your theme) to find .twig files
 */
Timber::$dirname = array( 'templates', 'views' );

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;

/**
 * Disable admin bar
 */
show_admin_bar( false );

/**
 * We're going to configure our theme inside of a subclass of Timber\Site
 * You can move this to its own file and include here via php's include("MySite.php")
 */
class Digihyppy extends Timber\Site {
	/** Add timber support. */
	public function __construct() {
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'get_twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );

		// Theme specific settings
		add_action( 'wp_enqueue_scripts', [ $this, 'theme_scripts'], 100);
		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );

		parent::__construct();
	}

  function theme_scripts() {
    $manifest = json_decode(file_get_contents('dist/assets.json', true));
    $main = $manifest->main;
		$home = $manifest->home;
		
		// Javascript
		wp_register_script( 'digihyppy-main', get_template_directory_uri() . '/dist/' . $main->js, false, null );
		wp_register_script( 'digihyppy-home', get_template_directory_uri() . '/dist/' . $home->js, false, null );
		
		// CSS
		wp_register_style('digihyppy-style-main', get_template_directory_uri() . '/dist/' . $main->css, false, null);
		wp_register_style('digihyppy-style-home', get_template_directory_uri() . '/dist/' . $home->css, false, null);
		
    if (is_front_page()){
			wp_enqueue_script('digihyppy-home');
			wp_enqueue_style('digihyppy-style-home');
    } else {
			wp_enqueue_script('digihyppy-main');
			wp_enqueue_style('digihyppy-style-main');
		}
	}

	/** This is where you can register custom post types. */
	public function register_post_types() {

	}
	/** This is where you can register custom taxonomies. */
	public function register_taxonomies() {

	}

	/** This is where you add some context
	 *
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context( $context ) {
		$context['menu'] = new Timber\Menu();
		$context['site'] = $this;
		return $context;
	}

	public function theme_supports() {
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
		add_theme_support(
			'html5', array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats', array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
			)
		);

		add_theme_support( 'menus' );

		/**
		 * Gutenberg
		 */
		add_theme_support( 'gutenberg', array(
			'wide-images' => true,
			'colors' => array(
					 '#EF5656',
					 '#FF9090',
					 '#9C98FF',
					 '#444',
			 )
	 	));
	}

	/** This is where you can add your own functions to twig.
	 *
	 * @param string $twig get extension.
	 */
  function add_to_twig( $twig ) {
		/* this is where you can add your own functions to twig */
		$twig->addExtension( new Twig_Extension_StringLoader() );
		return $twig;
	}

}

new Digihyppy();
