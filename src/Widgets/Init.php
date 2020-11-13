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
//		add_action('init', [$this, 'init']);
		add_action('admin_enqueue_scripts', [$this, 'handleWidget']);
	}

//	public function init()
//	{
////		$aSidebarWidget = wp_get_sidebars_widgets();
////		echo "<pre>";
////		print_r($aSidebarWidget);
////		echo "</pre>";
////		die;
////		echo "<pre>";
////		print_r(wp_get_sidebars_widgets());
////		echo "</pre>";
////		die;
//		//		echo _get_widget_id_base('instagram-feed-4');
////		global $wp_widget_factory, $wp_registered_widgets, $wp_registered_sidebars;
////		echo "<pre>";
////		print_r($wp_registered_widgets);
////		echo "</pre>";
////		die;
//	}

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
}
