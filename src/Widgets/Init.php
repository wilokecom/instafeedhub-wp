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
		add_action('delete_widget', [$this, 'deleteWidgetFromArea']);
		add_action('widgets.php', [$this, 'addWidgetToArea']);
//		global $wp_registered_widgets, $wp_registered_widget_controls, $wp_registered_widget_updates;
//		echo "<pre>";
//		print_r($wp_registered_widget_updates);
//		echo "</pre>";
//		die;
	}

	public function init()
	{
		register_widget('InstafeedHub\Widgets\InstagramFeed');
	}

	public function deleteWidgetFromArea()
	{

	}

	public function addWidgetToArea()
	{?>
        <script>console.log('aaaaa');</script>
		<?php
	}
}
