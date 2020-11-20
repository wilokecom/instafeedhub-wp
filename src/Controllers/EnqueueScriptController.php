<?php
namespace InstafeedHub\Controllers;

use InstafeedHub\Helpers\Option;
use InstafeedHub\Helpers\Widget;

/**
 * Class EnqueueScriptController
 * @package InstafeedHub\Controllers
 */
class EnqueueScriptController
{
	public function __construct()
	{
		add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
		add_filter('body_class', [$this, 'addClassesToBody']);
	}

	public function addClassesToBody($aBody)
	{
		$aBody[] = 'template-index';

		return $aBody;
	}

	public function enqueueScripts()
	{
		if (!is_singular()) {
			return false;
		}

		$aInstaSettings = Option::getInstaSettingsByPostId(get_the_ID());
		$aWidgetIDs = Widget::getWidgetIDsByBaseID();
		foreach ($aWidgetIDs as $key => $widgetID) {
			if(!empty(Option::getInstaSettingsByWidgetId($widgetID))){
				$aInstaSettings[] = Option::getInstaSettingsByWidgetId($widgetID);
			}
		}
		if (empty($aInstaSettings)) {
			return false;
		}

		wp_enqueue_style(
			'instafeedhub',
			'https://insta-layout.netlify.app/styles.css',
			[],
			IFH_VERSION
		);

		wp_enqueue_script(
			'instafeedhub',
			'https://insta-layout.netlify.app/main.js',
			['jquery'],
			IFH_VERSION,
			true
		);

		wp_localize_script(
			'instafeedhub',
			'__wilInstagramShopify__',
			array_values($aInstaSettings)
		);
	}
}
