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
class Sigmie_Admin_Page_Results
{
	/**
	 * Admin page slug.
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 * @since  1.0.0
	 *
	 * @var string
	 */
	private $slug = 'sigmie-results-page';

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
	private $section = 'sigmie_section_results';

	/**
	 * Admin page option group.
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 * @since  1.0.0
	 *
	 * @var string
	 */
	private $option_group = 'sigmie_results';

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
			esc_html__('Results', 'sigmie'),
			esc_html__('Results', 'sigmie'),
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

		// Add the settings fields
		add_settings_field(
			'nothing_found_text',
			esc_html__('Nothing found text', 'sigmie'),
			array($this, 'nothing_found_text_callback'),
			$this->slug,
			$this->section
		);

		register_setting(
			$this->option_group,
			'sigmie_nothing_found_text',
			array($this, 'sanitize_nothing_found_text')
		);

		add_settings_field(
			'short_by',
			esc_html__('Short by', 'sigmie'),
			array($this, 'sort_by_callback'),
			$this->slug,
			$this->section
		);

		register_setting(
			$this->option_group,
			'sigmie_sort_by',
			array($this, 'sanitize_sort_by')
		);

		add_settings_field(
			'number_of_results',
			esc_html__('Number of results', 'sigmie'),
			array($this, 'number_of_results_callback'),
			$this->slug,
			$this->section
		);

		register_setting(
			$this->option_group,
			'sigmie_number_of_results',
			array($this, 'sanitize_number_of_results')
		);


		add_settings_field(
			'max_description_length',
			esc_html__('Max description length', 'sigmie'),
			array($this, 'max_description_length_callback'),
			$this->slug,
			$this->section
		);

		register_setting(
			$this->option_group,
			'sigmie_max_description_length',
			array($this, 'sanitize_max_description_length')
		);

		add_settings_field(
			'results_display',
			esc_html__('Results display', 'sigmie'),
			array($this, 'results_display_callback'),
			$this->slug,
			$this->section
		);

		register_setting(
			$this->option_group,
			'sigmie_results_display',
			array($this, 'sanitize_results_display')
		);

		add_settings_field(
			'show_category',
			esc_html__('Show category', 'sigmie'),
			array($this, 'show_category_callback'),
			$this->slug,
			$this->section
		);

		register_setting(
			$this->option_group,
			'sigmie_show_category',
			array($this, 'sanitize_show_category')
		);

		add_settings_field(
			'show_description',
			esc_html__('Show description', 'sigmie'),
			array($this, 'show_description_callback'),
			$this->slug,
			$this->section
		);

		register_setting(
			$this->option_group,
			'sigmie_show_description',
			array($this, 'sanitize_show_description')
		);

		add_settings_field(
			'show_price',
			esc_html__('Show price', 'sigmie'),
			array($this, 'show_price_callback'),
			$this->slug,
			$this->section
		);

		register_setting(
			$this->option_group,
			'sigmie_show_price',
			array($this, 'sanitize_show_price')
		);

		add_settings_field(
			'show_rating',
			esc_html__('Show rating', 'sigmie'),
			array($this, 'show_rating_callback'),
			$this->slug,
			$this->section
		);

		register_setting(
			$this->option_group,
			'sigmie_show_rating',
			array($this, 'sanitize_show_rating')
		);

		add_settings_field(
			'show_sku',
			esc_html__('Show SKU', 'sigmie'),
			array($this, 'show_sku_callback'),
			$this->slug,
			$this->section
		);

		register_setting(
			$this->option_group,
			'sigmie_show_sku',
			array($this, 'sanitize_show_sku')
		);

		add_settings_field(
			'show_stock',
			esc_html__('Show stock', 'sigmie'),
			array($this, 'show_stock_callback'),
			$this->slug,
			$this->section
		);

		register_setting(
			$this->option_group,
			'sigmie_show_stock',
			array($this, 'sanitize_show_stock')
		);

		add_settings_field(
			'show_on_sale',
			esc_html__('Show On Sale', 'sigmie'),
			array($this, 'show_on_sale_callback'),
			$this->slug,
			$this->section
		);

