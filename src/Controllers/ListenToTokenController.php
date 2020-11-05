<?php


namespace InstafeedHub\Controllers;


class ListenToTokenController
{
	public function __construct()
	{
		add_action('wp_ajax_wilcity_save_instafeedhub_tokens', [$this, 'saveInstafeedHubToken']);
	}

	public function saveInstafeedHubToken()
	{
		if (!isset($_POST['payload']['accessToken']) || !isset($_POST['payload']['refreshToken'])) {
			wp_send_json_error(['msg' => 'The tokens are required']);
		}

		$aTokens = [
			'accessToken'  => $_POST['payload']['accessToken'],
			'refreshToken' => $_POST['payload']['refreshToken'],
		];

		update_user_meta(get_current_user_id(), 'instafeed_hub_token', $aTokens);

		wp_send_json_success(esc_html__('The data has been updated', 'wiloke-instafeed-hub'));
	}
}
