/**
 * BLOCK: wiloke-instafeedhub
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */

//  Import CSS.
import './editor.scss';
import './style.scss';
import ContentEditable from 'react-contenteditable';
import styled from 'styled-components';
import {
	TextControl,Autocomplete,PanelBody
} from "@wordpress/components";
import MyAutocomplete from '../simple-autocomplete.js'; // adjust if you saved this file somewhere else.
import {InspectorControls} from '@wordpress/editor';
// import Autocomplete from 'react-autocomplete';
import axios from 'axios';

const {__} = wp.i18n; // Import __() from wp.i18n
const {registerBlockType} = wp.blocks; // Import registerBlockType() from wp.blocks
const labelText = 'NAME (Accessible Text Input)';

/**
 * Register: aa Gutenberg Block.
 *
 * Registers a new block provided a unique name and an object defining its
 * behavior. Once registered, the block is made editor as an option to any
 * editor interface where blocks are implemented.
 *
 * @link https://wordpress.org/gutenberg/handbook/block-api/
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */
registerBlockType('cgb/block-wiloke-instafeedhub', {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __('wiloke-instafeedhub - CGB Block'), // Block title.
	icon: 'shield', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	keywords: [
		__('wiloke-instafeedhub — CGB Block'),
		__('CGB Example'),
		__('create-guten-block'),
	],

	/**
	 * The edit function describes the structure of your block in the context of the editor.
	 * This represents what the editor will render when the block is used.
	 *
	 * The "edit" property must be a valid function.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
	 *
	 * @param {Object} props Props.
	 * @returns {Mixed} JSX Component.
	 */
	edit: function ({setAttributes, isSelected, attributes}) {
		// Creates a <p class='wp-block-cgb-block-wiloke-instafeedhub'></p>.
		let options = [{name: '--', id: ''}];

		function findInstaUserId(val) {
			if (!!val) {
				const CancelToken = axios.CancelToken;
				jQuery.ajax({
					type: 'GET',
					url: `https://instafeedhub.com/wp-json/wiloke/v1/instagram/me/find-insta-user?q=${val}`,
					dataType: 'json',
					success: function (response) {
						if (response.status === 'success') {
							options = [...response.items];
						}
					}
				})
			}
		}

		function downloadInstaConfigured(id) {
			jQuery.ajax({
				type: 'GET',
				url: `https://instafeedhub.com/wp-json/wiloke/v1/instagram/me/${id}/global-configuration`,
				dataType: 'json',
				success: function (response) {
					if (response.status === 'success') {
						options = [...response.items];
					}
				}
			})
		}

		return (
			<MyAutocomplete
				label='Search your instagram'
				value=''
				onChange={findInstaUserId}
				options={ options }
			/>
		);
	},

	/**
	 * The save function defines the way in which the different attributes should be combined
	 * into the final markup, which is then serialized by Gutenberg into post_content.
	 *
	 * The "save" property must be specified and must be a valid function.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
	 *
	 * @param {Object} props Props.
	 * @returns {Mixed} JSX Frontend HTML.
	 */
	save: function (props) {
		console.log(props)
		// Creates a <p class='wp-block-cgb-block-a11y-input'></p>.
		return (
			<div>{props.instaId}</div>
		);
	},
});
