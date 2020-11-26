<?php

namespace InstafeedHub\Helpers;

/**
 * Class Option
 * @package InstafeedHub\Helpers
 */
class Option
{
	private static $optionKey = 'wil_insta_shopify';
	private static $tokenKey  = 'instafeedhub_tokens';

	/**
	 * @param $key
	 *
	 * @return mixed|void
	 */
	public static function get($key)
	{
		return get_option($key);
	}

	/**
	 * @param $key
	 * @param $value
	 */
	public static function update($key, $value)
	{
		update_option($key, $value);
	}

	/**
	 * @param $aTokens ['accessToken' => '', 'refreshToken' => '']
	 */
	public static function saveTokens($aTokens)
	{
		update_option(self::$tokenKey, $aTokens);

		return $aTokens;
	}

	public static function getTokens()
	{
		$aTokens = get_option(self::$tokenKey);
		if (empty($aTokens)) {
			return ['accessToken' => '', 'refreshToken' => ''];
		}

		return $aTokens;
	}

	public static function updateInstaSettings($aData)
	{
		self::update(self::$optionKey, $aData);

		return $aData;
	}

	public static function getInstaSettings()
	{
		$aData = self::get(self::$optionKey);

		return empty($aData) || !is_array($aData) ? [] : $aData;
	}

	public static function getInstaSettingsByPostId($postId)
	{
		$aInstaIds = get_post_meta(get_the_ID(), 'instafeedhub_ids', true);
		if (empty($aInstaIds)) {
			return apply_filters(
				'instafeedhub/filter/src/Helpers/Option/getInstaSettingsByPostId/my-insta-settings',
				[]
			);
		}

		$aData = self::getInstaSettings();

		if (empty($aData)) {
			return apply_filters(
				'instafeedhub/filter/src/Helpers/Option/getInstaSettingsByPostId/my-insta-settings',
				[]
			);
		}

		$aInstaSettings = [];
		foreach ($aInstaIds as $instaId) {
			if (isset($aData[$instaId])) {
				foreach ($aData[$instaId] as $key => $val) {
					$aInstaSettings[$postId][$key] = InstaSettingValueFormat::correctValueType($val, $key);
				}
			}
		}

		return apply_filters(
			'instafeedhub/filter/src/Helpers/Option/getInstaSettingsByPostId/my-insta-settings',
			$aInstaSettings
		);
	}

	/**
	 * @param $widgetID
	 * @return bool|mixed
	 */
	public static function getInstaSettingsByWidgetID($widgetID)
	{
		$aInstaWidget = get_option('widget-insta-feedhub');
		$element = explode('-', $widgetID);
		$index = intval(end($element));
		$instaID = '';
		if (isset($aInstaWidget[$index])) {
			if ($aInstaWidget[$index]['instaId'] !== null) {
				$instaID = intval($aInstaWidget[$index]['instaId']);
			}
		}
//
		$aData = self::getInstaSettings();
		$aInstaSettings = [];
		if (isset($aData[$instaID])) {
			foreach ($aData[$instaID] as $key => $val) {
				$aInstaSettings[$widgetID][$key] = InstaSettingValueFormat::correctValueType($val, $key);
			}
		}

		if (!isset($aInstaSettings[$widgetID])) {
			return false;
		}

		return $aInstaSettings[$widgetID];
	}
}
