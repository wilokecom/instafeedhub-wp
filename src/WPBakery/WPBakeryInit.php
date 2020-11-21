<?php


namespace InstafeedHub\WPBakery;

/**
 * Class WPBakeryInit
 * @package InstafeedHub\WPBakery
 */
class WPBakeryInit
{
	/**
	 * @var int
	 */
	public static $instaFeedId = 1;
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
//		add_action('admin_enqueue_scripts', [$this, 'enqueueScripts']);
	}

	/**
	 * @throws \Exception
	 */
	public function register()
	{
		$this->aConfiguration[] = [
			'name'   => esc_html__('InstaFeedhub', 'instafeedhub-wp'),
			'base'   => 'vc-instagram-feedhub',
			'icon'   => 'dgt-show_text',
			'params' => [
				[
					'type'       => 'textfield',
					'heading'    => __('Select InstaFeedHub', 'instafeedhub-wp'),
					'param_name' => 'vc-instagram-feedhub-' . self::$instaFeedId,
				],
			],
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

		wp_localize_script('jquery', 'instafeedHubElements', $this->getInstafeedHubElements());
	}

	/**
	 * @return array
	 */
	public function getInstafeedHubElements()
	{
		$content = get_the_content();
		if (!has_shortcode($content, $this->shortCode)) {
			return [];
		}

		ob_start();
		do_shortcode($content, true);
		$rawContent = ob_get_clean();
		$aElement = [];
		if (preg_match_all('/vc-instagram-feedhub-\S/', $rawContent, $aMatches)) {
			if (!empty($aMatches[0])) {
				foreach ($aMatches[0] as $widgetID) {
					$aElement[$widgetID] = [
						'widgetID' => $widgetID,
					];
				}
			}
		}

		return $aElement;
	}

//	/**
//	 * @param $postID
//	 * @param $post
//	 * @return bool
//	 */
//	public function saveInstaSetting($postID, $post)
//	{
//		if (!current_user_can('edit_posts')) {
//			return false;
//		}
//		var_export($post->post_content);
//		die;
//		if (preg_match_all('/"instaId":([\d]+)/', $post->post_content, $aMatches)) {
//			if (isset($aMatches[1])) {
//				update_post_meta($postId, 'instafeedhub_ids', $aMatches[1]);
//			}
//		}
//	}
}
