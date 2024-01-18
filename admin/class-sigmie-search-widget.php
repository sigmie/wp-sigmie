<?php

class Sigmie_Search_Widget extends WP_Widget
{
	// The construct part
	function __construct()
	{
		parent::__construct(
			'sigmie_search_widget', // Base ID
			__('Sigmie Search', 'sigmie'),
			array('description' => __('Sigmie search widget for WordPress', 'sigmie'),)
		);
	}

	public function widget($args, $instance)
	{
		echo do_shortcode('[sigmie_search_bar]');
	}

	public function form($instance)
	{
		if (isset($instance['title'])) {
			$title = $instance['title'];
		} else {
			$title = __('New title', 'wpb_widget_domain');
		}
		// Widget admin form
?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
<?php
	}

	// Updating widget replacing old instances with new
	public function update($new_instance, $old_instance)
	{
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';

		return $instance;
	}
}
