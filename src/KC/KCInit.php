<?php

namespace InstafeedHub\KC;

/**
 * Class KCInit
 * @package InstafeedHub\KC
 */
class KCInit
{
	/**
	 * @var array
	 */
	private $aConfiguration;

	/**
	 * KCInit constructor.
	 */
	public function __construct()
	{
		add_action('init', [$this, 'registerShortcodes']);
	}

	public function registerShortcodes()
	{
		$this->getConfiguration();
		if (function_exists('kc_add_map')) {
			global $kc;
			foreach ($this->aConfiguration as $sc) {
				$kc->add_map($sc);
				$this->addShortCode($sc);
			}
		}
	}

	/**
	 * @return array
	 */
	public function getConfiguration()
	{
		if (!empty($this->aConfiguration)) {
			return $this->aConfiguration;
		}
		$this->aConfiguration = [
			[
				'kc_instafeedhub' => [
					'name'     => esc_html__('InstaFeedHub', 'wp-instafeedhub'),
					'nested'   => true,
					'icon'     => 'kc-icon-instagram',
					'css_box'  => true,
					'category' => 'Socials',
					'params'   => [
						'general' => [
							[
								'name'        => 'kc_instafeedhub_input',
								'label'       => esc_html__('InstaFeedHub', 'wp-instafeedhub'),
								'type'        => 'text',
								'admin_label' => false
							]
						]
					],
				]
			]
		];

		return $this->aConfiguration;
	}

	/**
	 * @param $aParams
	 */
	public function addShortCode($aParams)
	{
		$path = IFH_DIR . 'src/KC/templates/';
		foreach ($aParams as $sc => $param) {
			$fileDir = $path . $sc . '.php';
			if (is_file($fileDir)) {
				include $fileDir;
			}
		}
	}
}
