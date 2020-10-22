/**
 * BLOCK: wiloke-instafeedhub
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */
/*jshint esversion: 6 */
//  Import CSS.
import "./editor.scss";
import "./style.scss";
import ContentEditable from "react-contenteditable";
import styled from "styled-components";
import { TextControl, Autocomplete, PanelBody } from "@wordpress/components";
import { InspectorControls } from "@wordpress/editor";
import axios from "axios";
import * as _ from "lodash";
import MyAutocomplete from "../simple-autocomplete";

const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks
const { useState, useEffect } = wp.element;
const labelText = "NAME (Accessible Text Input)";

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
registerBlockType("cgb/block-wiloke-instafeedhub", {
  // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
  title: __("wiloke-instafeedhub - CGB Block"), // Block title.
  icon: "shield", // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
  category: "common", // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
  keywords: [
    __("wiloke-instafeedhub — CGB Block"),
    __("CGB Example"),
    __("create-guten-block"),
  ],
  attributes: {
    value: {
      type: "string",
      source: "attribute",
      selector: "h1",
      attribute: "data-value",
    },
    options: {
      type: "array",
    },
  },
  example: {
    attributes: {
      value: "",
      options: [],
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
  edit: function ({ setAttributes, isSelected, attributes }) {
    //   === CONFIG AXIOS CANCEL ===	//
    const CancelToken = axios.CancelToken;
    let cancel;

    let timeOutRequest;

    // === ATTRBUTES === //
    const { options = [], value = "" } = attributes;

    // === USESTATE === //

    const actionAxiosFindUser = (query) => {
      const url = `https://instafeedhub.com/wp-json/wiloke/v1/instagram/me/find-insta-user?q=${query}`;
      if (cancel) {
        cancel();
      }
      axios
        .get(url, {
          responseType: "json",
          cancelToken: new CancelToken((c) => {
            cancel = c;
          }),
        })
        .then(({ data }) => {
          setAttributes({
            options: data.items || [],
            // options: _.unionWith(data.items, options, _.isEqual),
          });
        })
        .catch((thrown) => {
          if (axios.isCancel(thrown)) {
            console.log("Request canceled", thrown.message);
          } else {
            console.log("ERROR", { thrown });
          }
        });
    };

    function findInstaUserId(val) {
      timeOutRequest && clearTimeout(timeOutRequest);
      if (!!val) {
        timeOutRequest = setTimeout(() => {
          actionAxiosFindUser(val);
        }, 300);
      }
    }

    function downloadInstaConfigured({ id }) {
      const url = `https://instafeedhub.com/wp-json/wiloke/v1/instagram/me/${id}/global-configuration`;
      axios
        .get(url, {
          responseType: "json",
        })
        .then(console.log)
        .catch(console.error);
    }

    console.log(44, { attributes });

    return (
      <div>
        <MyAutocomplete
          label="Search your instagram"
          onChange={findInstaUserId}
          onSelectItem={(item) => {
            setAttributes({ value: item.name });
            downloadInstaConfigured(item);
          }}
          options={options}
          id="block-id"
          value={value}
        />
      </div>
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
    console.log(11, { props });

    return (
      <h1 data-value={props.attributes.value}>{props.attributes.value}</h1>
    );
  },
});
