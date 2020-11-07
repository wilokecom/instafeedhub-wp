<?php

namespace InstafeedHub\Helpers;

use WilokeListingTools\Framework\Helpers\DebugStatus;
use WilokeListingTools\Framework\Helpers\Validation;

class Session {
	protected static $isSessionStarted = false;
	protected static $expiration       = 900;

	protected static function generatePrefix( $name ) {
		return str_replace( '_', '-', 'instafeedhub_' . $name );
	}

	public static function sessionStart( $sessionID = null ) {
		global $pagenow;
		if ( $pagenow == 'site-health.php' ||
		     ( is_admin() && isset( $_GET['page'] ) && $_GET['page'] == 'site-health' ) ) {
			session_id( $sessionID );
		}

		if ( ! headers_sent() && ( session_status() == PHP_SESSION_NONE || session_status() === 1 ) ) {
			session_start();
		}
	}

	public static function setSession( $name, $value, $sessionID = null ) {
		$value = maybe_serialize( $value );
		if ( empty( session_id() ) ) {
			self::sessionStart( $sessionID );
		}
		$_SESSION[ self::generatePrefix( $name ) ] = $value;

		return $value;
	}

	public static function getSession( $name, $thenDestroy = false ) {
		self::sessionStart( self::generatePrefix( $name ) );
		$value = isset( $_SESSION[ self::generatePrefix( $name ) ] ) ? $_SESSION[ self::generatePrefix( $name ) ] :
			'';

		if ( empty( $value ) ) {
			return false;
		}

		if ( $thenDestroy ) {
			self::destroySession( $name );
		}

		return maybe_unserialize( $value );
	}

	public static function destroySession( $name = null ) {
		self::sessionStart();
		if ( ! empty( self::generatePrefix( $name ) ) ) {
			unset( $_SESSION[ self::generatePrefix( $name ) ] );
		} else {
			session_destroy();
		}
	}
}
