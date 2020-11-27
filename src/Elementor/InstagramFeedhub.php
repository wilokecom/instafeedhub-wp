<?php

namespace InstafeedHub\Elementor;

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
		return 'instafeedhub';
	}

	/**
	 * @return string|void
	 */
	public function get_title()
	{
		return esc_html__('Instagram FeedHub', 'instafeedhub-wp');
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
		return ['instafeedhub'];
	}

	/**
	 * _register_controls
	 */
	protected function _register_controls()
	{
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__('Content', 'instafeedhub-wp'),
			]
		);

		$this->add_control(
			'instafeedhub_input',
			[
				'classes' => 'instafeedhub_input',
				'label'   => esc_html__('Instagram ID', 'instafeedhub-wp'),
				'type'    => Controls_Manager::TEXT,
			]
		);
		$this->end_controls_section();
	}

	/**
	 * render
	 */
	protected function render()
	{
//		$aSettings = $this->get_settings_for_display();
		?>
        <div class="wil-instagram-shopify" data-id="">Test</div>
		<?php
	}
}
