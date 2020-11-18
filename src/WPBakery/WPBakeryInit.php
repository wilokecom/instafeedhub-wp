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
	 * WPBakeryInit constructor.
	 */
	public function __construct()
	{
		add_action('vc_before_init', array($this, 'register'));
		add_action('admin_enqueue_scripts', [$this, 'enqueueScripts']);
	}

	/**
	 * @throws \Exception
	 */
	public function register()
	{
		$this->aConfiguration = [
			[
				'name'     => esc_html__('InstaFeedhub', 'instafeedhub-wp'),
				'base'     => 'instagram-feedhub',
				'category' => esc_html__('', 'instafeedhub-wp'),
				'icon'     => 'dgt-show_text',
				"params"   => [
				]
			]
		];
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

	public function enqueueScripts()
	{
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

		wp_localize_script('jquery', 'instafeedHubElements', $this->getInstafeedHubElements());
	}

	public function getInstafeedHubElements()
	{
		
	}
}
