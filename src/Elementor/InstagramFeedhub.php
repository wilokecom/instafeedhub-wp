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
		$aSettings = $this->get_settings_for_display();
		$dataId = $aSettings['instafeedhub_input'];
		if (!empty($dataId)):
			?>
            <div class="wil-instagram-shopify" data-id="<?php echo esc_attr($dataId); ?>">
                <div  style="padding: 10px; background: #4CAF50; color: white;text-align: center; border-radius: 4px; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                    <svg enable-background="new 0 0 24 24" height="30" viewBox="0 0 24 24" width="30"
                         xmlns="http://www.w3.org/2000/svg">
                        <linearGradient id="SVGID_1_" gradientTransform="matrix(0 -1.982 -1.844 0 -132.522 -51.077)"
                                        gradientUnits="userSpaceOnUse" x1="-37.106" x2="-26.555" y1="-72.705" y2="-84.047">
                            <stop offset="0" stop-color="#fd5"/>
                            <stop offset=".5" stop-color="#ff543e"/>
                            <stop offset="1" stop-color="#c837ab"/>
                        </linearGradient>
                        <path
                                d="m1.5 1.633c-1.886 1.959-1.5 4.04-1.5 10.362 0 5.25-.916 10.513 3.878 11.752 1.497.385 14.761.385 16.256-.002 1.996-.515 3.62-2.134 3.842-4.957.031-.394.031-13.185-.001-13.587-.236-3.007-2.087-4.74-4.526-5.091-.559-.081-.671-.105-3.539-.11-10.173.005-12.403-.448-14.41 1.633z"
                                fill="url(#SVGID_1_)"/>
                        <path
                                d="m11.998 3.139c-3.631 0-7.079-.323-8.396 3.057-.544 1.396-.465 3.209-.465 5.805 0 2.278-.073 4.419.465 5.804 1.314 3.382 4.79 3.058 8.394 3.058 3.477 0 7.062.362 8.395-3.058.545-1.41.465-3.196.465-5.804 0-3.462.191-5.697-1.488-7.375-1.7-1.7-3.999-1.487-7.374-1.487zm-.794 1.597c7.574-.012 8.538-.854 8.006 10.843-.189 4.137-3.339 3.683-7.211 3.683-7.06 0-7.263-.202-7.263-7.265 0-7.145.56-7.257 6.468-7.263zm5.524 1.471c-.587 0-1.063.476-1.063 1.063s.476 1.063 1.063 1.063 1.063-.476 1.063-1.063-.476-1.063-1.063-1.063zm-4.73 1.243c-2.513 0-4.55 2.038-4.55 4.551s2.037 4.55 4.55 4.55 4.549-2.037 4.549-4.55-2.036-4.551-4.549-4.551zm0 1.597c3.905 0 3.91 5.908 0 5.908-3.904 0-3.91-5.908 0-5.908z"
                                fill="#fff"/>
                    </svg>
                    <span style="margin-left: 10px;"><?php echo esc_html__(sprintf('InstagramID:%s', $dataId), 'instafeedhub-wp'); ?></span>
                </div>
            </div>
		<?php
		endif;
	}
}