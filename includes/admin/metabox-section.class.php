<?php
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

if (!class_exists('Bbfp_Section_MetaBox_Class')) {
    /**
     * Bbfp_Section_MetaBox_Class Class
     *
     * @since	1.0
     */
    class Bbfp_Section_MetaBox_Class
    {

        /**
         * Constructor
         *
         * @return	void
         * @since	1.0
         */
        function __construct()
        {
            add_action('add_meta_boxes', array($this, 'add_metabox'));
            add_action('save_post', array($this, 'save_metabox'));
            $this->init();
        }

        public function init()
        {

            if (is_admin()) {
                add_action('admin_enqueue_scripts', array($this, 'adminEnqueueScripts'));
            }
            add_action('wp_enqueue_scripts', array($this, 'enqueueScripts'));

        }

        public function adminEnqueueScripts()
        {
            BESTBUG_CORE_CLASS::adminEnqueueScripts();
            wp_enqueue_script('chosen', BESTBUG_CORE_URL . '/assets/admin/libs/chosen/chosen.jquery.min.js', array('jquery'), BESTBUG_CORE_VERSION, true);
            wp_enqueue_style('chosen', BESTBUG_CORE_URL . '/assets/admin/libs/chosen/chosen.css');
        }

        public function enqueueScripts()
        {
            wp_enqueue_script( 'order', BBFP_URL . '/assets/js/script.js', array( 'jquery' ), '1.0', true );
        }

        public function add_metabox()
        {
            add_meta_box('bbfp_section_metabox', 'Sections Settings', array($this, 'section_metabox'), BBFP_POSTTYPE_SECTION);
        }


        public function section_metabox($post)
        {
            $_bbfp_child_sections = (array) get_post_meta($post->ID, '_bbfp_child_sections', true);
            $_bbfp_background_color = get_post_meta($post->ID, '_bbfp_background_color', true);
            $_bbfp_background_image = get_post_meta($post->ID, '_bbfp_background_image', true);

            wp_nonce_field('bbfp_section_verify', 'bbfp_section_nonce');
            ?>
            <table class="widefat bb-table-metabox">
                <tr>
                    <td width="150px"><label class="bbfb-metabox-label" for="_bbfb_pages"><?php esc_html_e('Choose child sections', 'wp_fullpage') ?></label></td>
                    <td>
                        <?php 
                        $all_sections = get_posts(array(
                            'post_status' => 'publish',
                            'numberposts' => -1,
                            'post_type' => BBFP_POSTTYPE_SECTION,
                            'orderby' => $this->orderby,
                            'order' => $this->order,
                            'exclude' => get_the_ID(),
                        ));
                        ?>
                        <select name="_bbfp_child_sections[]" multiple="multiple" class="bb-chosen-select" id="_bbfp_child_sections">
                            <?php foreach ($all_sections as $key => $section) { ?>
                                <option value="<?php echo esc_attr($section->ID) ?>" <?php if (in_array($section->ID, $_bbfp_child_sections)) echo 'selected'; ?> ><?php echo esc_html($section->post_title) ?></option>
                            <?php 
                            } ?>
                    </td>
                </tr>
                <tr>
                    <td><?php esc_html_e('Choose background color', 'wp_fullpage') ?></label></td>
                    <td>
                        <input name="_bbfp_background_color" value="<?php echo esc_attr($_bbfp_background_color); ?>" type="text" class="bb-colorpicker" data-alpha="true" >
                    </td>
                </tr>
                <tr>
				<td><label class="bbfb-metabox-label" for="_bb_footer_reveal_footer"><?php esc_html_e('Image', 'wp_fullpage') ?></label></td>
				<td>
					<div class="bb-field bb-attach">
							<div class="bb-upload-image <?php if(isset($_bbfp_background_image) && $_bbfp_background_image) echo 'uploaded'; ?>" <?php echo BestBug_Helper::get_background_image($_bbfp_background_image) ?>>
								<span class="bb-btn-clear"><span class="dashicons dashicons-no"></span></span>
								<span class="bb-btn-add"><span class="dashicons dashicons-plus"></span></span>
								<input id="_bbfp_background_image" name="_bbfp_background_image" type="hidden" value="<?php echo esc_attr($_bbfp_background_image); ?>" />	
							</div>
					</div>
				</td>
            </tr>
            
            </table>
            <?php
        }

        public function save_metabox($post_id)
        {
            $bbfp_section_nonce = $_POST['bbfp_section_nonce'];
            if (!wp_verify_nonce($bbfp_section_nonce, 'bbfp_section_verify')) {
                return;
            }

            if (isset($_POST['_bbfp_child_sections'])) {
                if(empty($_POST['_bbfp_child_sections'])) {
                    delete_post_meta($post_id, '_bbfp_child_sections');
                } else {
                    update_post_meta($post_id, '_bbfp_child_sections', sanitize_text_field($_POST['_bbfp_child_sections']));
                }
            } else {
                delete_post_meta($post_id, '_bbfp_child_sections');
            }
            if (isset($_POST['_bbfp_background_color'])) {
                update_post_meta($post_id, '_bbfp_background_color', sanitize_text_field($_POST['_bbfp_background_color']));
            }
            if (isset($_POST['_bbfp_background_image'])) {
                update_post_meta($post_id, '_bbfp_background_image', sanitize_text_field($_POST['_bbfp_background_image']));
            }
        }

    }

    new Bbfp_Section_MetaBox_Class();
}
