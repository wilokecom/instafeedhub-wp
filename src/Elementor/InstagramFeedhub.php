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
//	/**
//	 * InstagramFeedhub constructor.
//	 * @param array $data
//	 * @param null $args
//	 * @throws \Exception
//	 */
//	public function __construct($data = [], $args = null)
//	{
//		parent::__construct($data, $args);
//		wp_register_script(
//			'handle-elementor-class',
//			IFH_ASSETS . 'js/handle-elementor-class.js',
//			['jquery', 'elementor-frontend'],
//			IFH_VERSION,
//			true
//		);
//	}

	/**
	 * @return array
	 */
	public function get_script_depends()
	{
		return ['handle-elementor-class'];
	}

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
		// Adding Working Hours section under Content tab
//		$this->start_controls_section(
//			'content_section',
//			[
//				'label' => __('Working Hours', 'plugin-name'),
//				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
//			]
//		);
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'elementor-hello-world' ),
			]
		);

		$this->add_control(
			'instafeedhub_input',
			[
                'classes' => 'instafeedhub_input',
				'label' => __( 'Title', 'elementor-hello-world' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Title', 'elementor-hello-world' ),
			]
		);
		$this->end_controls_section();
//
//		// Creating a repeater control
//		$repeater = new \Elementor\Repeater();
//
//		// Add Day dropdown
//		$repeater->add_control(
//			'day',
//			[
//				'label'   => __('Day', 'plugin-name'),
//				'type'    => \Elementor\Controls_Manager::SELECT,
//				'options' => $this->get_days(),
//			]
//		);
//		// Adding Hours option
//		$options = array();
//
//		for ($i = 0; $i < 24; $i++) {
//			$hour = $i;
//
//			if ($hour < 10) {
//				$hour = '0' . $hour;
//			}
//			$options[$hour . ':00'] = $hour . ':00';
//		}
//
//		// Add Start Hour
//		$repeater->add_control(
//			'start',
//			[
//				'label'   => __('Start', 'plugin-name'),
//				'type'    => \Elementor\Controls_Manager::SELECT,
//				'options' => $options
//			]
//		);
//
//		// Add End hours
//		$repeater->add_control(
//			'end',
//			[
//				'label'   => __('End', 'plugin-name'),
//				'type'    => \Elementor\Controls_Manager::SELECT,
//				'options' => $options
//			]
//		);

		// Adding the repeater control with all its controls
//		$this->add_control(
//			'hours',
//			[
//				'label'       => __('Hours', 'plugin-domain'),
//				'type'        => \Elementor\Controls_Manager::REPEATER,
//				'fields'      => $repeater->get_controls(),
//				'default'     => [],
//				'title_field' => '{{{ day }}}',
//			]
//		);

		$this->end_controls_section();
	}

	/**
	 * render
	 */
	protected function render()
	{
//		$aSettings = $this->get_settings_for_display();
		?>
        <button class="instafeedhub-btn" id="<?php echo $this->get_name() . '-' .
			$this->get_id(); ?>"><?php echo __('InstafeedHub', 'instafeedhub-wp') ?></button>
		<?php
	}


	protected function _content_template() {
		?>
        <button id="{{{ view.cid}}}" class="instafeedhub-btn">Test</button>
		<?php
	}
}
