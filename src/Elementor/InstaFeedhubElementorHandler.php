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
		add_action('elementor/editor/before_enqueue_scripts', [$this, 'enqueueScripts']);
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
		}

		wp_localize_script('jquery', 'instafeedHubElements', $this->getInstafeedHubElements());
	}

	/**
	 * @return array|bool
	 */
	public function getInstafeedHubElements()
	{
		if (!isset($_GET['action']) || $_GET['action'] !== 'elementor') {
			return false;
		}

		global $post;
		$postID = $post->ID;
		$aData = get_post_meta($postID, '_elementor_data', true);
		$aData = json_decode($aData, false);

		$aInstaElements = [];
		foreach ($aData as $sectionKey => $sectionItem) {
			$aElements = $sectionItem->elements;
			foreach ($aElements as $item) {
				$aWidget = $item->elements;
				foreach ($aWidget as $widgetItem) {
					if ($widgetItem->widgetType == 'instagram-feedhub') {
						$aInstaElements[$widgetItem->id] = [
							'widgetID'       => $widgetItem->id,
							'buttonID'       => 'instagram-feedhub-' . $widgetItem->id,
							'instagramID'    => '',
							'instagramTitle' => ''
						];
					}
				}
			}
		}

		return $aInstaElements;
	}
}
