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
class Sigmie_Admin_Page_Filters
{
	/**
	 * Admin page slug.
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 * @since  1.0.0
	 *
	 * @var string
	 */
	private $slug = 'sigmie-filters-page';

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
	private $section = 'sigmie_section_filters';

	/**
	 * Admin page option group.
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 * @since  1.0.0
	 *
	 * @var string
	 */
	private $option_group = 'sigmie_filters';

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
			esc_html__('Filters', 'sigmie'),
			esc_html__('Filters', 'sigmie'),
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
			//sigmie_offers_filter_text
			//sigmie_products_count_template
			//sigmie_currency_position
			//sigmie_show_price_currency
			//sigmie_sort_relevance_label
			//sigmie_sort_price_desc_label
			//sigmie_sort_price_asc_label
			//sigmie_sort_most_recent_label
			//sigmie_sort_rating_label
			'theme' => esc_html__('Theme', 'sigmie'),
			'filterable_attributes' => esc_html__('Filterable attributes', 'sigmie'),
			'show_price_range_chart' => esc_html__('Show price chart', 'sigmie'),
			'show_categories_filter' => esc_html__('Show categories', 'sigmie'),
			'products_per_page' => esc_html__('Products per page', 'sigmie'),
			'currency_symbol' => esc_html__('Currency symbol', 'sigmie'),
			'show_offers_filter' => esc_html__('Show offers filter', 'sigmie'),
			'products_title_text' => esc_html__('Products title text', 'sigmie'),
			'filters_title_text' => esc_html__('Filters title text', 'sigmie'),
			'reset_filters_text' => esc_html__('Reset filters text', 'sigmie'),
			'price_range_label' => esc_html__('Price range label', 'sigmie'),
			'show_products_count' => esc_html__('Show products count', 'sigmie'),
			'price_range_filter_label' => esc_html__('Price range filter label template', 'sigmie'),
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

	public function sanitize_show_price_range_chart($value)
	{
		$value = sanitize_text_field($value);

		return $value;
	}

	public function show_price_range_chart_callback()
	{
		$value = (string) get_option('sigmie_show_price_range_chart', '0');
?>
		<fieldset class="">
			<span class="">
				<input type="radio" id="sigmie_show_price_range_chart_on" name="sigmie_show_price_range_chart" value="1" <?php checked($value, '1'); ?> />
				<label class="checkbox" for="sigmie_show_price_range_chart_on"><?php _e('Yes'); ?></label>
			</span>
			<br>
			<span class="">
				<input type="radio" id="sigmie_show_price_range_chart_off" name="sigmie_show_price_range_chart" value="0" <?php checked($value, '0'); ?> />
				<label class="checkbox" for="sigmie_show_price_range_chart_off"><?php _e('No'); ?></label>
			</span>
		</fieldset>
		<p class="description">
			<?php esc_html_e('Show Chart above the range bar.', 'sigmie'); ?>
		</p>
	<?php
	}

	public function sanitize_show_categories_filter($value)
	{
		$value = sanitize_text_field($value);

		return $value;
	}

	public function show_categories_filter_callback()
	{
		$value = (string) get_option('sigmie_show_categories_filter', '0');
	?>
		<fieldset class="">
			<span class="">
				<input type="radio" id="sigmie_show_categories_filter_on" name="sigmie_show_categories_filter" value="1" <?php checked($value, '1'); ?> />
				<label class="checkbox" for="sigmie_show_categories_filter_on"><?php _e('Yes'); ?></label>
			</span>
			<br>
			<span class="">
				<input type="radio" id="sigmie_show_categories_filter_off" name="sigmie_show_categories_filter" value="0" <?php checked($value, '0'); ?> />
				<label class="checkbox" for="sigmie_show_categories_filter_off"><?php _e('No'); ?></label>
			</span>
		</fieldset>
		<p class="description">
			<?php esc_html_e('Show categories filter option.', 'sigmie'); ?>
		</p>
	<?php
	}

	public function sanitize_products_per_page($value)
	{
		return intval($value);
	}

	public function products_per_page_callback()
	{
		$value = get_option('sigmie_products_per_page', 10);
		echo '<input type="number" name="sigmie_products_per_page" value="' . esc_attr($value) . '" class="regular-text"/>';
	}

	public function sanitize_currency_symbol($value)
	{
		return sanitize_text_field($value);
	}

	public function currency_symbol_callback()
	{
		$value = get_option('sigmie_currency_symbol', '$');
		echo '<input type="text" name="sigmie_currency_symbol" value="' . esc_attr($value) . '" class="regular-text"/>';
	}

	public function sanitize_show_offers_filter($value)
	{
		return sanitize_text_field($value);
	}

