/**
 * BLOCK: wiloke-instafeedhub
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */
/*jshint esversion: 6 */
//  Import CSS.
import './style.scss';
import ContentEditable from 'react-contenteditable';
import styled from 'styled-components';
import { Icon } from '@wordpress/components';
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

const MyIcon = () => (
  <Icon
    icon={() => (
      <svg height="512pt" viewBox="0 -77 512.00213 512" width="512pt" xmlns="http://www.w3.org/2000/svg">
        <path
          d="m501.453125 56.09375c-5.902344-21.933594-23.195313-39.222656-45.125-45.128906-40.066406-10.964844-200.332031-10.964844-200.332031-10.964844s-160.261719 0-200.328125 10.546875c-21.507813 5.902344-39.222657 23.617187-45.125 45.546875-10.542969 40.0625-10.542969 123.148438-10.542969 123.148438s0 83.503906 10.542969 123.148437c5.90625 21.929687 23.195312 39.222656 45.128906 45.128906 40.484375 10.964844 200.328125 10.964844 200.328125 10.964844s160.261719 0 200.328125-10.546875c21.933594-5.902344 39.222656-23.195312 45.128906-45.125 10.542969-40.066406 10.542969-123.148438 10.542969-123.148438s.421875-83.507812-10.546875-123.570312zm0 0"
          fill="#f00"
        />
        <path d="m204.96875 256 133.269531-76.757812-133.269531-76.757813zm0 0" fill="#fff" />
      </svg>
    )}
  />
);

registerBlockType('cgb/block-youtube-playlist', {
  // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
  title: __('Youtube Playlist'), // Block title.
  icon: MyIcon, // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
  category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
  keywords: [__('youtubePlaylist'), __('youtube')],
  attributes: {
    inputValue: {
      type: 'string',
      default: '',
    },
    option: {
      type: 'string',
      default: 'playlist',
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

  save: function ({ attributes }) {
    const { option, inputValue } = attributes;
    return (
      <div class="wil-youtube-playlist">
        {option === 'multiIds' && <div class="wil-youtube-list-video" data-variant="style1" data-videoIds={inputValue}></div>}
        {option === 'playlist' && <div class="wil-youtube-list-video" data-variant="style2" data-playlistId={inputValue}></div>}
      </div>
    );
  },
});
