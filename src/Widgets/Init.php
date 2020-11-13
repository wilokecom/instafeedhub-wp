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
		add_action('widgets_init', function () {
			register_widget('InstafeedHub\Widgets\InstagramFeed');
		});

		add_action('admin_enqueue_scripts', [$this, 'handleWidget']);
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
			//	=== EDEN TUAN JS === //
			wp_enqueue_script(
				'instafeedhub1',
				IFH_ASSETS.'forWidget/foked.478f9b11.js',
				[],
				IFH_VERSION,
				true
			);
			wp_enqueue_style(
				'instafeedhub-style',
				IFH_ASSETS.'foked.2d9639e8.css',
				[],
				IFH_VERSION,
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
}
