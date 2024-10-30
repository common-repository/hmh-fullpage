<?php
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

if (!class_exists('Bbfp_FullPage_Admin_Class')) {
    /**
     * Bbfp_FullPage_Admin_Class Class
     *
     * @since	1.0
     */
    class Bbfp_FullPage_Admin_Class
    {

        public $page_title;

        public $orderby;
        public $order;

        public $fullpages;

        /**
         * Constructor
         *
         * @return	void
         * @since	1.0
         */
        function __construct()
        {
            $this->init();
        }

        public function init()
        {

            add_filter('bb_register_options', array($this, 'fullpage_posttype_settings'), 10, 1);
            if (is_admin()) {
                add_action('admin_enqueue_scripts', array($this, 'adminEnqueueScripts'));
            }
            add_action('wp_enqueue_scripts', array($this, 'enqueueScripts'));

            add_action('admin_menu', array($this, 'fullpages'));

        }

        public function adminEnqueueScripts()
        {

        }

        public function enqueueScripts()
        {

        }

        public function fullpages()
        {

            if (isset($_POST['delID'])) {
                $delID = sanitize_text_field($_POST['delID']);
                $del = wp_delete_post($delID, true);
            }

            $menu = array(
                'page_title' => esc_html__('All FullPages', 'wp_fullpage'),
                'menu_title' => esc_html__('All FullPages', 'wp_fullpage'),
                'capability' => 'manage_options',
                'menu_slug' => BBFP_SLUG,
                'icon' => BBFP_URL . 'assets/images/FullPage.png',
                'position' => 20,
            );
            $this->page_title = $menu['page_title'];
            add_menu_page(
                $menu['page_title'],
                $menu['menu_title'],
                $menu['capability'],
                $menu['menu_slug'],
                array(&$this, 'view'),
                $menu['icon'],
                $menu['position']
            );
            add_submenu_page(
                BBFP_ALL_FULLPAGE_SLUG,
                esc_html__('All FullPages', 'wp_fullpage'),
                esc_html__('All FullPages', 'wp_fullpage'),
                $menu['capability'],
                $menu['menu_slug'],
                array(&$this, 'view')
            );
        }

        public function view()
        {

            $this->fullpages = get_posts(array(
                'numberposts' => -1,
                'post_type' => BBFP_POSTTYPE_FULLPAGE,
                'orderby' => $this->orderby,
                'order' => $this->order,
            ));

            BESTBUG_HELPER::begin_wrap_html($this->page_title);
            include 'templates/fullpages.view.php';
            BESTBUG_HELPER::end_wrap_html();
        }

        public function sortform(){
			?>
			<div class="bb-row">
			    <div class="bb-col">
			        <a href="<?php echo admin_url( 'admin.php?page=' . BBFP_ADD_FULLPAGE_SLUG ) ?>" class="button success"><span class="dashicons dashicons-plus-alt"></span><?php esc_html_e('Add FullPage Shortcode', 'wp_fullpage') ?></a>
			    </div>
			</div>
			<?php
        }
        
        public function fullpage_posttype_settings($options){
            if( empty($options) ) {
				$options = array();
            }
            $all_sections = get_posts(array(
                'numberposts' => -1,
                'post_type' => BBFP_POSTTYPE_SECTION,
            ));
            $sections = array();
            if(!empty($all_sections)) {
                foreach ($all_sections as $key => $section) {
                    $sections[$section->ID] = $section->post_title;
                }
            }

            $prefix = BBFP_PREFIX;

			$button_text = (isset($_REQUEST['ID']) && !empty($_REQUEST['ID']))?esc_html('Update FullPage Shortcode', 'wp_fullpage'):esc_html('Add FullPage Shortcode', 'wp_fullpage');
			$options[] = array(
				'type' => 'post_fields',
				'button_text' => $button_text,
				'ajax_action' => 'bb_save_post',
				'menu' => array(
					// add_submenu_page || add_menu_page
					'type' => 'add_submenu_page',
					'parent_slug' => BBFP_SLUG,
					'page_title' => esc_html('Add FullPage Shortcode', 'wp_fullpage'),
					'menu_title' => esc_html('Add FullPage', 'wp_fullpage'),
					'capability' => 'manage_options',
					'menu_slug' => BBFP_ADD_FULLPAGE_SLUG,
				),
				'fields' => array(
					array(
						'type'       => 'hidden',
						'param_name' => 'ID',
						'value'      => (isset($_REQUEST['ID']) && !empty($_REQUEST['ID']))?esc_attr($_REQUEST['ID']):'',
					),
					array(
						'type'       => 'hidden',
						'param_name' => 'post_type',
						'value'      => BBFP_POSTTYPE_FULLPAGE,
                    ),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Title', 'wp_fullpage' ),
						'param_name' => 'post_title',
						'value'      => '',
					),
                    array(
                        'type' => 'multi_select',
                        'heading' => esc_html__('Choose Sections', 'wp_fullpage'),
                        'value' => $sections,
                        'param_name' => $prefix . 'sections',
                        'std' => array(),
                        'description' => esc_html__('Choose Sections to show.', 'wp_fullpage'),
                    ),
                    array(
						'type'       => 'toggle',
						'heading'    => esc_html__( 'Without anchor links (same URL)', 'wp_fullpage' ),
						'param_name' => $prefix . 'lockAnchors',
						'value'      => 'no',
						'description' => esc_html('', 'wp_fullpage'),
                    ),
                    array(
						'type'       => 'toggle',
						'heading'    => esc_html__( 'Turn on navigation?', 'wp_fullpage' ),
						'param_name' => $prefix . 'navigation',
						'value'      => 'no',
						'description' => esc_html('', 'wp_fullpage'),
                    ),
                    array(
						'type'       => 'toggle',
						'heading'    => esc_html__( 'Is navigationPosition left?', 'wp_fullpage' ),
						'param_name' => $prefix . 'navigationPosition',
						'value'      => 'no',
                        'description' => esc_html('', 'wp_fullpage'),
                        'dependency'  => array( 'element' => $prefix . 'navigation', 'value' => array( 'yes' ) ),
                    ),
                    array(
						'type'       => 'toggle',
						'heading'    => esc_html__( 'navigationTooltips', 'wp_fullpage' ),
						'param_name' => $prefix . 'navigationTooltips',
						'value'      => 'no',
                        'description' => esc_html('', 'wp_fullpage'),
                        'dependency'  => array( 'element' => $prefix . 'navigation', 'value' => array( 'yes' ) ),
                    ),
                    array(
						'type'       => 'toggle',
						'heading'    => esc_html__( 'showActiveTooltip', 'wp_fullpage' ),
						'param_name' => $prefix . 'showActiveTooltip',
						'value'      => 'no',
                        'description' => esc_html('', 'wp_fullpage'),
                        'dependency'  => array( 'element' => $prefix . 'navigationTooltips', 'value' => array( 'yes' ) ),
                    ),
                    array(
						'type'       => 'toggle',
						'heading'    => esc_html__( 'KeyboardScrolling', 'wp_fullpage' ),
						'param_name' => $prefix . 'keyboardScrolling',
						'value'      => 'no',
						'description' => esc_html('', 'wp_fullpage'),
                    ),
                    array(
						'type'       => 'toggle',
						'heading'    => esc_html__( 'Continuous Vertical', 'wp_fullpage' ),
						'param_name' => $prefix . 'continuousVertical',
						'value'      => 'no',
						'description' => esc_html('', 'wp_fullpage'),
                    ),
                    array(
						'type'       => 'toggle',
						'heading'    => esc_html__( 'Loop top', 'wp_fullpage' ),
						'param_name' => $prefix . 'loop-top',
						'value'      => 'no',
						'description' => esc_html('Defines whether scrolling up in the first section should scroll to the last one or not', 'wp_fullpage'),
                    ),
                    array(
						'type'       => 'toggle',
						'heading'    => esc_html__( 'Loop bottom', 'wp_fullpage' ),
						'param_name' => $prefix . 'loop-bottom',
						'value'      => 'no',
						'description' => esc_html('Defines whether scrolling down in the last section should scroll to the first one or not.', 'wp_fullpage'),
                    ),
                    array(
                        'type'       => 'number',
                        'heading'    => esc_html__( 'responsiveWidth', 'wp_fullpage' ),
                        'param_name' => $prefix. 'responsiveWidth',
                        'value'      => '900',
                        'description' => esc_html('A normal scroll will be used under the defined width in pixels.', 'wp_fullpage'),
                    ),
                    array(
                        'type'       => 'number',
                        'heading'    => esc_html__( 'responsiveHeight', 'wp_fullpage' ),
                        'param_name' => $prefix. 'responsiveHeight',
                        'value'      => '400',
                        'description' => esc_html(' A normal scroll will be used under the defined height in pixels.', 'wp_fullpage'),
                    ),
                    array(
                        'type'       => 'number',
                        'heading'    => esc_html__( 'touchSensitivity', 'wp_fullpage' ),
                        'param_name' => $prefix. 'touchSensitivity',
                        'value'      => '5',
                        'description' => esc_html('Defines a percentage of the browsers window width/height, and how far a swipe must measure for navigating to the next section / slide', 'wp_fullpage'),
                    ),
                    array(
						'type'       => 'toggle',
						'heading'    => esc_html__( 'scrollBar', 'wp_fullpage' ),
						'param_name' => $prefix . 'scrollBar',
						'value'      => 'no',
						'description' => esc_html('', 'wp_fullpage'),
                    ),
                    array(
						'type'       => 'toggle',
						'heading'    => esc_html__( 'autoScrolling', 'wp_fullpage' ),
						'param_name' => $prefix . 'autoScrolling',
						'value'      => 'yes',
						'description' => esc_html('', 'wp_fullpage'),
                    ),
                    array(
						'type'       => 'number',
						'heading'    => esc_html__( 'ScrollingSpeed', 'wp_fullpage' ),
						'param_name' => $prefix . 'scrollingSpeed',
						'value'      => '700',
                        'description' => esc_html('', 'wp_fullpage'),
                        'dependency'  => array( 'element' => $prefix . 'autoScrolling', 'value' => array( 'yes' ) ),
                    ),
				),
            );
            return $options;
        }

    }

    new Bbfp_FullPage_Admin_Class();
}

