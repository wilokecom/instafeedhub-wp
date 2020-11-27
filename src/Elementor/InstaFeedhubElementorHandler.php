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
		add_action('elementor/editor/after_enqueue_scripts', [$this, 'enqueueScripts']); 
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
 
			// === EDEN TUAN JS === //
			wp_enqueue_script(
				'instafeedhubElementor-fokedJs',
				IFH_ASSETS . 'forElementor/foked.js',
				[],
				IFH_VERSION,
				true
			);
			wp_enqueue_style(
				'instafeedhubElementor-fokedCss',
				IFH_ASSETS . 'forElementor/foked.css',
				[],
				IFH_VERSION,
				'all'
			);
		}
	}
}