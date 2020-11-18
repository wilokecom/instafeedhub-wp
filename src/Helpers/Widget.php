<?php

namespace InstafeedHub\Helpers;

/**
 * Class Widget
 * @package InstafeedHub\Helpers
 */
class Widget
{
	private static $baseID = 'instagram-feedhub';

	/**
	 * @return array
	 */
	public static function getWidgetIDsByBaseID()
	{
		$aSidebarWidget = wp_get_sidebars_widgets();
		$aWidgetIDs = [];
		foreach ($aSidebarWidget as $sideBar => $aWidget) {
			foreach ($aWidget as $key => $widgetID) {
				if (_get_widget_id_base($widgetID) == self::$baseID) {
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
		$aInstaWidget = get_option('widget-insta-feedhub');
		$index = intval(end(explode('-', $widgetID)));
		$instaID = ($aInstaWidget[$index]['instaId'] == null) ? '' : $aInstaWidget[$index]['instaId'];

		return $instaID;
	}
}