	public function show_offers_filter_callback()
	{
		$value = (string) get_option('sigmie_show_offers_filter', '0');
	?>
		<fieldset class="">
			<span class="">
				<input type="radio" id="sigmie_show_offers_filter_on" name="sigmie_show_offers_filter" value="1" <?php checked($value, '1'); ?> />
				<label class="checkbox" for="sigmie_show_offers_filter_on"><?php _e('Yes'); ?></label>
			</span>
			<br>
			<span class="">
				<input type="radio" id="sigmie_show_offers_filter_off" name="sigmie_show_offers_filter" value="0" <?php checked($value, '0'); ?> />
				<label class="checkbox" for="sigmie_show_offers_filter_off"><?php _e('No'); ?></label>
			</span>
		</fieldset>
		<p class="description">
			<?php esc_html_e('Show offers filter option next to sorting.', 'sigmie'); ?>
		</p>
	<?php
	}

	public function sanitize_products_title_text($value)
	{
		return sanitize_text_field($value);
	}

	public function products_title_text_callback()
	{
		$value = get_option('sigmie_products_title_text', '');
		echo '<input type="text" name="sigmie_products_title_text" value="' . esc_attr($value) . '" class="regular-text"/>';
	}

	public function sanitize_filters_title_text($value)
	{
		return sanitize_text_field($value);
	}

	public function filters_title_text_callback()
	{
		$value = get_option('sigmie_filters_title_text', '');
		echo '<input type="text" name="sigmie_filters_title_text" value="' . esc_attr($value) . '" class="regular-text"/>';
	}

	public function sanitize_reset_filters_text($value)
	{
		return sanitize_text_field($value);
	}

	public function reset_filters_text_callback()
	{
		$value = get_option('sigmie_reset_filters_text', '');
		echo '<input type="text" name="sigmie_reset_filters_text" value="' . esc_attr($value) . '" class="regular-text"/>';
	}

	public function sanitize_price_range_label($value)
	{
		return sanitize_text_field($value);
	}

	public function price_range_label_callback()
	{
		$value = get_option('sigmie_price_range_label', '');
		echo '<input type="text" name="sigmie_price_range_label" value="' . esc_attr($value) . '" class="regular-text"/>';
	}

	public function sanitize_show_products_count($value)
	{
		return sanitize_text_field($value);
	}

	public function show_products_count_callback()
	{
		$value = get_option('sigmie_show_products_count', false);
		$value = (string) get_option('sigmie_show_products_count', '0');
	?>
		<fieldset class="">
			<span class="">
				<input type="radio" id="sigmie_show_products_count_on" name="sigmie_show_products_count" value="1" <?php checked($value, '1'); ?> />
				<label class="checkbox" for="sigmie_show_products_count_on"><?php _e('Yes'); ?></label>
			</span>
			<br>
			<span class="">
				<input type="radio" id="sigmie_show_products_count_off" name="sigmie_show_products_count" value="0" <?php checked($value, '0'); ?> />
				<label class="checkbox" for="sigmie_show_products_count_off"><?php _e('No'); ?></label>
			</span>
		</fieldset>
		<p class="description">
			<?php esc_html_e('Show the total products count.', 'sigmie'); ?>
		</p>
	<?php
	}

	public function sanitize_price_range_filter_label($value)
	{
		return sanitize_text_field($value);
	}

	public function price_range_filter_label_callback()
	{
		$value = get_option('sigmie_price_range_filter_label', '');
		echo '<input type="text" name="sigmie_price_range_filter_label" value="' . esc_attr($value) . '" class="regular-text"/>';
	}

	public function sanitize_theme($values)
	{
		return $values;
	}

	public function theme_callback()
	{
		$selectedTheme = (string) get_option('sigmie_theme', 'aura-light-lime');

		echo '<select name="sigmie_theme" class="regular-text">';
		$themes = [
			"aura-light-amber",
			"aura-light-green",
			"aura-light-noir",
			"aura-light-teal",
			"aura-light-blue",
			"aura-light-indigo",
			"aura-light-pink",
			"aura-light-cyan",
			"aura-light-lime",
			"aura-light-purple"
		];
		foreach ($themes as $theme) {
			$selected = $selectedTheme === $theme ? ' selected' : '';
			$label = ucwords(end(explode('-', $theme)));
			echo '<option value="' . esc_attr($theme) . '"' . $selected . '>' . esc_html($label) . '</option>';
		}
		echo '</select>';
	}

	public function sanitize_filterable_attributes($values)
	{

		return json_encode($values);
	}

	public function filterable_attributes_callback()
	{
		$attributesJson = (string) get_option('sigmie_filterable_attributes', '[]');

		$existingAttributes = json_decode($attributesJson, true);

		$attributes = wc_get_attribute_taxonomies();

		echo '<select multiple name="sigmie_filterable_attributes[]" class="regular-text">';

		foreach ($attributes as $attribute) {

			$selected = in_array($attribute->attribute_name, $existingAttributes) ? ' selected' : '';

			echo '<option value="' . esc_attr($attribute->attribute_name) . '"' . $selected . '>' . esc_html($attribute->attribute_label) . '</option>';
		}

		echo '</select>';

	?>
		<p class="description">
			<?php esc_html_e('Hold down the control CTRL / ⌘ command button to select multiple options.', 'sigmie'); ?>
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
		require_once dirname(__FILE__) . '/partials/filters-settings.php';
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
