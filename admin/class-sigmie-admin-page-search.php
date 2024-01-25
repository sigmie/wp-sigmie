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
class Sigmie_Admin_Page_Search
{
	/**
	 * Admin page slug.
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 * @since  1.0.0
	 *
	 * @var string
	 */
	private $slug = 'sigmie-search-page';

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
	private $section = 'sigmie_section_native_search';

	/**
	 * Admin page option group.
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 * @since  1.0.0
	 *
	 * @var string
	 */
	private $option_group = 'sigmie_native_search';

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
			esc_html__('Search', 'sigmie'),
			esc_html__('Search', 'sigmie'),
			$this->capability,
			$this->slug,
			array($this, 'display_page'),
		);
	}

	public function search_show_loader_callback()
	{
		$value = (string) get_option('sigmie_show_loader', '1');
?>
		<fieldset class="">
			<span class="">
				<input type="radio" id="sigmie_show_loader_on" name="sigmie_show_loader" value="1" <?php checked($value, '1'); ?> />
				<label class="checkbox" for="sigmie_show_loader_on"><?php _e('Yes'); ?></label>
			</span>
			<br>
			<span class="">
				<input type="radio" id="sigmie_show_loader_off" name="sigmie_show_loader" value="0" <?php checked($value, '0'); ?> />
				<label class="checkbox" for="sigmie_show_loader_off"><?php _e('No'); ?></label>
			</span>
		</fieldset>
	<?php
	}

	public function search_field_height_callback()
	{
		$value = (string) get_option('sigmie_search_field_height', 50);
	?>
		<input type="number" name="sigmie_search_field_height" class="regular-text" value="<?php echo esc_html($value); ?>"></input>
		<p class="description" id="home-description">
			<?php esc_html_e('Search field maximum height in pixels.', 'sigmie'); ?>
		</p>
	<?php
	}

	public function search_field_width_callback()
	{
		$value = (string) get_option('sigmie_search_field_width', 999);
	?>
		<input type="number" name="sigmie_search_field_width" class="regular-text" value="<?php echo esc_html($value); ?>"></input>
		<p class="description" id="home-description">
			<?php esc_html_e('Search field maximum width in pixels.', 'sigmie'); ?>
		</p>
	<?php
	}

	public function corner_radius_callback()
	{
		$value = (string) get_option('sigmie_corner_radius', '');
	?>
		<input type="number" name="sigmie_corner_radius" class="regular-text" value="<?php echo esc_html($value); ?>"></input>
		<p class="description" id="home-description">
			<?php esc_html_e('Corner radius in pixels.', 'sigmie'); ?>
		</p>
	<?php
	}

	public function sanitize_language($value)
	{
		$value = sanitize_text_field($value);

		return $value;
	}

	public function language_callback()
	{
		$value = (string) get_option('sigmie_language', '');
	?>
		<select name="sigmie_language" class="regular-text">
			<option value="None" <?php selected($value, 'None'); ?>>None</option>
			<option value="English" <?php selected($value, 'English'); ?>>English</option>
			<option value="Greek" <?php selected($value, 'Greek'); ?>>Greek</option>
			<option value="German" <?php selected($value, 'German'); ?>>German</option>
		</select>
		<p class="description" id="home-description">
			<?php esc_html_e('You need to re-index all products after changing this setting.', 'sigmie'); ?>
		</p>
	<?php
	}

	public function sanitize_corner_radius($value)
	{
		$value = sanitize_text_field($value);

		return $value;
	}

	public function search_field_text_callback()
	{
		$value = (string) get_option('sigmie_search_field_text', '');
	?>
		<input type="text" name="sigmie_search_field_text" class="regular-text" value="<?php echo esc_html($value); ?>"></input>
		<p class="description" id="home-description">
			<?php esc_html_e('Text for search field placeholder.', 'sigmie'); ?>
		</p>
<?php
	}

	public function sanitize_search_field_width($value)
	{
		$value = sanitize_text_field($value);

		if (empty($value)) {
			add_settings_error(
				$this->option_group,
				'empty',
				esc_html__('Search field width value shoud no be empty', 'sigmie')
			);
		}

		return $value;
	}

	public function sanitize_search_field_height($value)
	{
		$value = sanitize_text_field($value);

		if (empty($value)) {
			add_settings_error(
				$this->option_group,
				'empty',
				esc_html__('Search field height value shoud no be empty', 'sigmie')
			);
		}

		return $value;
	}

	public function sanitize_show_loader($value)
	{
		$value = sanitize_text_field($value);

		if (!in_array($value, ['0', '1'])) {
			add_settings_error(
				$this->option_group,
				'empty',
				esc_html__('Show loader value is invalid', 'sigmie')
			);
		}

		return $value;
	}

	public function sanitize_search_field_text($value)
	{
		$value = sanitize_text_field($value);

		if (empty($value)) {
			add_settings_error(
				$this->option_group,
				'empty',
				esc_html__('Search field text should not be empty', 'sigmie')
			);
		}

		return $value;
	}

	/**
	 * Add settings.
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 * @since  1.0.0
	 */
	public function add_settings()
	{
		add_settings_section(
			$this->section,
			null,
			array($this, 'print_section_settings'),
			$this->slug
		);

		add_settings_field(
			'language',
			esc_html__('Language', 'sigmie'),
			array($this, 'language_callback'),
			$this->slug,
			$this->section
		);

		register_setting(
			$this->option_group,
			'sigmie_language',
			array($this, 'sanitize_language')
		);

		add_settings_field(
			'search_field_text',
			esc_html__('Search field text', 'sigmie'),
			array($this, 'search_field_text_callback'),
			$this->slug,
			$this->section
		);

		register_setting(
			$this->option_group,
			'sigmie_search_field_text',
			array($this, 'sanitize_search_field_text')
		);


		add_settings_field(
			'show_loader',
			esc_html__('Show loader', 'sigmie'),
			array($this, 'search_show_loader_callback'),
			$this->slug,
			$this->section
		);

		register_setting(
			$this->option_group,
			'sigmie_show_loader',
			array($this, 'sanitize_show_loader')
		);

		add_settings_field(
			'search_field_height',
			esc_html__('Search field height', 'sigmie'),
			array($this, 'search_field_height_callback'),
			$this->slug,
			$this->section
		);

		register_setting(
			$this->option_group,
			'sigmie_search_field_height',
			array($this, 'sanitize_search_field_height')
		);

		add_settings_field(
			'corner_radius',
			esc_html__('Corner radius', 'sigmie'),
			array($this, 'corner_radius_callback'),
			$this->slug,
			$this->section
		);

		register_setting(
			$this->option_group,
			'sigmie_corner_radius',
			array($this, 'sanitize_corner_radius')
		);

		add_settings_field(
			'search_field_width',
			esc_html__('Search field width', 'sigmie'),
			array($this, 'search_field_width_callback'),
			$this->slug,
			$this->section
		);

		register_setting(
			$this->option_group,
			'sigmie_search_field_width',
			array($this, 'sanitize_search_field_width')
		);
	}

	/**
	 * Display the page.
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 * @since  1.0.0
	 */
	public function display_page()
	{
		require_once dirname(__FILE__) . '/partials/search-settings.php';
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
		echo '<div class="notice"><p>You can use it as widgets, you will find inside the widgets areas or you can use the shortcode [sigmie_search_bar].</p> </div>';
	}
}
