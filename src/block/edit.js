import styled from 'styled-components';
import { useState, useEffect } from '@wordpress/element';
import { TextControl, PanelBody, Button, Icon, IconButton } from '@wordpress/components';
import { InspectorControls } from '@wordpress/editor';
import * as _ from 'lodash';
import { verifyToken, signin } from './actionVeryfiToken';
import MyModal from './MyModal/MyModal';
import { INSTA_IFAME_ID, INSTA_IFRAME_URL } from '../modules/contants';

export default function Edit({ setAttributes, isSelected, attributes, clientId }) {
  let timeOutRequest;

  // === ATTRBUTES === //
  const { instaTitle, instaId } = attributes;

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

  function handleReceiveFromIframe(event) {
    if (window.InstafeedHubClientIdActive !== clientId || !event.data.type) {
      return;
    }
    if (!event.data.type.includes('CREATE-ITEM') && !event.data.type.includes('UPDATE-ITEM')) return;
    console.log(777, '__handleRecevicePostMessage__', { recevicePostMessage: event.data, isSelected, clientId });
    if (event.data.payload.status.includes('success')) {
      setAttributes({
        instaId: event.data.payload.id,
        instaTitle: event.data.payload.title,
      });
      setTimeout(() => {
        handleCloseModal();
      }, 500);
    }
    return;
  }

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
    window.InstafeedHubClientIdActive = clientId;
    if (!isSelected) return;
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

  const renderIconSvg = () => {
    return (
      <svg enable-background="new 0 0 24 24" height="30" viewBox="0 0 24 24" width="30" xmlns="http://www.w3.org/2000/svg">
        <linearGradient
          id="SVGID_1_"
          gradientTransform="matrix(0 -1.982 -1.844 0 -132.522 -51.077)"
          gradientUnits="userSpaceOnUse"
          x1="-37.106"
          x2="-26.555"
          y1="-72.705"
          y2="-84.047"
        >
          <stop offset="0" stop-color="#fd5" />
          <stop offset=".5" stop-color="#ff543e" />
          <stop offset="1" stop-color="#c837ab" />
        </linearGradient>
        <path
          d="m1.5 1.633c-1.886 1.959-1.5 4.04-1.5 10.362 0 5.25-.916 10.513 3.878 11.752 1.497.385 14.761.385 16.256-.002 1.996-.515 3.62-2.134 3.842-4.957.031-.394.031-13.185-.001-13.587-.236-3.007-2.087-4.74-4.526-5.091-.559-.081-.671-.105-3.539-.11-10.173.005-12.403-.448-14.41 1.633z"
          fill="url(#SVGID_1_)"
        />
        <path
          d="m11.998 3.139c-3.631 0-7.079-.323-8.396 3.057-.544 1.396-.465 3.209-.465 5.805 0 2.278-.073 4.419.465 5.804 1.314 3.382 4.79 3.058 8.394 3.058 3.477 0 7.062.362 8.395-3.058.545-1.41.465-3.196.465-5.804 0-3.462.191-5.697-1.488-7.375-1.7-1.7-3.999-1.487-7.374-1.487zm-.794 1.597c7.574-.012 8.538-.854 8.006 10.843-.189 4.137-3.339 3.683-7.211 3.683-7.06 0-7.263-.202-7.263-7.265 0-7.145.56-7.257 6.468-7.263zm5.524 1.471c-.587 0-1.063.476-1.063 1.063s.476 1.063 1.063 1.063 1.063-.476 1.063-1.063-.476-1.063-1.063-1.063zm-4.73 1.243c-2.513 0-4.55 2.038-4.55 4.551s2.037 4.55 4.55 4.55 4.549-2.037 4.549-4.55-2.036-4.551-4.549-4.551zm0 1.597c3.905 0 3.91 5.908 0 5.908-3.904 0-3.91-5.908 0-5.908z"
          fill="#fff"
        />
      </svg>
    );
  };

  const iconName = instaId ? 'edit' : 'welcome-add-page';
  return (
    <div className="wilIntaFeedCp">
      <div>{renderIconSvg()}</div>
      <Button isPrimary onClick={handleClickBtnConnect} className="wilIntaFeedCp__btnEdit" icon={<Icon icon={iconName} />}>
        {verifyError}
        {!instaId ? 'Connect and Create new a InstaFeed' : `${instaTitle} (${instaId})`}
      </Button>
      {isOpenModal && renderModal()}
    </div>
  );
}
