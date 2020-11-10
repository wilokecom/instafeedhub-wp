<?php


namespace InstafeedHub\Helpers;


class User {
	public static function getUserNickname() {
		$nickName = get_the_author_meta( 'nickname', get_current_user_id() );

		return empty( $nickName ) ? get_the_author_meta( 'user_login', get_current_user_id() ) : $nickName;
	}
}
