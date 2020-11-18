<?php

namespace InstafeedHub\Elementors;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

/**
 * Class InstagramFeedhub
 * @package InstafeedHub\Elementor
 */
class InstagramFeedhub extends Widget_Base
{
	/**
	 * @return string
	 */
	public function get_name()
	{
		return 'instagram-feedhub';
	}

	/**
	 * @return string|void
	 */
	public function get_title()
	{
		return __('Instagram FeedHub', 'instafeedhub-wp');
	}

	/**
	 * @return string
	 */
	public function get_icon()
	{
		return 'eicon-posts-ticker';
	}

	/**
	 * @return array
	 */
	public function get_categories()
	{
		return ['instagram-feedhub'];
	}

	/**
	 * _register_controls
	 */
	protected function _register_controls()
	{
	}

	/**
	 * render
	 */
	protected function render()
	{
//		$aSettings = $this->get_settings_for_display();
		?>
        <div id="<?php echo $this->get_name() . '-' .
			$this->get_id(); ?>"><?php echo __('InstafeedHub', 'instafeedhub-wp') ?></div>
		<?php
	}
}
