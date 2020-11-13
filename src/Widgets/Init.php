<?php

namespace InstafeedHub\Widgets;

/**
 * Class Init
 * @package InstafeedHub\Widgets
 */
class Init
{
	public function __construct()
	{
		add_action('widgets_init', [$this, 'register']);
		add_action('admin_enqueue_scripts', [$this, 'handleWidget']);
		add_action('wp_ajax_nopriv_save_instagram_widget', [$this, 'saveInstagramWidget']);
	}

	public function register()
	{
		register_widget('InstafeedHub\Widgets\InstagramFeed');
	}

	public function handleWidget()
	{
		global $pagenow;

		if ($pagenow == 'widgets.php') {
			wp_enqueue_script(
				'handle-widget',
				IFH_ASSETS . 'js/handle-widget.js',
				[],
				IFH_VERSION,
				true
			);
			wp_localize_script('jquery', 'instafeedHubElements', $this->getInstafeedHubElements());
		}
	}

	/**
	 * @param $baseID
	 * @return array
	 */
	public function getWidgetID($baseID)
	{
		$aSidebarWidget = wp_get_sidebars_widgets();
		$aWidgetIDs = [];
		foreach ($aSidebarWidget as $sideBar => $aWidget) {
			foreach ($aWidget as $key => $widgetID) {
				if (_get_widget_id_base($widgetID) == $baseID) {
					$aWidgetIDs[] = $widgetID;
				}
			}
		}

		return $aWidgetIDs;
	}

	/**
	 * @return array|object
	 */
	public function getInstafeedHubElements()
	{
		$aWidgetIDs = $this->getWidgetID('instagram-feed');
		if (empty($aWidgetIDs)) {
			return (object)[];
		}
		$aElements = [];
		foreach ($aWidgetIDs as $widgetID) {
			$aElements[$widgetID] = [
				'buttonID'    => 'widget-' . $widgetID . '-button',
				'instagramID' => ''
			];
		}

		return $aElements;
	}

	public function saveInstagramWidget()
	{

	}
}
