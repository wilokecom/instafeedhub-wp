<?php

namespace InstafeedHub\Widgets;

/**
 * Class InstagramFeed
 * @package InstafeedHub\Widgets
 */
class InstagramFeed extends RootWidget
{
	/**
	 * @var string
	 */
	private $baseID = 'instagram-feed';

	/**
	 * @var array
	 */
	protected $aFields
		= [
			'button' => [
				'name'        => 'Instagram Feed',
				'description' => 'Click here to select the instagram',
				'type'        => 'button'
			],
		];

	/**
	 * InstagramFeed constructor.
	 */
	public function __construct()
	{
		parent::__construct(
			$this->baseID,
			esc_html__('Instagram Feed', 'instafeedhub-wp')
		);
	}

	/**
	 * @param array $args
	 * @param array $aInstance
	 */
	public function widget($args, $aInstance)
	{
		$aInstaWidget = get_option('widget_instagram-feed');
		$widgetID = $_POST['widgetID'];
		$number = intval(end(explode('-', $widgetID)));
		$instaID = ($aInstaWidget[$number]['instaId'] == null) ? '' : $aInstaWidget[$number]['instaId'];
		?>
		<div class="wil-instagram-shopify" data-id=<?php echo esc_html($instaID); ?></div>;
		<?php
	}

	/**
	 * @param array $aNewInstance
	 * @param array $aOldInstance
	 * @return array|void
	 */
	public function update($aNewInstance, $aOldInstance)
	{
	}

	/**
	 * @param array $aInstance
	 * @return string|void
	 */
	public function form($aInstance)
	{
		$this->render($this->aFields, $aInstance);
	}
}
