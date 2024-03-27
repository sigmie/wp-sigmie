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
class Sigmie_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Admin page slug.
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 * @since  1.0.0
	 *
	 * @var string
	 */
	private $slug = 'sigmie';

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
	private $section = 'sigmie_section_settings';

	/**
	 * Admin page option group.
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 * @since  1.0.0
	 *
	 * @var string
	 */
	private $option_group = 'sigmie_settings';

	private $sigmie;

	private $index;



	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version, $sigmie, $index)
	{
		$this->index = $index;
		$this->sigmie = $sigmie;
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Sigmie_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sigmie_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/sigmie-admin.css', array(), $this->version, 'all');
		wp_enqueue_style('wp-color-picker');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Sigmie_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sigmie_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script(
			$this->plugin_name,
			plugin_dir_url(__FILE__) . 'js/sigmie-admin.js',
			array('jquery'),
			$this->version,
			false
		);

		wp_enqueue_script(
			'sigmie-admin-reindex-button',
			plugin_dir_url(__FILE__) . 'js/reindex-button.js',
			array('jquery'),
			$this->version,
			false
		);

		wp_enqueue_script('wp-color-picker');
	}

	/**
	 * Dispaly settings page errors
	 */
	public function display_settings_errors()
	{
		settings_errors($this->option_group);
	}

	function add_settings()
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
			'application_id',
			esc_html__('Application ID', 'sigmie'),
			array($this, 'application_id_callback'),
			$this->slug,
			$this->section
		);

		add_settings_field(
			'search_api_key',
			esc_html__('Search-only API key', 'sigmie'),
			array($this, 'search_api_key_callback'),
			$this->slug,
			$this->section
		);

		add_settings_field(
			'admin_api_key',
			esc_html__('Admin API key', 'sigmie'),
			array($this, 'admin_api_key_callback'),
			$this->slug,
			$this->section
		);


		add_settings_field(
			'index_prefix',
			esc_html__('Index name prefix', 'sigmie'),
			array($this, 'index_prefix_callback'),
			$this->slug,
			$this->section
		);

		register_setting(
			$this->option_group,
			'sigmie_application_id',
			array($this, 'sanitize_application_id')
		);
		register_setting(
			$this->option_group,
			'sigmie_search_api_key',
			array($this, 'sanitize_search_api_key')
		);
		register_setting(
			$this->option_group,
			'sigmie_admin_api_key',
			array($this, 'sanitize_admin_api_key')
		);
		register_setting(
			$this->option_group,
			'sigmie_index_prefix',
			array($this, 'sanitize_index_prefix')
		);
	}

	function application_id_callback()
	{
		$value = (string) get_option('sigmie_application_id', '');
?>
		<input type="text" name="sigmie_application_id" class="regular-text" value="<?php echo esc_html($value); ?>"></input>
		<p class="description" id="home-description">
			<?php esc_html_e('Your Sigmie Application ID.', 'sigmie'); ?>
			<a href="https://app.sigmie.com/api-keys" target="_blank"><?php esc_html_e('Manage your Sigmie API Keys', 'sigmie'); ?></a>
		</p>
	<?php

	}

	function search_api_key_callback()
	{
		$value = (string) get_option('sigmie_search_api_key', '');
	?>
		<input type="text" name="sigmie_search_api_key" class="regular-text" value="<?php echo esc_html($value); ?>"></input>
		<p class="description" id="home-description">
			<?php esc_html_e('Your Sigmie Search-only API key (public).', 'sigmie'); ?>
			<a href="https://app.sigmie.com/api-keys" target="_blank"><?php esc_html_e('Manage your Sigmie API Keys', 'sigmie'); ?></a>
		</p>
	<?php

	}

	function admin_api_key_callback()
	{
		$value = (string) get_option('sigmie_admin_api_key', '');
	?>
		<input type="password" name="sigmie_admin_api_key" class="regular-text" value="<?php echo esc_html($value); ?>"></input>
		<p class="description" id="home-description">
			<?php esc_html_e('Your Sigmie Admin API key (kept private).', 'sigmie'); ?>
			<a href="https://app.sigmie.com/api-keys" target="_blank"><?php esc_html_e('Manage your Sigmie API Keys', 'sigmie'); ?></a>
		</p>
	<?php

	}

	function index_prefix_callback()
	{
		$value = (string) get_option('sigmie_index_prefix', '');
	?>
		<input type="text" name="sigmie_index_prefix" class="regular-text" value="<?php echo esc_html($value); ?>"></input>
		<p class="description" id="home-description">
			<?php esc_html_e('This prefix will be prepended to your index names.', 'sigmie'); ?>
		</p>
	<?php

	}

	function sanitize_application_id($value)
	{
		$value = sanitize_text_field($value);

		if (empty($value)) {
			add_settings_error(
				$this->option_group,
				'empty',
				esc_html__('Application ID should not be empty.', 'sigmie')
			);
		}

		return $value;
	}

	function sanitize_search_api_key($value)
	{
		$value = sanitize_text_field($value);

		if (empty($value)) {
			add_settings_error(
				$this->option_group,
				'empty',
				esc_html__('Search-only API key should not be empty.', 'sigmie')
			);
		}

		return $value;
	}

	function sanitize_admin_api_key($value)
	{
		$value = sanitize_text_field($value);

		if (empty($value)) {
			add_settings_error(
				$this->option_group,
				'empty',
				esc_html__('API key should not be empty', 'sigmie')
			);
		}

		$errors = get_settings_errors($this->option_group);

		if (!empty($errors)) {
			return $value;
		}

		$res = $this->sigmie->deleteIndex($this->index);

		$res = $this->sigmie->createIndex($this->index, [
			'mappings' => [
				[
					'name' => 'price_as_number',
					'type' => 'price',
				],
			]
		]);

		update_option('sigmie_api_is_reachable', $res->failed() ? 'no' : 'yes');

		return $value;
	}

	function sanitize_index_prefix($value)
	{
		$value = sanitize_text_field($value);

		return $value;
	}

	public function add_settings_menu_page()
	{
		add_menu_page(
			esc_html__('Sigmie Search'),
			'Sigmie Search', //here
			$this->capability,
			$this->slug,
			array($this, 'display_settings_page'),
			'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4KPHN2ZyB3aWR0aD0iODBweCIgaGVpZ2h0PSI4MHB4IiB2aWV3Qm94PSIwIDAgODAgODAiIHZlcnNpb249IjEuMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayI+CiAgICA8dGl0bGU+aWNvbi1kYXJrPC90aXRsZT4KICAgIDxnIGlkPSJMb2dvIiBzdHJva2U9Im5vbmUiIHN0cm9rZS13aWR0aD0iMSIgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIj4KICAgICAgICA8ZyBpZD0iaWNvbi1kYXJrIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgwLjAwMDAwMCwgMC4wMDAwMDApIiBmaWxsPSIjRkZGRkZGIiBmaWxsLXJ1bGU9Im5vbnplcm8iPgogICAgICAgICAgICA8ZyBpZD0iaWNvbi13aGl0ZSI+CiAgICAgICAgICAgICAgICA8ZyBpZD0ib3V0ZXIiPgogICAgICAgICAgICAgICAgICAgIDxwYXRoIGQ9Ik0xNC4zNTA2NDk0LDIyLjcwMTI5ODcgQzkuMTk0ODg2NzksMjIuNzAxMjk4NyA1LDE4LjUwNjQxMTkgNSwxMy4zNTE5MjcxIEM1LDguMTk0ODg2ODQgOS4xOTQ4ODY3OSw0IDE0LjM1MDY0OTQsNCBDMTkuNTA2NDExOSw0IDIzLjcwMTI5ODcsOC4xOTQ4ODY4NCAyMy43MDEyOTg3LDEzLjM1MTkyNzEgQzIzLjcwMTI5ODcsMTguNTA2NDExOSAxOS41MDY0MTE5LDIyLjcwMTI5ODcgMTQuMzUwNjQ5NCwyMi43MDEyOTg3IEwxNC4zNTA2NDk0LDIyLjcwMTI5ODcgWiBNMTQuMzUwNjQ5NCw4LjY0NDY1ODQ2IEMxMS43NTY3OTYxLDguNjQ0NjU4NDYgOS42NDQ2NTg0NiwxMC43NTY3OTYxIDkuNjQ0NjU4NDYsMTMuMzUxOTI3MSBDOS42NDQ2NTg0NiwxNS45NDU3ODA0IDExLjc1Njc5NjEsMTguMDU2NjQwMiAxNC4zNTA2NDk0LDE4LjA1NjY0MDIgQzE2Ljk0NTc4MDQsMTguMDU2NjQwMiAxOS4wNTY2NDAyLDE1Ljk0NTc4MDQgMTkuMDU2NjQwMiwxMy4zNTE5MjcxIEMxOS4wNTY2NDAyLDEwLjc1Njc5NjEgMTYuOTQ1NzgwNCw4LjY0NDY1ODQ2IDE0LjM1MDY0OTQsOC42NDQ2NTg0NiBMMTQuMzUwNjQ5NCw4LjY0NDY1ODQ2IFoiIGlkPSJGaWxsLTEiPjwvcGF0aD4KICAgICAgICAgICAgICAgICAgICA8cGF0aCBkPSJNMCwzOS45OTkzNTc5IEMwLDMxLjA2OTk0MzYgMi44NzkyOTYyMywyMi42MjIxMjQ1IDguMzI3MDk5MzYsMTUuNTY5MDA0NiBMMTMuODY4NjUzLDE5Ljg0OTQyMTMgQzkuMzc3NjE4NjgsMjUuNjY0NTIwOSA3LjAwMzAzNDA2LDMyLjYzMjg4MDEgNy4wMDMwMzQwNiwzOS45OTkzNTc5IEM3LjAwMzAzNDA2LDU4LjE5MzM3NjQgMjEuODA1MzM5Myw3Mi45OTY5NjU5IDQwLjAwMDY0MjEsNzIuOTk2OTY1OSBDNTguMTk0NjYwOCw3Mi45OTY5NjU5IDcyLjk5Njk2Niw1OC4xOTMzNzY0IDcyLjk5Njk2NiwzOS45OTkzNTc5IEM3Mi45OTY5NjYsMjEuODA0MDU1IDU4LjE5NDY2MDgsNy4wMDMwMzQwNSA0MC4wMDA2NDIxLDcuMDAzMDM0MDUgQzMzLjk2MDc5ODEsNy4wMDMwMzQwNSAyOC4wNTU4MDA5LDguNjQ2ODc4NDUgMjIuOTIyNjM5OCwxMS43NTg2MjQ2IEwxOS4yOTA3NzExLDUuNzcwMTUwNzQgQzI1LjUxOTQwMDMsMS45OTU3Mjk4NiAzMi42ODAzOTc1LDAgNDAuMDAwNjQyMSwwIEM2Mi4wNTY0MTA5LDAgODAsMTcuOTQzNTg5MiA4MCwzOS45OTkzNTc5IEM4MCw2Mi4wNTUxMjY1IDYyLjA1NjQxMDksODAgNDAuMDAwNjQyMSw4MCBDMTcuOTQzNTg5MSw4MCAwLDYyLjA1NTEyNjUgMCwzOS45OTkzNTc5IFoiIGlkPSJGaWxsLTUiPjwvcGF0aD4KICAgICAgICAgICAgICAgIDwvZz4KICAgICAgICAgICAgICAgIDxnIGlkPSJpbm5lciIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTYuMDAwMDAwLCAxNy4wMDAwMDApIj4KICAgICAgICAgICAgICAgICAgICA8cGF0aCBkPSJNMzgsMjIuMzY4Mjg5NiBDMzgsMTguODU1OTAyNCA0MC44NTUxNjEzLDE2IDQ0LjM2NTA1ODIsMTYgQzQ3Ljg3MzY3MTQsMTYgNTAuNzI4ODMyNiwxOC44NTU5MDI0IDUwLjcyODgzMjYsMjIuMzY4Mjg5NiBDNTAuNzI4ODMyNiwyNS44NzkzOTIzIDQ3Ljg3MzY3MTQsMjguNzM3ODY0IDQ0LjM2NTA1ODIsMjguNzM3ODY0IEM0MC44NTUxNjEzLDI4LjczNzg2NCAzOCwyNS44NzkzOTIzIDM4LDIyLjM2ODI4OTYgWiBNNDIsMjIuNSBDNDIsMjMuODc4NTkzMSA0My4xMjE0MDcsMjUgNDQuNTAxODkxLDI1IEM0NS44ODA0ODQxLDI1IDQ3LDIzLjg3ODU5MzEgNDcsMjIuNSBDNDcsMjEuMTIxNDA2OSA0NS44ODA0ODQxLDIwIDQ0LjUwMTg5MSwyMCBDNDMuMTIxNDA3LDIwIDQyLDIxLjEyMTQwNjkgNDIsMjIuNSBaIiBpZD0iRmlsbC0yIj48L3BhdGg+CiAgICAgICAgICAgICAgICAgICAgPHBhdGggZD0iTTAsMjMuMDg2NzI2IEMwLDEwLjM1NjA2NDMgMTAuNDQ4MDk0MiwwIDIzLjI5MDI2OTEsMCBDMzQuMjQwMDkzMSwwIDQzLjU3OTM3NzgsNy4zODIyNjk0NSA0Ni4wMDExMTI3LDE3Ljk1MzczMTUgTDQxLjMzMjc4NzMsMTkuMDA1OTE3MSBDMzkuNDEwMTQ4NCwxMC42MDkzMTk5IDMxLjk5MDg2ODksNC43NDUyNzg0IDIzLjI5MDI2OTEsNC43NDUyNzg0IEMxMy4wODg0MzA3LDQuNzQ1Mjc4NCA0Ljc4ODE2MTE4LDEyLjk3MzQ3MzcgNC43ODgxNjExOCwyMy4wODY3MjYgQzQuNzg4MTYxMTgsMzMuMjAxMjgzNiAxMy4wODg0MzA3LDQxLjQyOTQ3ODkgMjMuMjkwMjY5MSw0MS40Mjk0Nzg5IEMzMi4xMTA3MDQ2LDQxLjQyOTQ3ODkgMzkuNzQ0NjM0OSwzNS4yMTI5Njg0IDQxLjQ0MzQwNDgsMjYuNjUwNTgwMiBMNDYuMTQyMDE4NSwyNy41NjU2OTQzIEM0NC4wMDIwOTUsMzguMzQ4NjM3OCAzNC4zOTI4NTA3LDQ2LjE3NDc1NzMgMjMuMjkwMjY5MSw0Ni4xNzQ3NTczIEMxMC40NDgwOTQyLDQ2LjE3NDc1NzMgMCwzNS44MTczODc2IDAsMjMuMDg2NzI2IFoiIGlkPSJGaWxsLTMtQ29weSI+PC9wYXRoPgogICAgICAgICAgICAgICAgPC9nPgogICAgICAgICAgICAgICAgPGcgaWQ9ImNlbnRlciIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMzQuMDAwMDAwLCAzNC4wMDAwMDApIj4KICAgICAgICAgICAgICAgICAgICA8cGF0aCBkPSJNMTEuOTMzMjgwNyw1Ljk3MDg3Mzc3IEMxMS45MzMyODA3LDkuMjY4ODgzMjIgOS4yNjI1ODY2MywxMS45NDE3NDc1IDUuOTY3MjU1MTgsMTEuOTQxNzQ3NSBDMi42NzE5MjM2MiwxMS45NDE3NDc1IDAsOS4yNjg4ODMyMiAwLDUuOTcwODczNzcgQzAsMi42NzI4NjQzMSAyLjY3MTkyMzYyLDAgNS45NjcyNTUxOCwwIEM5LjI2MjU4NjYzLDAgMTEuOTMzMjgwNywyLjY3Mjg2NDMxIDExLjkzMzI4MDcsNS45NzA4NzM3NyIgaWQ9IkZpbGwtNCI+PC9wYXRoPgogICAgICAgICAgICAgICAgPC9nPgogICAgICAgICAgICA8L2c+CiAgICAgICAgPC9nPgogICAgPC9nPgo8L3N2Zz4='
		);

		add_submenu_page(
			'sigmie',
			esc_html__('Settings', 'sigmie'),
			esc_html__('Settings', 'sigmie'),
			$this->capability,
			$this->slug,
			array($this, 'display_settings_page'),
		);
	}

	function display_settings_page()
	{
		require_once dirname(__FILE__) . '/partials/settings.php';
	}

	public function print_section_settings()
	{
		echo '<p>' .
			wp_kses(
				sprintf(
					__('Configure your Sigmie account credentials. You can find them in the <a href="%s" target="_blank">API Keys</a> section of your Sigmie dashboard.', 'sigmie'),
					'https://app.sigmie.com/api-keys'
				),
				[
					'a' => [
						'href'   => [],
						'target' => [],
					],
				]
			) . '</p>';
		echo '<p>' . esc_html__('Once you provide your Sigmie Application ID and API key, this plugin will be able to securely communicate with Sigmie servers.', 'sigmie') . ' ' . esc_html__('We ensure your information is correct by testing them against the Sigmie servers upon save.', 'sigmie') . '</p>';

		echo '<p>' . wp_kses_post(sprintf(__('No Sigmie account yet? <a href="%s">Follow this link</a> to create one for free in a couple of minutes!', 'sigmie'), 'https://app.sigmie.com/sign-up')) . '</p>';
	}

	function product_tab($product_data_tabs)
	{
		$product_data_tabs['sigmie'] = [
			'label'  => __('Sigmie Search', 'sigmie'),
			'target' => 'sigmie',
			'class'    => [],
		];

		return $product_data_tabs;
	}

	function product_tab_content()
	{
	?>
		<div id="sigmie" class="panel woocommerce_options_panel hidden">

			<div class="options_group">
				<?php

				woocommerce_wp_text_input([
					'id'    => 'sigmie_boost',
					'label' => __('Boost', 'sigmie'),
					'desc_tip'    => true,
					'description' => __('Enter a value to boost this product in the search results. Higher values will make this product appear higher in the search results.', 'sigmie')
				]);

				?>
			</div>
		</div>
	<?php
	}

	function product_tab_fields($post_id, $post)
	{
		$product = wc_get_product($post);

		if (isset($_POST['sigmie_boost'])) {
			$boost = !empty($_POST['sigmie_boost']) ? sanitize_text_field($_POST['sigmie_boost']) : '1'; // Default value set to '1'
			$product->update_meta_data('sigmie_boost', (int) $boost);
		} else {
			if ($product->meta_exists('sigmie_boost')) {
				$product->delete_meta_data('sigmie_boost');
			}
		}

		$product->save();
	}

	function post_trashed($post_id)
	{
		if (get_post_type($post_id) !== 'product') {
			return;
		}

		$product = wc_get_product($post_id);

		if (!$product->is_type('variable')) {

			$this->sigmie->deleteDocument($this->index, $post_id);

			return;
		}

		$body = [];

		/** @var WC_Product_Variation $variation  */
		foreach ($product->get_available_variations('objects') as $variation) {

			$body[] = [
				'_id' => $variation->get_id(),
				'action' => 'upsert',
				'body' => $this->map_product($variation)
			];
		}

		$this->sigmie->batchWrite($this->index, $body);
	}

	function post_untrashed($post_id)
	{
		if (get_post_type($post_id) !== 'product') {
			return;
		}

		$product = wc_get_product($post_id);

		if (!$product->is_type('variable')) {
			$body =  $this->map_product($product);

			$this->sigmie->upsertDocument($this->index, $body, $post_id);
			return;
		}

		$body = [];

		/** @var WC_Product_Variation $variation  */
		foreach ($product->get_available_variations('objects') as $variation) {

			$body[] = [
				'_id' => $variation->get_id(),
				'action' => 'upsert',
				'body' => $this->map_product($variation)
			];
		}

		$this->sigmie->batchWrite($this->index, $body);
	}

	/**
	 * @param  int $order_id Order ID.
	 */
	function order_completed($order_id)
	{
		$order = wc_get_order($order_id);

		$items = $order->get_items();

		foreach ($items as $item_id => $item) {

			$product_id = $item->get_product_id();

			$product = wc_get_product($product_id);

			$this->product_updated($product_id, $product);
		}
	}

	function product_updated($product_id, $product)
	{
		if (!$product->is_type('variable')) {
			$body =  $this->map_product($product);

			$this->sigmie->upsertDocument($this->index, $body, $product_id);
			return;
		}

		$body = [];

		/** @var WC_Product_Variation $variation  */
		foreach ($product->get_available_variations('objects') as $variation) {

			$body[] = [
				'_id' => $variation->get_id(),
				'action' => 'upsert',
				'body' => $this->map_product($variation)
			];
		}

		$this->sigmie->batchWrite($this->index, $body);
	}

	function product_created($product_id, $product)
	{
		if (!$product->is_type('variable')) {
			$body =  $this->map_product($product);

			$this->sigmie->upsertDocument($this->index, $body, $product_id);
			return;
		}

		$body = [];

		/** @var WC_Product_Variation $variation  */
		foreach ($product->get_available_variations('objects') as $variation) {

			$body[] = [
				'_id' => $variation->get_id(),
				'action' => 'upsert',
				'body' => $this->map_product($variation)
			];
		}

		$this->sigmie->batchWrite($this->index, $body);
	}

	function re_index()
	{
		$page     = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_SPECIAL_CHARS);
		$perPage = 100;

		$args = array(
			'post_type'      => 'product',
			'posts_per_page' => $perPage
		);

		$loop = new WP_Query($args);

		$total_pages = ceil($loop->found_posts / $perPage);

		$docs = [];

		while ($loop->have_posts()) : $loop->the_post();

			/** @var  WC_Product_Variable $product */
			global $product;

			if (!$product->is_type('variable')) {

				$docs[] = [
					'_id' => $product->get_id(),
					'action' => 'upsert',
					'body' => $this->map_product($product)
				];

				continue;
			}

			/** @var WC_Product_Variation $variation  */
			foreach ($product->get_available_variations('objects') as $variation) {

				$body[] = [
					'_id' => $variation->get_id(),
					'action' => 'upsert',
					'body' => $this->map_product($variation)
				];
			}

		endwhile;

		wp_reset_postdata();

		$this->sigmie->batchWrite($this->index, $docs);

		$response = array(
			'totalPagesCount' => $total_pages,
			'finished'        => $page >= $total_pages,
		);

		wp_send_json($response);
	}

	/**
	 * @param WC_Product_Variable $product 
	 * 
	 * @return array 
	 */
	function map_product($product)
	{

		$data = $product->get_data();

		$attributes = $product->get_attributes();

		$price = wc_price($data['price']);

		$image_html = $product->get_image();
		preg_match('/src="([^"]*)"/i', $image_html, $image_array);
		$image_url = $image_array[1];

		$gallery_image_ids = $product->get_gallery_image_ids();
		$gallery_images = array_map(function ($image_id) {
			return wp_get_attachment_url($image_id);
		}, $gallery_image_ids);

		$sold_times = get_post_meta($product->get_id(), 'total_sales', true);

		$brands = [];

		$brandTerms = get_the_terms($product->get_id(), 'brand');

		if ($brandTerms) {
			$brands = array_map(fn ($brand) => $brand->name, $brandTerms);
		}

		$tags = [];

		$tagTerms = get_the_terms($product->get_id(), 'product_tag');

		if ($tags) {
			$tags = array_map(fn ($tag) => $tag->name, $tagTerms);
		}

		$res = [
			'thumbnail_html' => $product->get_image(),
			'times_sold' => $sold_times,
			'brands' => $brands,
			'tags' => $tags,
			'image' => $image_url,
			'gallery_image' => $gallery_images,
			'gallery_images' => $gallery_images,
			'link' => $product->get_permalink(),
			'price_as_number' => $product->get_price(),
			'price' => $price,
			'on_sale' => $product->is_on_sale(),
			'price_html' => $product->get_price_html(),
			'review_count' => $data['review_count'],
			'average_rating' => $data['average_rating'],
			'slug' => $data['slug'],
			'name' => $data['name'],
			'sku' => $data['sku'],
			'date_created' => $data['date_created']->date('Y-m-d\TH:i:s.uP'),
			'short_description' => $data['short_description'],
			'description' => $data['description'],
			'stock_status' => $data['stock_status'],
			'is_featured' => $data['featured'],
			'total_sales' => $product->get_total_sales(),
			'categories' => array_map(function ($categoryId) {

				$category = get_term($categoryId, 'product_cat');

				return $category->name;
			}, $data['category_ids']),
			// If featured and no boost set, set to 1.1
			'boost' => array_reduce($data['meta_data'], function ($carry, WC_Meta_Data $metaData) use ($data) {
				if ($metaData->get_data()['key'] === 'sigmie_boost') {
					$carry = (float) $metaData->get_data()['value'];
					if ($data['featured'] && $carry === 1.0) {
						$carry = 1.1;
					}
				}
				return $carry;
			}, 1)
		];

		/** @var WC_Product_Attribute|string $attribute  */
		foreach ($attributes as $name => $attribute) {

			if ($attribute instanceof WC_Product_Attribute) {
				$options = $attribute->get_options();
				$options_text = array_map(function ($option_id) use ($attribute) {
					return get_term_by('id', $option_id, $attribute->get_taxonomy())->name;
				}, $options);

				$attribute = $options_text;
			}

			$res[$name] = $attribute;
		}

		return $res;
	}
	function render_sigmie_product_listing($args)
	{
		$options = get_options([
			'sigmie_application_id',
			'sigmie_search_api_key',
			'sigmie_filterable_attributes',
			'sigmie_theme',
			'sigmie_filterable_attributes',
			'sigmie_show_price_range_chart',
			'sigmie_show_categories_filter',
			'sigmie_products_per_page',
			'sigmie_currency_symbol',
			'sigmie_show_offers_filter',
			'sigmie_products_title_text',
			'sigmie_products_subtitle_template',
			'sigmie_filters_title_text',
			'sigmie_reset_filters_text',
			'sigmie_price_range_label',
			'sigmie_show_products_count',
			'sigmie_price_range_filter_label',
			'sigmie_offers_filter_text',

			//
			'sigmie_offers_filter_text',
			'sigmie_no_products_text',
			'sigmie_no_products_advice_text',
			'sigmie_sort_by_relevance_label',
			'sigmie_sort_by_price_desc_label',
			'sigmie_sort_by_price_asc_label',
			'sigmie_sort_by_most_recent_label',
			'sigmie_sort_by_rating_label',
			'sigmie_sort_by_product_sales_label',

			'sigmie_filters_order',
			'sigmie_range_attributes',
			'sigmie_checkbox_attributes',
			'sigmie_selectbutton_attributes',
			'sigmie_color_attributes_color',
		]);

		$predefinedFilters = '';

		if ($args['categories'] ?? false) {
			$categories = explode(',', $args['categories'] ?? '');
			$categories = array_map(fn ($category) => "'{$category}'", $categories);

			$predefinedFilters = "categories:[" . implode(',', $categories) . "]";
		}

		$colorAttributes = (string) get_option('sigmie_color_attributes_color', '[]');
		$colorAttributes = json_decode($colorAttributes, true);

		$sortedAttributes = [];
		$attributeLabels = [];

		foreach (wc_get_attribute_taxonomies() as $attribute) {
			$attributeLabels['pa_' . $attribute->attribute_name] = $attribute->attribute_label;
			$sortedAttributes['pa_' . $attribute->attribute_name] = array_map(function (WP_Term $term) {
				return $term->name;
			}, get_terms([
				'taxonomy' => 'pa_' . $attribute->attribute_name,
				'hide_empty' => false,
			]));
		}

		$attributes = [];

		if ($options['sigmie_filters_order']) {
			$attributes = json_decode($options['sigmie_filters_order']);
		}

		$facets = implode(' ', $attributes);

		$rangeFacets = ['price_as_number', ...json_decode($options['sigmie_range_attributes'], true)];
		$checkboxFacets = ['categories', 'brands', ...json_decode($options['sigmie_checkbox_attributes'], true)];
		$selectButtonFacets  = [...json_decode($options['sigmie_selectbutton_attributes'], true)];
		$colorFacets = [...array_keys($colorAttributes)];

		$facetTypes = array_merge(
			array_fill_keys($rangeFacets, 'number-facet'),
			array_fill_keys($checkboxFacets, 'checkbox-facet'),
			array_fill_keys($selectButtonFacets, 'selectbutton-facet'),
			array_fill_keys($colorFacets, 'color-facet')
		);

		$facetProps = [];

		foreach ($attributes as $attribute) {
			$facetProps[$attribute] = [
				'name' => $attribute
			];
		}

		foreach ($attributes as $index => $attribute) {
			$facetProps[$attribute]['expanded'] = true;
		}

		foreach ($rangeFacets as $attribute) {
			$facetProps[$attribute]['step'] = 1;
			$facetProps[$attribute]['from_label'] = 'from % $';
			$facetProps[$attribute]['to_label'] = 'to % $';
			$facetProps[$attribute]['operator'] = 'AND';
		}

		foreach ($attributeLabels as $attribute => $attributeLabel) {
			$facetProps[$attribute]['label'] = $attributeLabel;
		}

		foreach ($facetTypes as $key => $type) {
			$facetProps[$key]['component'] = $type;
		}

		foreach ($sortedAttributes as $key => $values) {
			$facetProps[$key]['sorted_values'] = $values;
			$facetProps[$attribute]['operator'] = 'OR';
		}

		foreach ($colorAttributes as $key => $value) {
			$facetProps[$key]['value_colors'] = $value;
			$facetProps[$key]['operator'] = ' OR ';
		}

		$facetProps['price_as_number']['symbol'] = get_woocommerce_currency_symbol();
		$facetProps['price_as_number']['label'] = $options['sigmie_price_range_label'];
		$facetProps['price_as_number']['step'] = 1;
		$facetProps['price_as_number']['from_label'] = 'from % $';
		$facetProps['price_as_number']['to_label'] = 'to % $';
		$facetProps['price_as_number']['operator'] = ' AND ';


		$facetProps['categories']['label'] = 'Categories';
		$facetProps['categories']['operator'] = ' OR ';

		$facetProps['brands']['label'] = 'Brands';
		$facetProps['brands']['operator'] = ' OR ';

		$facetProps = array_filter($facetProps, function ($prop) {
			return !is_null($prop['component'] ?? null);
		});

		$index = 0;
		$facetProps = array_map(function ($prop) use (&$index) {
			$prop['index'] = $index;

			$index++;

			return $prop;
		}, $facetProps);

		// dd($facetProps);
		$props = [
			'facets' => $facetProps,
			'sigmie' => [
				'filters' => $predefinedFilters,
				'facets' => $facets,
				'application' => $options['sigmie_application_id'],
				'api_key' => $options['sigmie_search_api_key'],
				'index' => $this->index,
			],
			'options' => [
				'show_offers_filter' => $options['sigmie_show_offers_filter'] === '1',
				'per_page' => (int) $options['sigmie_products_per_page']
			],
			'texts' => [
				'products_title_text' => $options['sigmie_products_title_text'],
				'products_subtitle_template' => $options['sigmie_products_subtitle_template'],
				'filters_title_text' => $options['sigmie_filters_title_text'],
				'offers_filter_text' => $options['sigmie_offers_filter_text'],
				'reset_filters_text' => $options['sigmie_reset_filters_text'],
				'price_range_filter_label' => $options['sigmie_price_range_filter_label'],
				'offers_filter_text' => $options['sigmie_offers_filter_text'],
				'no_products_text' => $options['sigmie_no_products_text'],
				'no_products_advice_text' => $options['sigmie_no_products_advice_text'],
			],
			'sort' => [
				'default_option' => [
					'label' => $options['sigmie_sort_by_relevance_label'],
					'value' => "_score",
				],
				'options' => [
					[
						'label' => $options['sigmie_sort_by_relevance_label'],
						'value' => "_score",
					],
					[
						'label' => $options['sigmie_sort_by_price_desc_label'],
						'value' => "price_as_number:desc",
					],
					[
						'label' => $options['sigmie_sort_by_price_asc_label'],
						'value' => "price_as_number:asc",
					],
					[
						'label' => $options['sigmie_sort_by_product_sales_label'],
						'value' => "total_sales:desc",
					],
					[
						'label' => $options['sigmie_sort_by_rating_label'],
						'value' => "average_rating:desc",
					],
					[
						'label' => $options['sigmie_sort_by_most_recent_label'],
						'value' => "date_created:desc",
					]
				]
			]
		];

		return '<div class="" id="sigmie-filters">
					<product-listing v-bind="' . htmlspecialchars(json_encode($props)) . '">
					</product-listing>
				</div>';
	}

	function render_sigmie_search_bar()
	{
		$options = get_options([
			'sigmie_nothing_found_text',
			'sigmie_sort_by',
			'sigmie_number_of_results',
			'sigmie_max_description_length',
			'sigmie_show_category',
			'sigmie_show_description',
			'sigmie_show_price',
			'sigmie_show_rating',
			'sigmie_show_sku',
			'sigmie_show_stock',
			'sigmie_show_on_sale',
			'sigmie_application_id',
			'sigmie_search_api_key',

			'sigmie_search_field_text',
			'sigmie_show_loader',
			'sigmie_search_field_height',
			'sigmie_search_field_width',
			'sigmie_corner_radius',
			'sigmie_show_categories',
			'sigmie_number_of_categories'
		]);

		return '<div class="container flex flex-wrap items-center justify-between mx-auto" id="sigmie-search">
			<search 
				search-field-text="' . (string) $options['sigmie_search_field_text'] . '" 
				:show-loader="' . (string) ($options['sigmie_show_loader'] === '1' ? 'true' : 'false') . '" 
				search-field-height="' . (int) $options['sigmie_search_field_height'] . '" 
				search-field-width="' . (int) $options['sigmie_search_field_width'] . '" 
				corner-radius="' . (int) $options['sigmie_corner_radius'] . '" 
				:show-categories="' . (string) ($options['sigmie_show_categories'] === '1' ? 'true' : 'false') . '" 


				nothing-found-text="' . $options['sigmie_nothing_found_text'] . '" 
				sort-by="' . $options['sigmie_sort_by'] . '"
				number-of-results="' . $options['sigmie_number_of_results'] . '"
				number-of-categories="' . $options['sigmie_number_of_categories'] . '"
				max-description-length="' . $options['sigmie_max_description_length'] . '"
				:show-category="' . ($options['sigmie_show_category'] === '1' ? 'true' : 'false') . '"
				:show-description="' . ($options['sigmie_show_description'] === '1' ? 'true' : 'false') . '"
				:show-price="' . ($options['sigmie_show_price'] === '1' ? 'true' : 'false') . '"
				:show-rating="' . ($options['sigmie_show_rating'] === '1' ? 'true' : 'false') . '"
				:show-sku="' . ($options['sigmie_show_sku'] === '1' ? 'true' : 'false') . '"
				:show-stock="' . ($options['sigmie_show_stock'] === '1' ? 'true' : 'false') . '"
				:show-on-sale="' . ($options['sigmie_show_on_sale'] === '1' ? 'true' : 'false') . '"
				application="' . $options['sigmie_application_id'] . '" 
				api-key="' . $options['sigmie_search_api_key'] . '" 
				index="' . $this->index . '">

			</search>
		</div>';
	}

	function register_sigmie_widget()
	{
		register_widget('Sigmie_Search_Widget');
	}

	function sigmie_template_include($template)
	{
		if (get_post(get_the_ID())->post_name === 'shop' && (int) get_option('woocommerce_shop_page_id') === (int)get_option('sigmie_product_listing_page_id')) {
			$new_template = plugin_dir_path(__FILE__) . 'class-sigmie-filters-template.php';
			if (file_exists($new_template)) {
				return $new_template;
			}
		}

		return $template;
	}

	function add_display_post_states($post_states, $post)
	{
		if ((int)get_option('sigmie_product_listing_page_id') === $post->ID) {
			$post_states['sigmie_product_listing_page'] = __('Sigmie product listing', 'sigmie');
		}

		return $post_states;
	}

	function register_attribute_types($types)
	{
		$types = array_merge([
			'sgm-buttonselect' => esc_html__('Button Select', 'sigmie'),
			'sgm-number' => esc_html__('Number', 'sigmie'),
			'sgm-color' => esc_html__('Color', 'sigmie'),
		], $types);

		return $types;
	}

	function attribute_orderby_field()
	{

	?>
		<div class="form-field">
			<label for="sigmie_attribute_facets_orderby"><?php esc_html_e('Facets sort order', 'sigmie'); ?></label>
			<select name="sigmie_attribute_facets_orderby" id="sigmie_attribute_facets_orderby">
				<option value="top"><?php esc_html_e('Top', 'sigmie'); ?></option>
				<option value="asc"><?php esc_html_e('Ascending', 'sigmie'); ?></option>
				<option value="desc"><?php esc_html_e('Descending', 'sigmie'); ?></option>
			</select>
			<p class="description"><?php esc_html_e('Determines the sort order of the facets on the frontend shop product pages.', 'sigmie'); ?></p>
		</div>
<?php
	}
}
