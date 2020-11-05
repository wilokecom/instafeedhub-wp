<?php
/**
 * Plugin Name: Wiloke InstaFeedhub
 * Plugin URI: https://github.com/ahmadawais/create-guten-block/
 * Description: The easiest way to integrate Instagram to your website
 * Author: instafeedhub
 * Author URI: https://AhmadAwais.com/
 * Version: 1.0.0
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package CGB
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}
define('WILOKE_IFH_NAMESPACE', 'wiloke/v1/instafeedhub');
define('WILOKE_IFH_VERSION', 0.1);
define('WILOKE_IFH_PREFIX', 'wiloke_instafeedhub_');
require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';
/**
 * Block Initializer.
 */
require_once plugin_dir_path(__FILE__) . 'src/init.php';

use WilokeInstaFeedHub\Controllers\RemoteDataController;

new RemoteDataController();

