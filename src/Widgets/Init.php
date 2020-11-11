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
		add_action('widgets_init', [$this, 'init']);
	}

	public function init()
	{
		register_widget('InstafeedHub\Widgets\InstagramFeed');
	}
}
