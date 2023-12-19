<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/nicoorfi
 * @since             1.0.0
 * @package           Sigmie
 *
 * @wordpress-plugin
 * Plugin Name:       Sigmie
 * Plugin URI:        https://sigmie.app
 * Description:       Sigmie integration for WooCommerce.
 * Version:           1.0.0
 * Author:            Nico Orfanos
 * Author URI:        https://github.com/nicoorfi/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sigmie
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('SIGMIE_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sigmie-activator.php
 */
function activate_sigmie()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-sigmie-activator.php';
	Sigmie_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sigmie-deactivator.php
 */
function deactivate_sigmie()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-sigmie-deactivator.php';
	Sigmie_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_sigmie');
register_deactivation_hook(__FILE__, 'deactivate_sigmie');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-sigmie-plugin.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

use Sigmie\WordPressSigmie\Client as Sigmie;

if (!class_exists(Sigmie::class)) {
	if (is_file(__DIR__ . '/vendor/autoload_packages.php')) {
		require_once __DIR__ . '/vendor/autoload_packages.php';
	}
}

Sigmie::boot();
