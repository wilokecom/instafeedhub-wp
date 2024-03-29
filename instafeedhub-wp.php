<?php
/**
 * Plugin Name: InstafeedHub WP
 * Plugin URI: https://instafeedhub.com/
 * Description: The easiest way to integrate Instagram to your website
 * Author: instafeedhub
 * Author URI: https://instafeedhub.com/
 * Version: 1.0.2
 * Language: instafeedhub-wp
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

if (!defined('IFH_URL')) {
	define('IFH_URL', 'https://instafeedhub.com/');
	define('IFH_NAMESPACE', 'wiloke/v1/instafeedhub');
	define('IFH_VERSION', 1.0.2);
	define('IFH_PREFIX', 'instafeedhub_');
	define('IFH_DIR', plugin_dir_path(__FILE__));
	define('IFH_ASSETS', plugin_dir_url(__FILE__) . 'assets/');
}

require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';
/**
 * Block Initializer.
 */
require_once plugin_dir_path(__FILE__) . 'src/init.php';

use InstafeedHub\Controllers\AdminController;
use InstafeedHub\Controllers\EnqueueScriptController;
use InstafeedHub\Controllers\ListenToTokenController;
use InstafeedHub\Controllers\RemoteDataController;
use InstafeedHub\Widget\WidgetInit;
use InstafeedHub\Elementor\ElementorInit;
use InstafeedHub\Elementor\InstaFeedhubElementorHandler;
use InstafeedHub\WPBakery\WPBakeryInit;

new RemoteDataController();
new ListenToTokenController();
new EnqueueScriptController();
new AdminController();
new WidgetInit();
new ElementorInit();
new InstaFeedhubElementorHandler();
new WPBakeryInit();
