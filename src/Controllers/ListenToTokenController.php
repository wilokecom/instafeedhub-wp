<?php


namespace InstafeedHub\Controllers;


use InstafeedHub\Helpers\Session;
use InstafeedHub\Helpers\User;

class ListenToTokenController {
	public function __construct() {
		add_action( 'admin_enqueue_scripts', [ $this, 'adminScripts' ] );
		add_action( 'wp_ajax_instafeedhub_save_tokens', [ $this, 'saveInstafeedHubTokens' ] );
	}

	public function adminScripts() {
		if ( ( ! isset( $_GET['post_type'] ) && ! isset( $_GET['post'] ) ) || ! current_user_can( 'edit_posts' ) ) {
			return false;
		}

		$aTokens = User::getTokens();

		if ( isset( $_GET['post'] ) ) {
			$aArgs['id'] = abs( $_GET['post'] );
		}

		$aData = [
			'accessToken'    => $aTokens['accessToken'],
			'refreshToken'   => $aTokens['refreshToken'],
			//			'email'        => get_option( 'admin_email' ),
			'variation'      => 'instafeedhub',
			'email'          => uniqid( 'fake' ) . '@gmail.com',
			'nickname'       => User::getUserNickname(),
			'whitelistedUrl' => home_url( '/' ),
			'createdAt'      => time(),
			'version'        => IFH_VERSION
		];
		if ( isset( $_GET['post'] ) ) {
			$aData['id'] = abs( $_GET['post'] );
		}

		wp_localize_script( 'jquery', 'InstafeedHubTokens', $aData );
	}

	public function saveInstafeedHubTokens() {
		if ( ! isset( $_POST['payload']['accessToken'] ) || ! isset( $_POST['payload']['refreshToken'] ) ) {
			wp_send_json_error( [ 'msg' => 'The tokens are required' ] );
		}

		$aTokens = [
			'accessToken'  => $_POST['payload']['accessToken'],
			'refreshToken' => $_POST['payload']['refreshToken'],
		];

		update_user_meta( get_current_user_id(), 'instafeed_hub_token', $aTokens );

		wp_send_json_success( esc_html__( 'The data has been updated', 'wiloke-instafeed-hub' ) );
	}
}
