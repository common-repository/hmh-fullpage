<?php $this->sortform(); ?>

<table class="wp-list-table widefat">
	<thead>
		<tr>
			<th width="100px"><?php esc_html_e('ID', 'wp_fullpage') ?></th>
			<th><?php esc_html_e('Title', 'wp_fullpage') ?></th>
			<th><?php esc_html_e('Shortcode', 'wp_fullpage') ?></th>
			<th width="150px"><?php esc_html_e('Action', 'wp_fullpage') ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
            foreach ($this->fullpages as $id => $fullPage) {
                ?>
                    <tr>
                        <td><strong><?php echo esc_html($fullPage->ID) ?></strong></td>
                        <td><?php echo esc_html($fullPage->post_title) ?></td>
                        <td>[bbfp_fullpage id="<?php echo esc_attr($fullPage->ID) ?>"]</td>
                        <td>
                            <a class="button success" title="Edit" href="<?php echo admin_url('admin.php?page=' . BBFP_ADD_FULLPAGE_SLUG . '&ID=' . $fullPage->ID) ?>">
                                <span class="dashicons dashicons-edit"></span>
                            </a>

                            <form class="bb_delete_form" action="" method="post">
                                <input type="hidden" name="delID" id="delID" value="<?php echo esc_html($fullPage->ID) ?>" />
                                <button onclick="javascript: return confirm('<?php esc_html_e('Are you sure delete this FullPage shortcode?', 'wp_fullpage') ?>');" type="submit" class="button danger">
                                    <span class="dashicons dashicons-trash"></span></button>
                            </form>

                        </td>
                    </tr>
                <?php

        }
        ?>
	</tbody>
</table>

<?php $this->sortform(); ?>
