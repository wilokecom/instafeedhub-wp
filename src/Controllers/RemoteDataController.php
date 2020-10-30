<?php

namespace WilokeInstaFeedHub\Controllers;

use WilokeInstaFeedHub\Helpers\Option;
use WilokeInstaFeedHub\Helpers\Message;

/**
 * Class RemoteDataController
 * @package WilokeInstaFeedHub\Controllers
 */
class RemoteDataController
{
	/**
	 * @var string
	 */
	private $optionKey = 'wil_insta_shopify';

	/**
	 * RemoteDataController constructor.
	 */
	public function __construct()
	{
		add_action('rest_api_init', [$this, 'registerRouter']);
		add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
		add_action('admin_enqueue_scripts', [$this, 'enqueueScripts']);
	}

	public function registerRouter()
	{
		register_rest_route(WILOKE_IFH_NAMESPACE, '/remote-data',
			[
				[
					'methods'             => 'POST',
					'callback'            => [$this, 'updateData'],
					'permission_callback' => '__return_true'
				],
				[
					'methods'             => 'DELETE',
					'callback'            => [$this, 'deleteData'],
					'permission_callback' => '__return_true'
				]
			]
		);
	}

	/**
	 * @param \WP_REST_Request $oRequest
	 * @return array|\WP_REST_Response
	 */
	public function updateData(\WP_REST_Request $oRequest)
	{
		if ($this->verifyAcessToken() == false) {
			return Message::error(__('The access token is invalid', 'wiloke-instafeedhub-wp'), 400);
		}

		$aParams = $oRequest->get_params();
		if (empty($aParams)) {
			return Message::error(__('There is no data', 'wiloke-instafeedhub-wp'), 400);
		}

		$postID = $aParams['id'];
		$aData = Option::get($this->optionKey);
		if (empty($aData)) {
			Option::update($this->optionKey, [$aParams]);
		} else {
			$key = array_search($postID, array_column($aData, 'id'));
			if ($key !== false) {
				if ($aParams['status'] !== 'publish') {
					unset($aData[$key]);
					$aData = array_values($aData);
				} else {
					$aData[$key] = $aParams;
				}
				Option::update($this->optionKey, $aData);
			} else {
				if ($aParams['status'] !== 'publish') {
					return Message::error(__('This post status is not publish', 'wiloke-instafeedhub-wp'), 400);
				}
				$aData[] = $aParams;
				Option::update($this->optionKey, $aData);
			}
		}

		return Message::success(__('This post has been update successfully'));
	}

	/**
	 * @param \WP_REST_Request $oRequest
	 * @return array|\WP_REST_Response
	 */
	public function deleteData(\WP_REST_Request $oRequest)
	{
		if ($this->verifyAcessToken() == false) {
			return Message::error(__('The access token is invalid', 'wiloke-instafeedhub'), 400);
		}

		$postID = $oRequest->get_param('id');

		if (empty($postID)) {
			return Message::error(__('The post id is required', 'wiloke-instafeedhub-wp'), 400);
		}
		$aData = Option::get($this->optionKey);

		if (empty($aData)) {
			return Message::error(__('This post has been deleted or it does not exist', 'wiloke-instafeedhub-wp'), 400);
		} else {
			$key = array_search($postID, array_column($aData, 'id'));
			if ($key !== false) {
				unset($aData[$key]);
				$aData = array_values($aData);
				Option::update($this->optionKey, $aData);
			} else {
				return Message::error(__('This post has been deleted or it does not exist', 'wiloke-instafeedhub-wp'), 400);
			}
		}

		return Message::success('This post has been deleted successfully');
	}

	/**
	 * @return array|bool|string|\WP_REST_Response
	 */
	public function verifyAcessToken()
	{
		$accessToken = $_SERVER['HTTP_ACCESSTOKEN'];
		if (empty($accessToken)) {
			return false;
		}
		$endpoint = trim($_SERVER['HTTP_DOMAIN'], '/') . '/wp-json/wiloke/v1/instagram/jwt/verify-access-token';
		$response = wp_remote_request($endpoint, [
			'method' => 'POST',
			'body'   => [
				'accessToken' => $accessToken
			]
		]);

		$responseCode = wp_remote_retrieve_response_code($response);

		if ($responseCode !== 200) {
			return false;
		} else {
			return wp_remote_retrieve_body($response);
		}
	}

	public function enqueueScripts()
	{
		wp_localize_script('jquery', '__wilInstagramShopify__', Option::get($this->optionKey));
	}
}