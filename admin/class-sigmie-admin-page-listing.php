<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/nicoorfi
 * @since      1.0.0
 *
 * @package    Sigmie
 * @subpackage Sigmie/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Sigmie
 * @subpackage Sigmie/admin
 * @author     Nico Orfanos <nico@sigmie.com>
 */
class Sigmie_Admin_Page_Listing
{
	/**
	 * Admin page slug.
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 * @since  1.0.0
	 *
	 * @var string
	 */
	private $slug = 'sigmie-listing-page';

	/**
	 * Admin page capabilities.
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 * @since  1.0.0
	 *
	 * @var string
	 */
	private $capability = 'manage_options';

	/**
	 * Admin page section.
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 * @since  1.0.0
	 *
	 * @var string
	 */
	private $section = 'sigmie_section_listing';

	/**
	 * Admin page option group.
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 * @since  1.0.0
	 *
	 * @var string
	 */
	private $option_group = 'sigmie_listing';

	/**
	 * Algolia_Admin_Page_Native_Search constructor.
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 * @since  1.0.0
	 *
	 * @param Algolia_Plugin $plugin The Algolia_Plugin instance.
	 */
	public function __construct()
	{
		add_action('admin_menu', array($this, 'add_page'), 11);
		add_action('admin_init', array($this, 'add_settings'));
		add_action('admin_notices', array($this, 'display_errors'));
	}

	/**
	 * Add submenu page.
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 * @since  1.0.0
	 */
	public function add_page()
	{
		add_submenu_page(
			'sigmie',
			esc_html__('Product listing', 'sigmie'),
			esc_html__('Product listing', 'sigmie'),
			$this->capability,
			$this->slug,
			array($this, 'display_page'),
		);
	}

	/**
	 * Add settings.
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 * @since  1.0.0
	 */
	public function add_settings()
	{
		// Create the settings section
		add_settings_section(
			$this->section,
			null,
			array($this, 'print_section_settings'),
			$this->slug
		);

		$fields = [
			'filters_order' => esc_html__('Filter order', 'sigmie'),
		];

		foreach ($fields as $field_key => $field_label) {
			add_settings_field(
				$field_key,
				$field_label,
				array($this, $field_key . '_callback'),
				$this->slug,
				$this->section
			);

			register_setting(
				$this->option_group,
				'sigmie_' . $field_key,
				array($this, 'sanitize_' . $field_key)
			);
		}
	}

	public function sanitize_filters_order($value)
	{
		return sanitize_text_field($value);
	}

	public function filters_order_callback()
	{
		$attributesJson = (string) get_option('sigmie_filters_order', '[]');

		$existingAttributes = json_decode($attributesJson, true);

		$attributes = wc_get_attribute_taxonomies();

		usort($attributes, function ($a, $b) use ($existingAttributes) {
			$pos_a = array_search($a->attribute_name, $existingAttributes);
			$pos_b = array_search($b->attribute_name, $existingAttributes);
			if ($pos_a === false) {
				return 1;
			}
			if ($pos_b === false) {
				return -1;
			}
			return $pos_a - $pos_b;
		});

		echo '<ul id="sigmie_attributes_sortable">';
		foreach ($attributes as $attribute) {
			$selected = in_array($attribute->attribute_name, $existingAttributes) ? ' checked="checked"' : '';
			echo '<li class="ui-state-default"><input type="checkbox" name="sigmie_filterable_attributes[]" value="' . esc_attr($attribute->attribute_name) . '"' . $selected . ' onchange="updateOrderedAttributes()">' . esc_html($attribute->attribute_label) . '</li>';
		}
		echo '</ul>';

		// Hidden input to store the ordered attributes
		echo '<input type="hidden" id="sigmie_ordered_attributes" name="sigmie_filters_order" value="' . esc_attr($attributesJson) . '">';

		wp_enqueue_script('jquery-ui-sortable');
?>
		<script>
			function updateOrderedAttributes() {
				var checkedAttributes = jQuery("#sigmie_attributes_sortable input:checked").map(function() {
					return this.value;
				}).get();

				jQuery("#sigmie_ordered_attributes").val(JSON.stringify(checkedAttributes));
			}

			jQuery(document).ready(function($) {

				$("#sigmie_attributes_sortable").sortable({
					update: function(event, ui) {
						updateOrderedAttributes();
					}
				});
				$("#sigmie_attributes_sortable").disableSelection();
			});
		</script>
		<p class="description">
			<?php esc_html_e('Check the attributes you want to include and drag to reorder.', 'sigmie'); ?>
		</p>
<?php
	}

	/**
	 * Display the page.
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 * @since  1.0.0
	 */
	public function display_page()
	{
		require_once dirname(__FILE__) . '/partials/listing-settings.php';
	}

	/**
	 * Display the errors.
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function display_errors()
	{
		settings_errors($this->option_group);
	}

	/**
	 * Prints the section text.
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 * @since  1.0.0
	 */
	public function print_section_settings()
	{
		echo '';
	}
}
