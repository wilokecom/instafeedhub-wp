<?php

namespace InstafeedHub\Controllers;

use InstafeedHub\Helpers\Option;
use InstafeedHub\Helpers\Message;

/**
 * Class RemoteDataController
 * @package InstaFeedHub\Controllers
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
	}

	public function registerRouter()
	{
		register_rest_route(IFH_NAMESPACE, '/remote-data',
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
	 *
	 * @return array|\WP_REST_Response
	 */
	public function updateData(\WP_REST_Request $oRequest)
	{
		if ($this->verifyAccessToken() == false) {
			return Message::error(__('The access token is invalid', 'instafeedhub-wp'), 400);
		}

		$aParams = $oRequest->get_params();
		if (empty($aParams)) {
			return Message::error(__('There is no data', 'instafeedhub-wp'), 400);
		}

		$postID = $aParams['id'];
		$aData = Option::getInstaSettings();

		if (empty($aData)) {
			Option::updateInstaSettings([$postID => $aParams]);
		} else {
			if (isset($aData[$postID])) {
				if ($aParams['status'] !== 'publish') {
					unset($aData[$postID]);
				} else {
					foreach ($aParams as $pKey => $pVal) {
						if (is_numeric($pKey)) {
							$aParams[$pKey] = floatval($pVal);
						}
					}
					$aData[$postID] = $aParams;
				}

				Option::updateInstaSettings($aData);
			} else {
				if ($aParams['status'] !== 'publish') {
					return Message::error(__('This post status is not publish', 'instafeedhub-wp'), 400);
				}
				$aData[$postID] = $aParams;
				Option::updateInstaSettings($aData);
			}
		}

		return Message::success(__('This post has been update successfully'));
	}

	/**
	 * @param \WP_REST_Request $oRequest
	 *
	 * @return array|\WP_REST_Response
	 */
	public function deleteData(\WP_REST_Request $oRequest)
	{
		if ($this->verifyAccessToken() == false) {
			return Message::error(__('The access token is invalid', 'instafeedhub-wp'), 400);
		}

		$postID = $oRequest->get_param('id');

		if (empty($postID)) {
			return Message::error(__('The post id is required', 'instafeedhub-wp'), 400);
		}
		$aData = Option::getInstaSettings();

		if (empty($aData)) {
			return Message::error(__('This post has been deleted or it does not exist', 'instafeedhub-wp'),
				400);
		} else {
			if (is_array($aData) && isset($aData[$postID])) {
				unset($aData[$postID]);
				Option::updateInstaSettings($aData);
			} else {
				return Message::error(__('This post has been deleted or it does not exist', 'instafeedhub-wp'),
					400);
			}
		}

		return Message::success('This post has been deleted successfully');
	}

	/**
	 * @return array|bool|string|\WP_REST_Response
	 */
	public function verifyAccessToken()
	{
		return trim($_SERVER['HTTP_DOMAIN'], '/') === trim(IFH_URL, '/');
	}
}
