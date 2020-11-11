<?php

namespace InstafeedHub\Controllers\Widget;

/**
 * Class InstagramFeedController
 * @package InstafeedHub\Controllers\Widget
 */
class InstagramFeedController extends BaseWidget
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
	 * InstagramFeedController constructor.
	 */
	public function __construct()
	{
		parent::__construct(
			$this->baseID,
			esc_html__('Instagram Feed', 'wiloke-instafeedhub-wp')
		);
	}

	/**
	 * @param array $args
	 * @param array $aInstance
	 */
	public function widget($args, $aInstance)
	{
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
