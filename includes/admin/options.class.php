<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Bbfp_Options' ) ) {
	/**
	 * Bbfp_Options Class
	 *
	 * @since	1.0
	 */
	class Bbfp_Options {


		/**
		 * Constructor
		 *
		 * @return	void
		 * @since	1.0
		 */
		function __construct() {
			$this->init();
		}

		public function init() {
			add_filter('bb_register_options', array( $this, 'options'), 10, 1 );

			if(is_admin()) {
				add_action( 'admin_enqueue_scripts', array( $this, 'adminEnqueueScripts' ) );
			}
        }

		public function adminEnqueueScripts() {
			BestBug_Core_Class::adminEnqueueScripts();
			
			if(isset($_GET['page']) && ($_GET['page'] == BBFP_SLUG || $_GET['page'] == BBFP_SLUG_SETTINGS || $_GET['page'] == BBFP_ALL_FULLPAGE_SLUG || $_GET['page'] == BBFP_ADD_FULLPAGE_SLUG)) {
				BestBug_Core_Options::adminEnqueueScripts();
			}
		}
        
        public function options($options) {
			if( empty($options) ) {
				$options = array();
			}
			
			$posttypes = get_post_types( array( 'public' => true ) );
			unset($posttypes['attachment']);
			$args = array(
				'posts_per_page'  => -1,
				'post_type' => BBFP_POSTTYPE_FULLPAGE,
				'orderby' => 'title',
				'post_status' => 'publish',
				'order' => 'ASC',
			);
			$query = new WP_Query( $args );
			$headers = array('' => esc_html__('None', 'wp_fullpage'));
			if($query->post_count > 0) {
				foreach ($query->posts as $key => $post) {
					$headers[ $post->post_name ] = $post->post_title;
				}
			}
			
			$prefix = BBFP_PREFIX;
			
			return $options;
        }
        
    }
	
	new Bbfp_Options();
}

