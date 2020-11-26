<?php

namespace InstafeedHub\Elementor;

/**
 * Class InstaFeedhubElementorHandler
 * @package InstafeedHub\Elementor
 */
class InstaFeedhubElementorHandler
{
	public function __construct()
	{
		add_action('elementor/editor/before_enqueue_scripts', [$this, 'enqueueScripts']);
	}

	public function enqueueScripts()
	{
		if (isset($_GET['action']) && $_GET['action'] == 'elementor') {
			wp_enqueue_script(
				'handle-elementor',
				IFH_ASSETS . 'js/handle-elementor.js',
				[],
				IFH_VERSION,
				true
			);
		}
	}
}
