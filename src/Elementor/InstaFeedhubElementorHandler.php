<?php

namespace InstafeedHub\Elementor;
use InstafeedHub\Helpers\Option;
use InstafeedHub\Helpers\User;

/**
 * Class InstaFeedhubElementorHandler
 * @package InstafeedHub\Elementor
 */
class InstaFeedhubElementorHandler
{
	public function __construct()
	{
		add_action('elementor/editor/after_enqueue_scripts', [$this, 'enqueueScripts']);
		add_action('elementor/editor/after_save', [$this, 'saveInstaIds'], 10);
		add_action('elementor/editor/before_enqueue_scripts', [$this, 'adminScripts']);
	}


	public function enqueueScripts()
	{
		if (isset($_GET['action']) && $_GET['action'] == 'elementor') {
			wp_enqueue_script(
				'handle-elementor',
				IFH_ASSETS . 'js/handle-elementor.js',
				[],
				IFH_VERSION,
				true
			);

			// === EDEN TUAN JS === //
			wp_enqueue_script(
				'instafeedhubElementor-fokedJs',
				IFH_ASSETS . 'forElementor/foked.js',
				[],
				IFH_VERSION,
				true
			);
			wp_enqueue_style(
				'instafeedhubElementor-fokedCss',
				IFH_ASSETS . 'forElementor/foked.css',
				[],
				IFH_VERSION,
				'all'
			);
		}
	}

	/**
	 * @param $postId
	 * @return bool
	 */
	public function saveInstaIds($postId)
	{
		if (!current_user_can('edit_posts')) {
			return false;
		}

		$content = get_post_field('post_content', $postId);

		if (preg_match_all('/InstagramID:([\d]+)/', $content, $aMatches)) {
			if (isset($aMatches[1])) {
				update_post_meta($postId, 'instafeedhub_ids', $aMatches[1]);
			}
		}
	}

	/**
	 * @return bool
	 */
	public function adminScripts()
	{
		if (!current_user_can('edit_posts')) {
			return false;
		}

		if (!isset($_GET['post']) && !isset($_GET['action ']) && $_GET['action '] !== 'elementor') {
			return false;
		}

		$aTokens = Option::getTokens();

		$aData = [
			'accessToken'    => $aTokens['accessToken'],
			'email'          => get_option('admin_email'),
			'variation'      => 'instafeedhub',
			'nickname'       => User::getUserNickname(),
			'whitelistedUrl' => home_url('/'),
			'createdAt'      => time(),
			'version'        => IFH_VERSION
		];
		if (isset($_GET['post'])) {
			$aData['id'] = abs($_GET['post']);
		}

		wp_localize_script('jquery', 'InstafeedHubTokens', $aData);
	}

}