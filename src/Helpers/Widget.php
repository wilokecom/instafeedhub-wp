<?php

namespace InstafeedHub\Helpers;

/**
 * Class Widget
 * @package InstafeedHub\Helpers
 */
class Widget {
	/**
	 * @param $baseID
	 * @return array
	 */
	public static function getWidgetIDsByBaseID($baseID)
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
	 * @param $widgetID
	 * @return string
	 */
	public static function getInstaIDByWidgetID($widgetID)
	{
		$aInstaWidget = get_option('widget_instagram-feed');
		$number = intval(end(explode('-', $widgetID)));
		$instaID = ($aInstaWidget[$number]['instaId'] == null) ? '' : $aInstaWidget[$number]['instaId'];

		return $instaID;
	}
}
