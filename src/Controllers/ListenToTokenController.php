<?php


namespace InstafeedHub\Controllers;


use InstafeedHub\Helpers\User;

class ListenToTokenController {
	public function __construct() {
		add_action( 'admin_enqueue_scripts', [ $this, 'adminScripts' ] );
		add_action( 'wp_ajax_wilcity_save_instafeedhub_tokens', [ $this, 'saveInstafeedHubToken' ] );
	}

	public function adminScripts() {
		if ( (! isset( $_GET['post_type'] ) && ! isset( $_GET['post'] )) || !current_user_can( 'edit_posts') ) {
			return false;
		}

		$aTokens = User::getTokens();

		if ( isset( $_GET['post'] ) ) {
			$aArgs['id'] = abs( $_GET['post'] );
		}

		$aData = [
			'accessToken'  => $aTokens['accessToken'],
			'refreshToken' => $aTokens['refreshToken'],
			'email'        => get_option( 'admin_email' ),
			'nickname'     => User::getUserNickname()
		];
		if ( isset( $_GET['post'] ) ) {
			$aData['id'] = abs( $_GET['post'] );
		}

		wp_localize_script( 'jquery', 'InstafeedHubTokens', $aData );
	}

	public function saveInstafeedHubToken() {
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
