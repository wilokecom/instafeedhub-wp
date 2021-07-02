import styled from 'styled-components';
import { useEffect, useState } from 'react';
import { TextControl, Autocomplete, PanelBody } from '@wordpress/components';
import { InspectorControls } from '@wordpress/editor';
import axios from 'axios';
import * as _ from 'lodash';
import MyAutocomplete from '../components/AutoComplete/AutoComplete';
import { verifyToken, signin } from './actionVeryfiToken';

export default function Edit( { setAttributes, isSelected, attributes } ) {
	//   === CONFIG AXIOS CANCEL ===	//
	const CancelToken = axios.CancelToken;
	let cancel;

	let timeOutRequest;

	// === ATTRBUTES === //
	const { options = [], value = '' } = attributes;

	const [ isVerify, setIsVerify ] = useState( false );
	const [ verifyError, setVerifyError ] = useState( '' );
	// === USESTATE === //

	const verifyTokenAndLogin = async() => {
		// window.InstafeedHubTokens = {
		//     accessToken?: string;
		//     refreshToken?: string;
		//     email: string;
		//     nickname: string;
		// origin: string;
		//     args: {
		//       id?: string;
		//     };
		//   };

		if ( ! window.InstafeedHubTokens ) {
			return setVerifyError( 'Oop! InstafeedHubTokens could not Empty.' );
		}

		const instafeedHubTokens = window.InstafeedHubTokens;
		const {
			accessToken, refreshToken, email, nickname, args, origin,
		} = instafeedHubTokens;

		setIsVerify( true );

		if ( !! accessToken ) {
			// === USER da~ login roi === //
			const msg = await verifyToken( instafeedHubTokens );
			msg && setVerifyError( msg );
		} else {
			const msg = await signin( origin, email, nickname, args );
			msg && setVerifyError( msg );
		}

		setIsVerify( false );
	};

	// === USE EFFECT === //
	useEffect( () => {
		verifyTokenAndLogin();
	}, [] );

	const actionAxiosFindUser = ( query ) => {
		const url = `https://shopifyinstagram.io:7890/wp-json/wiloke/v1/instagram/me/find-insta-user?q=${ query }`;
		if ( cancel ) {
			cancel();
		}
		axios
			.get( url, {
				responseType: 'json',
				cancelToken: new CancelToken( ( c ) => {
					cancel = c;
				} ),
			} )
			.then( ( { data } ) => {
				setAttributes( {
					options: data.items || [],
					// options: _.unionWith(data.items, options, _.isEqual),
				} );
			} )
			.catch( ( thrown ) => {
				if ( axios.isCancel( thrown ) ) {
					console.log( 'Request canceled', thrown.message );
				} else {
					console.log( 'ERROR', { thrown } );
				}
			} );
	};

	function findInstaUserId( val ) {
		timeOutRequest && clearTimeout( timeOutRequest );
		if ( !! val ) {
			timeOutRequest = setTimeout( () => {
				actionAxiosFindUser( val );
			}, 300 );
		}
	}

	function downloadInstaConfigured( { id } ) {
		const url = `https://shopifyinstagram.io:7890/wp-json/wiloke/v1/instagram/me/${ id }/global-configuration`;
		axios
			.get( url, {
				responseType: 'json',
			} )
			.then( console.log )
			.catch( console.error );
	}

	console.log( 44, { attributes } );

	if ( isVerify ) {
		return <p className="wilBlogLoading" >
			<svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><path fillRule="evenodd" d="M10.289 4.836A1 1 0 0111.275 4h1.306a1 1 0 01.987.836l.244 1.466c.787.26 1.503.679 2.108 1.218l1.393-.522a1 1 0 011.216.437l.653 1.13a1 1 0 01-.23 1.273l-1.148.944a6.025 6.025 0 010 2.435l1.149.946a1 1 0 01.23 1.272l-.653 1.13a1 1 0 01-1.216.437l-1.394-.522c-.605.54-1.32.958-2.108 1.218l-.244 1.466a1 1 0 01-.987.836h-1.306a1 1 0 01-.986-.836l-.244-1.466a5.995 5.995 0 01-2.108-1.218l-1.394.522a1 1 0 01-1.217-.436l-.653-1.131a1 1 0 01.23-1.272l1.149-.946a6.026 6.026 0 010-2.435l-1.148-.944a1 1 0 01-.23-1.272l.653-1.131a1 1 0 011.217-.437l1.393.522a5.994 5.994 0 012.108-1.218l.244-1.466zM14.929 12a3 3 0 11-6 0 3 3 0 016 0z" clipRule="evenodd"></path></svg>
			Loading...
		</p>;
	}
	if ( !! verifyError ) {
		return <p className="wilBlogError">{ verifyError }</p>;
	}

	return (
		<div>
			<MyAutocomplete
				label="Search your instagram"
				onChange={ findInstaUserId }
				onSelectItem={ ( item ) => {
					setAttributes( { value: item.label } );
					downloadInstaConfigured( item );
				} }
				options={ options }
				id="block-id"
				value={ value }
			/>
		</div>
	);
}
