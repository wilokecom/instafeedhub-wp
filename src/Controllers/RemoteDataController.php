<?php

namespace WilokeInstaFeedHub\Controllers;

use WilokeInstaFeedHub\Helpers\Message;
use WilokeInstaFeedHub\Helpers\Option;

/**
 * Class RemoteDataController
 * @package WilokeInstaFeedHub\Controllers
 */
class RemoteDataController
{
	/**
	 * RemoteDataController constructor.
	 */
	public function __construct()
	{
		add_action('rest_api_init', [$this, 'registerRouter']);
	}

	public function registerRouter()
	{
		register_rest_route(WILOKE_IFH_NAMESPACE, '/remote-data',
			[
				'methods'             => 'POST',
				'callback'            => [$this, 'sendData'],
				'permission_callback' => '__return_true'
			],
			[
				'methods'             => 'DELETE',
				'callback'            => [$this, 'deleteData'],
				'permission_callback' => '__return_true'
			]
		);
	}

	/**
	 * @param \WP_REST_Request $oRequest
	 * @return array|\WP_REST_Response
	 */
	public function postData(\WP_REST_Request $oRequest)
	{
		$aParams = $oRequest->get_params();
		if (empty($aParams)) {
			return Message::error(__('There is no data', 'wiloke-instafeedhub'), 400);
		}

		$aData = Option::get('__wilInstagramShopify__');
		if (empty($aParams)) {
			Option::update('__wilInstagramShopify__', $aParams);
		} else {
			$aData[] = $aParams;
			update_option('__wilInstagramShopify__', $aData);
		}

		return Message::success(__('This post has been update successfully'));
	}

	/**
	 * @param \WP_REST_Request $oRequest
	 * @return array|\WP_REST_Response
	 */
	public function deleteData(\WP_REST_Request $oRequest)
	{
		$aParams = $oRequest->get_params();
		if (empty($aParams)) {
			return Message::error(__('There is no data', 'wiloke-instafeedhub'), 400);
		}

		$postID = $aParams['postID'];
		$aData = get_option('__wilInstagramShopify__');
		if (empty($aData)) {
			return Message::error(__('This post has been deleted or it does not exist', 'wiloke-instafeedhub'), 400);
		}
		$result = false;
		foreach ($aData as $key => $item) {
			if ($item['postID'] == $postID) {
				unset($aData[$key]);
				update_option('__wilInstagramShopify__', $aData);
				$result = true;
				break;
			}
		}

		if ($result == false) {
			return Message::error(__('This post has been deleted or it does not exist', 'wiloke-instafeedhub'), 400);
		}

		return Message::success('This post has been deleted successfully');
	}
}