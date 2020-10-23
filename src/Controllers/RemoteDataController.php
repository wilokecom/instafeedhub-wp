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
		$aParams = $oRequest->get_params();
		if (empty($aParams)) {
			return Message::error(__('There is no data', 'wiloke-instafeedhub'), 400);
		}
		$postID = $aParams['id'];
		$aData = Option::get($this->optionKey);
		if (empty($aData)) {
			Option::update($this->optionKey, [$aParams]);
		} else {
			$result = false;
			foreach ($aData as $key => $item) {
				if ($item['id'] == $postID) {
					$aData[$key] = $aParams;
					Option::update($this->optionKey, $aData);
					$result = true;
					break;
				}
			}
			if ($result == false) {
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
		$postID = $oRequest->get_param('id');

		if (empty($postID)) {
			return Message::error(__('The post id is required', 'wiloke-instafeedhub'), 400);
		}
		$aData = Option::get($this->optionKey);

		if (empty($aData)) {
			return Message::error(__('This post has been deleted or it does not exist', 'wiloke-instafeedhub'), 400);
		} else {
			$result = false;
			foreach ($aData as $key => $item) {
				if ($item['id'] == $postID) {
					unset($aData[$key]);
					$aData = array_values($aData);
					Option::update($this->optionKey, $aData);
					$result = true;
					break;
				}
			}
		}

		if ($result == false) {
			return Message::error(__('This post has been deleted or it does not exist', 'wiloke-instafeedhub'), 400);
		}

		return Message::success('This post has been deleted successfully');
	}

	public function enqueueScripts()
	{
		wp_localize_script('jquery', '__wilInstagramShopify__', Option::get($this->optionKey));
	}
}