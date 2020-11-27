<?php

namespace InstafeedHub\Elementor;

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
}