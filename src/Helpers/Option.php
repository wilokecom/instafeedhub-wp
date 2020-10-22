<?php

namespace WilokeInstaFeedHub\Helpers;

/**
 * Class Option
 * @package WilokeInstaFeedHub\Helpers
 */
class Option
{
	/**
	 * @param $key
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
}
