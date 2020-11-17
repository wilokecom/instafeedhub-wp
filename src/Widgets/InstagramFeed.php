<?php

namespace InstafeedHub\Widgets;

use InstafeedHub\Helpers\Widget;
/**
 * Class InstagramFeed
 * @package InstafeedHub\Widgets
 */
class InstagramFeed extends RootWidget
{
	/**
	 * @var string
	 */
	private $baseID = 'instagram-feedhub';

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
		$widgetID = $args['widget_id'];
		$instaID = Widget::getInstaIDByWidgetID($widgetID);
		?>
        <div class="wil-instagram-shopify" data-id="<?php echo esc_html($instaID); ?>"></div>
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
