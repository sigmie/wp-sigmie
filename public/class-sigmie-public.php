<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/nicoorfi
 * @since      1.0.0
 *
 * @package    Sigmie
 * @subpackage Sigmie/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Sigmie
 * @subpackage Sigmie/public
 * @author     Nico Orfanos <nico@sigmie.com>
 */
class Sigmie_Public
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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		$manifest = file_get_contents(plugin_dir_url(__FILE__) . '.vite/manifest.json');

		$manifestDecoded = json_decode($manifest, true);

		$vals = $manifestDecoded['resources/main.js'];

		foreach ($vals['css'] as $value) {
			wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . $value, [], $this->version, false);
		}

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/sigmie-public.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		$manifest = file_get_contents(plugin_dir_url(__FILE__) . '.vite/manifest.json');

		$manifestDecoded = json_decode($manifest, true);

		$vals = $manifestDecoded['resources/main.js'];

		// dd('d');

		//  file_get_contents(plugin_dir_url(__FILE__));
		// wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/sigmie-public.js', array('jquery'), $this->version, false);
		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . $vals['file'], [], $this->version, false);

		wp_enqueue_script('vite-client', 'http://127.0.0.1:5173/@vite/client', array(), null, true);
		wp_enqueue_script('vite-main', 'http://127.0.0.1:5173/main.js', array('vite-client'), null, true);
	}
}
