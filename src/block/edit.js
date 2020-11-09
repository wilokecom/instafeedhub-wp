import styled from 'styled-components';
import { useEffect, useState } from 'react';
import { TextControl, PanelBody, Button, Icon, IconButton } from '@wordpress/components';
import { InspectorControls } from '@wordpress/editor';
import * as _ from 'lodash';
import { verifyToken, signin } from './actionVeryfiToken';
import MyModal from './MyModal/MyModal';
import { INSTA_IFAME_ID, INSTA_IFRAME_URL } from '../modules/contants';

export default function Edit({ setAttributes, isSelected, attributes, clientId }) {
  let timeOutRequest;

  // === ATTRBUTES === //
  const { instaId, instaTitle } = attributes;

  const instaFeedData = window.InstafeedHubTokens;
  // === USESTATE === //
  const [isVerify, setIsVerify] = useState(false);
  const [verifyError, setVerifyError] = useState('');
  const [isOpenModal, setOpenModal] = useState(false);
  const [isPostMessageDone, setPostMessageDone] = useState(false);

  // === HANDLE === //
  const handleOpenModal = () => setOpenModal(true);
  const handleCloseModal = () => {
    setOpenModal(false);
    setPostMessageDone(false);
  };

  const verifyTokenAndLogin = async () => {
    if (!instaFeedData || _.isEmpty(instaFeedData)) {
      return setVerifyError('Oop! InstafeedHubTokens could not Empty.');
    }
    setIsVerify(true);

    const { accessToken } = instaFeedData;
    if (!accessToken) {
      const msg = await signin(instaFeedData);
      if (typeof msg === 'string') {
        msg && setVerifyError(msg);
      }
      if (typeof msg === 'object') {
        //  === update lai bien window de nhung component khac su dung luon === //
        window.InstafeedHubTokens = { ...window.InstafeedHubTokens, ...msg };
      }
    }

    setIsVerify(false);
    return;
  };

  const handlePostMessage = () => {
    const iframeWeb = document.getElementById(INSTA_IFAME_ID);
    if (!iframeWeb) return;
    const wn = iframeWeb.contentWindow;
    let payloadData = instaFeedData;
    if (!!instaId) {
      payloadData = {
        ...instaFeedData,
        args: {
          id: instaId,
        },
      };
    }

    wn.postMessage({ type: 'LOGIN', payload: payloadData }, INSTA_IFRAME_URL);
    console.log(666, '__HandlePostMessage__', { dataSendPostMessageToIframe: payloadData });
    setPostMessageDone(true);
  };

  const onIframeLoaded = () => {
    if (isPostMessageDone) return;
    handlePostMessage();
  };

  const handleReceiveFromIframe = async event => {
    if (!isSelected || event.data.type !== 'CREATE-ITEM') {
      return;
    }
    console.log(777, '__handleRecevicePostMessage__', { recevicePostMessage: event.data });

    setAttributes({
      instaId: event.data.payload.id,
      instaTitle: event.data.payload.title,
    });

    setTimeout(() => {
      handleCloseModal();
    }, 500);
    return;
  };

  // === USER EFFECT === //
  useEffect(() => {
    //
    window.addEventListener('message', handleReceiveFromIframe);
    return () => {
      window.removeEventListener('message', handleReceiveFromIframe);
    };
  }, []);

  // === HANDLE === //
  const handleClickBtnConnect = () => {
    handleOpenModal();
    verifyTokenAndLogin();
  };

  const renderLoading = () => {
    if (!isVerify) return null;
    return (
      <p className="wilBlogLoading">
        <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false">
          <path
            fill-rule="evenodd"
            d="M10.289 4.836A1 1 0 0111.275 4h1.306a1 1 0 01.987.836l.244 1.466c.787.26 1.503.679 2.108 1.218l1.393-.522a1 1 0 011.216.437l.653 1.13a1 1 0 01-.23 1.273l-1.148.944a6.025 6.025 0 010 2.435l1.149.946a1 1 0 01.23 1.272l-.653 1.13a1 1 0 01-1.216.437l-1.394-.522c-.605.54-1.32.958-2.108 1.218l-.244 1.466a1 1 0 01-.987.836h-1.306a1 1 0 01-.986-.836l-.244-1.466a5.995 5.995 0 01-2.108-1.218l-1.394.522a1 1 0 01-1.217-.436l-.653-1.131a1 1 0 01.23-1.272l1.149-.946a6.026 6.026 0 010-2.435l-1.148-.944a1 1 0 01-.23-1.272l.653-1.131a1 1 0 011.217-.437l1.393.522a5.994 5.994 0 012.108-1.218l.244-1.466zM14.929 12a3 3 0 11-6 0 3 3 0 016 0z"
            clip-rule="evenodd"
          ></path>
        </svg>
        Loading...
      </p>
    );
  };

  const renderError = () => {
    if (!verifyError) return null;
    return <p className="wilBlogError">{verifyError}</p>;
  };

  const renderModal = () => {
    return (
      <MyModal onCloseModal={handleCloseModal}>
        {isVerify ? (
          renderLoading()
        ) : !!verifyError ? (
          renderError()
        ) : (
          <iframe onLoad={onIframeLoaded} id={INSTA_IFAME_ID} src={INSTA_IFRAME_URL} frameBorder="0" />
        )}
      </MyModal>
    );
  };

  const iconName = instaId ? 'edit' : 'welcome-add-page';
  return (
    <div className="wilIntaFeedCp">
      <Button isPrimary onClick={handleClickBtnConnect} className="wilIntaFeedCp__btnEdit" icon={<Icon icon={iconName} />}>
        {!instaId ? 'Connect and Create new a InstaFeed' : `${instaTitle} (${instaId})`}
      </Button>
      {isOpenModal && renderModal()}
    </div>
  );
}
