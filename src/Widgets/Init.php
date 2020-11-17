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
		add_action('wp_ajax_save_instagram_widget', [$this, 'saveInstagramWidget']);
		add_action('widgets_init', [$this, 'register']);
		add_action('admin_enqueue_scripts', [$this, 'handleWidget']);
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
			// === EDEN TUAN JS === //
			wp_enqueue_script(
				'instafeedhub-fokedJs',
				IFH_ASSETS . 'forWidget/foked.js',
				[],
				IFH_VERSION,
				true
			);
			wp_enqueue_style(
				'instafeedhub-fokedCss',
				IFH_ASSETS . 'forWidget/foked.css',
				[],
				IFH_VERSION,
				'all'
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
		$aInstaWidget = get_option('widget_instagram-feed');
		foreach ($aWidgetIDs as $widgetID) {
			$number = end(explode('-', $widgetID));
			$aElements[$widgetID] = [
				'widgetID'       => $widgetID,
				'buttonID'       => 'widget-' . $widgetID . '-button',
				'instagramID'    => $aInstaWidget[$number]['instaId'],
				'instagramTitle' => $aInstaWidget[$number]['instaTitle'],
			];
		}

		return $aElements;
	}

	/**
	 * @return bool
	 */
	public function saveInstagramWidget()
	{
		if (!isset($_POST['action']) || $_POST['action'] !== 'save_instagram_widget') {
			return false;
		}

		$oldInstaWidget = get_option('widget_instagram-feed');
		$widgetID = $_POST['widgetID'];
		$number = end(explode('-', $widgetID));
		$newWidgetID = $oldInstaWidget[$number] = [
			'widgetID'   => $widgetID,
			'instaId'    => $_POST['instaId'],
			'instaTitle' => $_POST['instaTitle'],
		];

		update_option('widget_instagram-feed', $newWidgetID);
	}
}