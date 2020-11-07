<?php
/**
 * Plugin Name: InstafeedHub
 * Plugin URI: https://instafeedhub.com/
 * Description: The easiest way to integrate Instagram to your website
 * Author: instafeedhub
 * Author URI: https://instafeedhub.com/
 * Version: 1.0.0
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package CGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'IFH_URL' ) ) {
	define( 'IFH_URL', 'https://instafeedhub.com/' );
	define( 'IFH_NAMESPACE', 'wiloke/v1/instafeedhub' );
	define( 'IFH_VERSION', 0.1 );
	define( 'IFH_PREFIX', 'instafeedhub_' );
}

require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';
/**
 * Block Initializer.
 */
require_once plugin_dir_path( __FILE__ ) . 'src/init.php';

use InstafeedHub\Controllers\ListenToTokenController;
use InstafeedHub\Controllers\RemoteDataController;

new RemoteDataController();
new ListenToTokenController();