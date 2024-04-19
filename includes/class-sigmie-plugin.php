<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/nicoorfi
 * @since      1.0.0
 *
 * @package    Sigmie
 * @subpackage Sigmie/includes
 */

use Sigmie\Application\Client;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Sigmie
 * @subpackage Sigmie/includes
 * @author     Nico Orfanos <nico@sigmie.com>
 */
class Sigmie_Plugin
{

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Sigmie_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct()
	{
		if (defined('SIGMIE_VERSION')) {
			$this->version = SIGMIE_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'sigmie';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Sigmie_Loader. Orchestrates the hooks of the plugin.
	 * - Sigmie_i18n. Defines internationalization functionality.
	 * - Sigmie_Admin. Defines all hooks for the admin area.
	 * - Sigmie_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies()
	{

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-sigmie-loader.php';

		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-sigmie-install.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-sigmie-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-sigmie-admin.php';

		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-sigmie-search-widget.php';


		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-sigmie-admin-page.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-sigmie-admin-search-page.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-sigmie-admin-credentials-page.php';

		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-sigmie-admin-results-page.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-sigmie-admin-listing-page.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-sigmie-admin-filters-page.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-sigmie-admin-filterable-page.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-sigmie-public.php';

		$this->loader = new Sigmie_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Sigmie_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale()
	{

		$plugin_i18n = new Sigmie_i18n();

		$this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks()
	{

		register_activation_hook(SIGMIE_PLUGIN_FILE, array(new Sigmie_Install, 'install'));

		$plugin_admin = new Sigmie_Admin(
			$this->get_plugin_name(),
			$this->get_version(),
			$this->sigmie_admin(),
			$this->sigmie_index()
		);

		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts',);
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');

		$this->loader->add_action('admin_menu', $plugin_admin, 'add_pages', 10);
		// $this->loader->add_action('admin_init', $plugin_admin, 'add_settings', 15);
		// $this->loader->add_action('admin_notices', $plugin_admin, 'display_settings_errors', 15);

		$this->loader->add_filter('woocommerce_product_data_tabs', $plugin_admin, 'product_tab', 10, 3);
		$this->loader->add_action('woocommerce_product_data_panels', $plugin_admin, 'product_tab_content', 10, 3);
		$this->loader->add_action('woocommerce_process_product_meta', $plugin_admin, 'product_tab_fields', 10, 2);

		$this->loader->add_action('woocommerce_order_status_completed', $plugin_admin, 'order_completed', 10, 1);

		$this->loader->add_action('woocommerce_new_product', $plugin_admin, 'product_created', 10, 2);
		$this->loader->add_action('woocommerce_update_product', $plugin_admin, 'product_updated', 10, 2);
		$this->loader->add_action('wp_trash_post', $plugin_admin, 'post_trashed', 10, 2);
		$this->loader->add_action('untrashed_post', $plugin_admin, 'post_untrashed', 10, 2);

		$this->loader->add_filter('product_attributes_type_selector', $plugin_admin, 'register_attribute_types');
		$this->loader->add_action('woocommerce_after_add_attribute_fields', $plugin_admin, 'attribute_orderby_field');
		$this->loader->add_action('woocommerce_after_edit_attribute_fields', $plugin_admin, 'attribute_orderby_field');

		$this->loader->add_action('rest_api_init', $plugin_admin, 'register_rest_route');


		add_shortcode('sigmie_search_bar', [$plugin_admin, 'render_sigmie_search_bar']);

		add_shortcode('sigmie_product_listing', [$plugin_admin, 'render_sigmie_product_listing']);

		$this->loader->add_filter('display_post_states', $plugin_admin, 'add_display_post_states', 10, 2);
		$this->loader->add_filter('template_include', $plugin_admin, 'sigmie_template_include');

		$this->loader->add_action('widgets_init', $plugin_admin, 'register_sigmie_widget');
	}


	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks()
	{

		$plugin_public = new Sigmie_Public($this->get_plugin_name(), $this->get_version());

		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');

		if (defined('ELEMENTOR_VERSION')) {
			$this->loader->add_action('elementor/frontend/after_enqueue_scripts', $plugin_public, 'enqueue_scripts');
		} else {
			$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
		}
	}

	/**
	 * @return Client 
	 */
	public function sigmie_admin()
	{
		$applicationId = (string) get_option('sigmie_application_id', '');

		$adminKey = (string) get_option('sigmie_admin_api_key', '');

		return new Sigmie\Application\Client($applicationId, $adminKey);
	}

	public function sigmie_index()
	{
		$prefix = (string) get_option('sigmie_index_prefix', '');

		return $prefix . 'products';
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run()
	{
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name()
	{
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Sigmie_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader()
	{
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version()
	{
		return $this->version;
	}
}
