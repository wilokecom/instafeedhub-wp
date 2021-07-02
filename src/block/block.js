/**
 * BLOCK: wiloke-instafeedhub
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */
/*jshint esversion: 6 */
//  Import CSS.
import './editor.scss';
import './style.scss';
import ContentEditable from 'react-contenteditable';
import styled from 'styled-components';
import { TextControl, Autocomplete, PanelBody } from '@wordpress/components';
import { InspectorControls } from '@wordpress/editor';
import Edit from './edit';

const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks
const { useState, useEffect } = wp.element;
const labelText = 'NAME (Accessible Text Input)';
const el = wp.element.createElement;

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

const iconEl = el(
	'svg',
	{
		width: 20,
		height: 20,
		'enable-background': 'new 0 0 24 24',
		viewBox: '0 0 24 24',
		xmlns: 'http://www.w3.org/2000/svg',
		'xmlns:xlink': 'http://www.w3.org/1999/xlink',
	},
	el(
		'linearGradient',
		{
			id: 'SVGID_1_',
			gradientTransform: 'matrix(0 -1.982 -1.844 0 -132.522 -51.077)',
			gradientUnits: 'userSpaceOnUse',
			x1: '-37.106',
			x2: '-26.555',
			y1: '-72.705',
			y2: '-84.047',
		},
		el( 'stop', { offset: '0', 'stop-color': '#fd5' } ),
		el( 'stop', { offset: '.5', 'stop-color': '#ff543e' } ),
		el( 'stop', { offset: '1', 'stop-color': '#c837ab' } ),
	),
	el( 'path', {
		d:
      'm1.5 1.633c-1.886 1.959-1.5 4.04-1.5 10.362 0 5.25-.916 10.513 3.878 11.752 1.497.385 14.761.385 16.256-.002 1.996-.515 3.62-2.134 3.842-4.957.031-.394.031-13.185-.001-13.587-.236-3.007-2.087-4.74-4.526-5.091-.559-.081-.671-.105-3.539-.11-10.173.005-12.403-.448-14.41 1.633z',
		fill: 'url(#SVGID_1_)',
	} ),
	el( 'path', {
		d:
      'm11.998 3.139c-3.631 0-7.079-.323-8.396 3.057-.544 1.396-.465 3.209-.465 5.805 0 2.278-.073 4.419.465 5.804 1.314 3.382 4.79 3.058 8.394 3.058 3.477 0 7.062.362 8.395-3.058.545-1.41.465-3.196.465-5.804 0-3.462.191-5.697-1.488-7.375-1.7-1.7-3.999-1.487-7.374-1.487zm-.794 1.597c7.574-.012 8.538-.854 8.006 10.843-.189 4.137-3.339 3.683-7.211 3.683-7.06 0-7.263-.202-7.263-7.265 0-7.145.56-7.257 6.468-7.263zm5.524 1.471c-.587 0-1.063.476-1.063 1.063s.476 1.063 1.063 1.063 1.063-.476 1.063-1.063-.476-1.063-1.063-1.063zm-4.73 1.243c-2.513 0-4.55 2.038-4.55 4.551s2.037 4.55 4.55 4.55 4.549-2.037 4.549-4.55-2.036-4.551-4.549-4.551zm0 1.597c3.905 0 3.91 5.908 0 5.908-3.904 0-3.91-5.908 0-5.908z',
		fill: '#fff',
	} ),
);

registerBlockType( 'cgb/block-instafeedhub', {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __( 'InstafeedHub' ), // Block title.
	icon: iconEl, // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	keywords: [ __( 'instafeedhub' ), __( 'instagram' ) ],
	attributes: {
		instaId: {
			type: 'string',
			default: '',
		},
		instaTitle: {
			type: 'string',
			default: 'Edit your instaFeed',
		},
	},

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
	edit: Edit,

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

	save: function( props ) {
		// eslint-disable-next-line no-console
		console.log( props );
		return <div className="wil-instagram-shopify" data-id={ props.attributes.instaId }></div>;
	},
} );