		register_setting(
			$this->option_group,
			'sigmie_show_on_sale',
			array($this, 'sanitize_show_on_sale')
		);
	}

	public function sanitize_sort_by($value)
	{
		$value = sanitize_text_field($value);

		return $value;
	}

	public function sort_by_callback()
	{
		$value = (string) get_option('sigmie_sort_by', 'relevance');
?>
		<fieldset class="">
			<span class="">
				<input type="radio" id="sigmie_sort_by_relevance" name="sigmie_sort_by" value="relevance" <?php checked($value, 'relevance'); ?> />
				<label class="checkbox" for="sigmie_sort_by_relevance"><?php _e('Most relevant on top'); ?></label>
			</span>
			<br>
			<span class="">
				<input type="radio" id="sigmie_sort_by_price_asc" name="sigmie_sort_by" value="price_asc" <?php checked($value, 'price_asc'); ?> />
				<label class="checkbox" for="sigmie_sort_by_price_asc"><?php _e('Price (low to hight)'); ?></label>
			</span>
			<br>
			<span class="">
				<input type="radio" id="sigmie_sort_by_price_desc" name="sigmie_sort_by" value="price_desc" <?php checked($value, 'price_desc'); ?> />
				<label class="checkbox" for="sigmie_sort_by_price_desc"><?php _e('Price (high to low)'); ?></label>
			</span>
			<br>
			<span class="">
				<input type="radio" id="sigmie_sort_by_name_asc" name="sigmie_sort_by" value="name_asc" <?php checked($value, 'name_asc'); ?> />
				<label class="checkbox" for="sigmie_sort_by_name_asc"><?php _e('Name (A - Z)'); ?></label>
			</span>
			<br>
			<span class="">
				<input type="radio" id="sigmie_sort_by_name_desc" name="sigmie_sort_by" value="name_desc" <?php checked($value, 'name_desc'); ?> />
				<label class="checkbox" for="sigmie_sort_by_name_desc"><?php _e('Name (Z - A)'); ?></label>
			</span>
			<br>
		</fieldset>
	<?php
	}

	public function sanitize_max_description_length($value)
	{
		$value = sanitize_text_field($value);

		return $value;
	}

	public function max_description_length_callback()
	{
		$value = (string) get_option('sigmie_max_description_length', '');
	?>
		<input type="number" name="sigmie_max_description_length" class="regular-text" value="<?php echo esc_html($value); ?>"></input>
		<p class="description">
			<?php esc_html_e('Maximal allowed number of chars for product description.', 'sigmie'); ?>
		</p>
	<?php
	}

	public function sanitize_description_length($value)
	{
		$value = sanitize_text_field($value);

		return $value;
	}

	public function show_on_sale_callback()
	{
		$value = (string) get_option('sigmie_show_on_sale', '0');
	?>
		<fieldset class="">
			<span class="">
				<input type="radio" id="sigmie_show_on_sale_on" name="sigmie_show_on_sale" value="1" <?php checked($value, '1'); ?> />
				<label class="checkbox" for="sigmie_show_on_sale_on"><?php _e('Yes'); ?></label>
			</span>
			<br>
			<span class="">
				<input type="radio" id="sigmie_show_on_sale_off" name="sigmie_show_on_sale" value="0" <?php checked($value, '0'); ?> />
				<label class="checkbox" for="sigmie_show_on_sale_off"><?php _e('No'); ?></label>
			</span>
		</fieldset>
		<p class="description">
			<?php esc_html_e('Show product On Sale for each search result.', 'sigmie'); ?>
		</p>
	<?php
	}

	public function sanitize_show_stock($value)
	{
		$value = sanitize_text_field($value);

		return $value;
	}

	public function show_stock_callback()
	{
		$value = (string) get_option('sigmie_show_stock', '0');
	?>
		<fieldset class="">
			<span class="">
				<input type="radio" id="sigmie_show_stock_on" name="sigmie_show_stock" value="1" <?php checked($value, '1'); ?> />
				<label class="checkbox" for="sigmie_show_stock_on"><?php _e('Yes'); ?></label>
			</span>
			<br>
			<span class="">
				<input type="radio" id="sigmie_show_stock_off" name="sigmie_show_stock" value="0" <?php checked($value, '0'); ?> />
				<label class="checkbox" for="sigmie_show_stock_off"><?php _e('No'); ?></label>
			</span>
		</fieldset>
		<p class="description">
			<?php esc_html_e('Show product stock for each search result.', 'sigmie'); ?>
		</p>
	<?php
	}

	public function sanitize_show_sku($value)
	{
		$value = sanitize_text_field($value);

		return $value;
	}

	public function show_sku_callback()
	{
		$value = (string) get_option('sigmie_show_sku', '0');
	?>
		<fieldset class="">
			<span class="">
				<input type="radio" id="sigmie_show_sku_on" name="sigmie_show_sku" value="1" <?php checked($value, '1'); ?> />
				<label class="checkbox" for="sigmie_show_sku_on"><?php _e('Yes'); ?></label>
			</span>
			<br>
			<span class="">
				<input type="radio" id="sigmie_show_sku_off" name="sigmie_show_sku" value="0" <?php checked($value, '0'); ?> />
				<label class="checkbox" for="sigmie_show_sku_off"><?php _e('No'); ?></label>
			</span>
		</fieldset>
		<p class="description">
			<?php esc_html_e('Show product SKU for each search result.', 'sigmie'); ?>
		</p>
	<?php
	}

	public function sanitize_show_rating($value)
	{
		$value = sanitize_text_field($value);

		return $value;
	}

	public function show_rating_callback()
	{
		$value = (string) get_option('sigmie_show_rating', '0');
	?>
		<fieldset class="">
			<span class="">
				<input type="radio" id="sigmie_show_rating_on" name="sigmie_show_rating" value="1" <?php checked($value, '1'); ?> />
				<label class="checkbox" for="sigmie_show_rating_on"><?php _e('Yes'); ?></label>
			</span>
			<br>
			<span class="">
				<input type="radio" id="sigmie_show_rating_off" name="sigmie_show_rating" value="0" <?php checked($value, '0'); ?> />
				<label class="checkbox" for="sigmie_show_rating_off"><?php _e('No'); ?></label>
			</span>
		</fieldset>
		<p class="description">
			<?php esc_html_e('Show product rating for each search result.', 'sigmie'); ?>
		</p>
	<?php
	}

	public function sanitize_show_price($value)
	{
		$value = sanitize_text_field($value);

		return $value;
	}

	public function show_price_callback()
	{
		$value = (string) get_option('sigmie_show_price', '0');
	?>
		<fieldset class="">
			<span class="">
				<input type="radio" id="sigmie_show_price_on" name="sigmie_show_price" value="1" <?php checked($value, '1'); ?> />
				<label class="checkbox" for="sigmie_show_price_on"><?php _e('Yes'); ?></label>
			</span>
			<br>
			<span class="">
				<input type="radio" id="sigmie_show_price_off" name="sigmie_show_price" value="0" <?php checked($value, '0'); ?> />
				<label class="checkbox" for="sigmie_show_price_off"><?php _e('No'); ?></label>
			</span>
		</fieldset>
		<p class="description">
			<?php esc_html_e('Show product price for each search result.', 'sigmie'); ?>
		</p>
	<?php
	}

	public function sanitize_show_description($value)
	{
		$value = sanitize_text_field($value);

		return $value;
	}

	public function show_description_callback()
	{
		$value = (string) get_option('sigmie_show_description', '0');
	?>
		<fieldset class="">
			<span class="">
				<input type="radio" id="sigmie_show_description_on" name="sigmie_show_description" value="1" <?php checked($value, '1'); ?> />
				<label class="checkbox" for="sigmie_show_description_on"><?php _e('Yes'); ?></label>
			</span>
			<br>
			<span class="">
				<input type="radio" id="sigmie_show_description_off" name="sigmie_show_description" value="0" <?php checked($value, '0'); ?> />
				<label class="checkbox" for="sigmie_show_description_off"><?php _e('No'); ?></label>
			</span>
		</fieldset>
		<p class="description">
			<?php esc_html_e('Show product short description for each search result.', 'sigmie'); ?>
		</p>
	<?php
	}

	public function sanitize_show_category($value)
	{
		$value = sanitize_text_field($value);

		return $value;
	}

	public function show_category_callback()
	{
		$value = (string) get_option('sigmie_show_category', '0');
	?>
		<fieldset class="">
			<span class="">
				<input type="radio" id="sigmie_show_category_on" name="sigmie_show_category" value="1" <?php checked($value, '1'); ?> />
				<label class="checkbox" for="sigmie_show_category_on"><?php _e('Yes'); ?></label>
			</span>
			<br>
			<span class="">
				<input type="radio" id="sigmie_show_category_off" name="sigmie_show_category" value="0" <?php checked($value, '0'); ?> />
				<label class="checkbox" for="sigmie_show_category_off"><?php _e('No'); ?></label>
			</span>
		</fieldset>
		<p class="description">
			<?php esc_html_e('Show product category for each search result.', 'sigmie'); ?>
		</p>
	<?php
	}

	public function sanitize_results_display($value)
	{
		$value = sanitize_text_field($value);

		return $value;
	}

	public function results_display_callback()
	{
		$value = (string) get_option('sigmie_results_display', 'list');
	?>
		<fieldset class="">
			<span class="">
				<input type="radio" id="sigmie_results_display_list" name="sigmie_results_display" value="list" <?php checked($value, 'list'); ?> />
				<label class="checkbox" for="sigmie_results_display_list"><?php _e('List'); ?></label>
			</span>
			<br>
			<span class="">
				<input type="radio" id="sigmie_results_display_grid" name="sigmie_results_display" value="grid" <?php checked($value, 'grid'); ?> />
				<label class="checkbox" for="sigmie_results_display_grid"><?php _e('Grid'); ?></label>
			</span>
		</fieldset>
		<p class="description">
			<?php esc_html_e('Choose how the search results will be displayed: as a list or as a grid.', 'sigmie'); ?>
		</p>
	<?php
	}

	public function sanitize_nothing_found_text($value)
	{
		$value = sanitize_text_field($value);

		return $value;
	}

	public function nothing_found_text_callback()
	{
		$value = (string) get_option('sigmie_nothing_found_text', '');
	?>
		<input type="text" name="sigmie_nothing_found_text" class="regular-text" value="<?php echo esc_html($value); ?>"></input>
		<p class="description">
			<?php esc_html_e('Text when there is no product found search results.', 'sigmie'); ?>
		</p>
	<?php
	}

	public function sanitize_number_of_results($value)
	{
		$value = sanitize_text_field($value);

		return $value;
	}

	public function number_of_results_callback()
	{
		$value = (string) get_option('sigmie_number_of_results', '');
	?>
		<input type="number" name="sigmie_number_of_results" class="regular-text" value="<?php echo esc_html($value); ?>"></input>
		<p class="description">
			<?php esc_html_e('Maximum number of displayed search results. ', 'sigmie'); ?>
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
		require_once dirname(__FILE__) . '/partials/results-settings.php';
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
