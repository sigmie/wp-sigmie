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

	public function search_field_text_callback()
	{
		$value = (string) get_option('search_field_text', '');
?>
		<input type="text" name="search_field_text" class="regular-text" value="<?php echo esc_html($value); ?>"></input>
		<p class="description" id="home-description">
			<?php esc_html_e('Text for search field placeholder.', 'sigmie'); ?>
		</p>
<?php
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
		// Create the settings section
		add_settings_section(
			$this->section,
			null,
			array($this, 'print_section_settings'),
			$this->slug
		);

		// Add the settings fields
		add_settings_field(
			'search_field_text',
			esc_html__('Search field text', 'sigmie'),
			array($this, 'search_field_text_callback'),
			$this->slug,
			$this->section
		);

		register_setting(
			$this->option_group,
			'search_field_text',
			array($this, 'sanitize_search_field_text')
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
	}
}
