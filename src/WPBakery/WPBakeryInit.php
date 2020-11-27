<?php

namespace InstafeedHub\WPBakery;

/**
 * Class WPBakeryInit
 * @package InstafeedHub\WPBakery
 */
class WPBakeryInit
{
	/**
	 * @var
	 */
	private $aConfiguration;

	/**
	 * @var string
	 */
	private $shortCode = 'vc-instagram-feedhub';

	/**
	 * WPBakeryInit constructor.
	 */
	public function __construct()
	{
		add_action('vc_before_init', array($this, 'register'));
		add_action('admin_enqueue_scripts', [$this, 'enqueueScripts']);
	}

	/**
	 * @return mixed
	 */
	public function getConfiguration()
	{
		if (!empty($this->aConfiguration)) {
			return $this->aConfiguration;
		}
		$this->aConfiguration[] = [
			'name'   => esc_html__('InstaFeedhub', 'instafeedhub-wp'),
			'base'   => $this->shortCode,
			'icon'   => '',
			'params' => [
				[
					'type'       => 'textfield',
					'heading'    => __('Instagram ID', 'instafeedhub-wp'),
					'param_name' => 'vc-instagram-feedhub-input',
				],
			],
		];

		return $this->aConfiguration;
	}

	/**
	 * @throws \Exception
	 */
	public function register()
	{
		$this->getConfiguration();

		foreach ($this->aConfiguration as $sc) {
			vc_map($sc);
			$this->addShortCode($sc);
		}
	}

	/**
	 * @param $aParams
	 */
	public function addShortCode($aParams)
	{
		$path = IFH_DIR . 'src/WPBakery/templates/';
		$fileDir = $path . $aParams['base'] . '.php';

		if (is_file($fileDir)) {
			include $fileDir;
		}
	}

	/**
	 * @return bool
	 */
	public function enqueueScripts()
	{
		if (!current_user_can('edit_posts')) {
			return false;
		}

		if (!isset($_GET['post_type']) && !isset($_GET['post'])) {
			return false;
		}

		wp_enqueue_script(
			'handle-wp-bakery',
			IFH_ASSETS . 'js/handle-wp-bakery.js',
			[],
			IFH_VERSION,
			true
		);
		// ===
		wp_enqueue_script(
			'handle-wp-bakeryFokedJs',
			IFH_ASSETS . 'forBakery/foked.js',
			[],
			IFH_VERSION,
			true
		);
		wp_enqueue_style(
			'handle-wp-bakeryFokedCss',
			IFH_ASSETS . 'forBakery/foked.css',
			[],
			IFH_VERSION,
			'all'
		);
	}
}
