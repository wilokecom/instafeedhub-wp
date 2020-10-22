<?php
/**
 * Plugin Name: wiloke-instafeedhub — CGB Gutenberg Block Plugin
 * Plugin URI: https://github.com/ahmadawais/create-guten-block/
 * Description: wiloke-instafeedhub — is a Gutenberg plugin created via create-guten-block.
 * Author: mrahmadawais, maedahbatool
 * Author URI: https://AhmadAwais.com/
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
define( 'WILOKE_IFH_NAMESPACE', 'wiloke/v1/instafeedhub' );
define( 'WILOKE_IFH_VERSION', 0.1 );
define( 'WILOKE_IFH_PREFIX', 'wiloke_instafeedhub_' );
require_once plugin_dir_path( __FILE__) . 'vendor/autoload.php';
/**
 * Block Initializer.
 */
require_once plugin_dir_path( __FILE__ ) . 'src/init.php';

new \WilokeInstaFeedHub\Controllers\RemoteDataController();

