<?php


namespace InstafeedHub\Controllers;

class AdminController {
	public function __construct() {
		add_action( 'save_post', [ $this, 'saveInstaIds' ], 10, 2 );
	}

	public function saveInstaIds( $postId, $post ) {
		if ( ! current_user_can( 'edit_posts' ) ) {
			return false;
		}

		if ( preg_match_all( '/"instaId":([\d]+)/', $post->post_content, $aMatches ) ) {
			if ( isset( $aMatches[1] ) ) {
				update_post_meta( $postId, 'instafeedhub_ids', $aMatches[1] );
			}
		}
	}
}
