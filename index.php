<?php
/*
Plugin Name: HMH Fullpage Scroll
Description: The fullPage.js plugin for WordPress
Author: Hameha
Version: 1.0
Author URI: https://codecanyon.net/user/bestbug/portfolio
Text Domain: wp_fullpage
Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

defined( 'BBFP_URL' ) or define('BBFP_URL', plugins_url( '/', __FILE__ ));
defined( 'BBFP_PATH' ) or define('BBFP_PATH', basename( dirname( __FILE__ )));
defined( 'BBFP_FULLPATH' ) or define('BBFP_FULLPATH', plugins_url( '/', __FILE__ ));
defined( 'BBFP_TEXTDOMAIN' ) or define('BBFP_TEXTDOMAIN', plugins_url( '/', __FILE__ ));

defined( 'BBFP_PREFIX' ) or define('BBFP_PREFIX', 'bbfp_fullpage_');
defined( 'BBFP_VERSION' ) or define('BBFP_VERSION', '1.0');

// POSTTYPES
defined( 'BBFP_POSTTYPE_SECTION' ) or define('BBFP_POSTTYPE_SECTION', 'bbfp_section');
defined( 'BBFP_POSTTYPE_FULLPAGE' ) or define('BBFP_POSTTYPE_FULLPAGE', 'bbfp_fullpage');

// PAGE SLUG
defined( 'BBFP_SLUG' ) or define('BBFP_SLUG', 'bbfp_fullpage');
defined( 'BBFP_SLUG_SETTINGS' ) or define('BBFP_SLUG_SETTINGS', 'bbfp_settings');
defined( 'BBFP_ALL_FULLPAGE_SLUG' ) or define('BBFP_ALL_FULLPAGE_SLUG', 'bbfp_all_fullpages');
defined( 'BBFP_ADD_FULLPAGE_SLUG' ) or define('BBFP_ADD_FULLPAGE_SLUG', 'bbfp_add_fullpage');

// SHORTCODES
defined( 'BBFP_SHORTCODE' ) or define('BBFP_SHORTCODE', 'bbfp_fullpage');

// METABOXES
defined( 'BBFP_METABOX_CHILD_SECTIONS' ) or define('BBFP_METABOX_CHILD_SECTIONS', '_bbfp_child_sections') ;

include_once 'includes/functions.php';

if ( ! class_exists( 'Bbfp_Class' ) ) {
	/**
	 * Bbfp_Class Class
	 *
	 * @since	1.0
	 */
	class Bbfp_Class {
		/**
		 * Constructor
		 *
		 * @return	void
		 * @since	1.0
		 */
		function __construct() {
			// Load core
			if(!class_exists('BestBug_Core_Class')) {
				include_once 'bestbugcore/index.php';
			}
			BestBug_Core_Class::support('options');
			BestBug_Core_Class::support('posttypes');
			
			include_once 'includes/index.php';
			
			if(is_admin()) {
				include_once 'includes/admin/index.php';
			}
			
			include_once 'includes/shortcodes/index.php';
			
            add_action( 'init', array( $this, 'init' ) );
		}

		public function init() {
			
			// Load enqueueScripts
			if(is_admin()) {
				add_action( 'admin_enqueue_scripts', array( $this, 'adminEnqueueScripts' ) );
			}
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueueScripts' ) );

        }

		public function adminEnqueueScripts() {
		
		}

		public function enqueueScripts() {
		
		}

		public function loadTextDomain() {
			load_plugin_textdomain( BBFP_TEXTDOMAIN, false, BBFP_PATH . '/languages/' );
		}

	}
	new Bbfp_Class();
}
