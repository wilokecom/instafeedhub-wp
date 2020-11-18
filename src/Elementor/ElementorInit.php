<?php

namespace InstafeedHub\Elementors;

/**
 * Class ElementorInit
 * @package InstafeedHub\Elementor
 */
class ElementorInit
{
	private static $_instance = null;

	/**
	 * ElementorInit constructor.
	 */
	public function __construct()
	{
		add_action('elementor/widgets/widgets_registered', [$this, 'registerWidgets']);
		add_action('elementor/elements/categories_registered', [$this, 'initCategories']);
	}

	/**
	 * @return ElementorInit|null
	 */
	public static function instance()
	{
		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * @param $file
	 * @return mixed
	 */
	protected function parseFile($file)
	{
		$aParsed = explode('/', $file);
		$file = end($aParsed);

		return $file;
	}

	/**
	 * registerWidgets
	 */
	public function registerWidgets()
	{
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new InstagramFeedhub());
	}

	/**
	 * @param $oElementsManager
	 */
	function initCategories($oElementsManager)
	{
		$oElementsManager->add_category(
			'instagram-feedhub',
			array(
				'title' => __('Instagram FeedHub', 'instafeedhub-wp'),
				'icon'  => 'fa fa-plug',
			)
		);
	}
}
