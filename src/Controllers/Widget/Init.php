<?php

namespace InstafeedHub\Controllers\Widget;

/**
 * Class Init
 * @package InstafeedHub\Controllers\Widget
 */
class Init
{
	public function __construct()
	{
		add_action('widgets_init', [$this, 'init']);
	}

	public function init()
	{
		register_widget('InstafeedHub\Controllers\Widget\InstagramFeedController');
	}
}
