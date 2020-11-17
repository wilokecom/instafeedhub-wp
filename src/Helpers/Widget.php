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
}
