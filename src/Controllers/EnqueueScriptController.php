<?php


namespace InstafeedHub\Controllers;


use InstafeedHub\Helpers\Option;

class EnqueueScriptController {
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueueScripts' ] );
	}

	public function enqueueScripts() {
		if ( is_singular() ) {
			return false;
		}

		$aInstaSettings = Option::getInstaSettingsByPostId( get_the_ID());
		if ( empty( $aInstaSettings ) ) {
			return false;
		}

		wp_enqueue_style(
			'instafeedhub',
			'https://insta-layout.netlify.app/styles.css',
			[],
			IFH_VERSION
		);

		wp_enqueue_script(
			'instafeedhub',
			'https://insta-layout.netlify.app/main.js',
			[],
			IFH_VERSION,
			true
		);

		wp_localize_script(
			'instafeedhub',
			'__wilInstagramShopify__',
			[ $aInstaSettings ]
		);
	}
}
