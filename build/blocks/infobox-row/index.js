/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/blocks/infobox-row/editor.scss"
/*!********************************************!*\
  !*** ./src/blocks/infobox-row/editor.scss ***!
  \********************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ },

/***/ "react/jsx-runtime"
/*!**********************************!*\
  !*** external "ReactJSXRuntime" ***!
  \**********************************/
(module) {

module.exports = window["ReactJSXRuntime"];

/***/ },

/***/ "@wordpress/block-editor"
/*!*************************************!*\
  !*** external ["wp","blockEditor"] ***!
  \*************************************/
(module) {

module.exports = window["wp"]["blockEditor"];

/***/ },

/***/ "@wordpress/components"
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
(module) {

module.exports = window["wp"]["components"];

/***/ },

/***/ "@wordpress/element"
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
(module) {

module.exports = window["wp"]["element"];

/***/ },

/***/ "@wordpress/i18n"
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
(module) {

module.exports = window["wp"]["i18n"];

/***/ }

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		if (!(moduleId in __webpack_modules__)) {
/******/ 			delete __webpack_module_cache__[moduleId];
/******/ 			var e = new Error("Cannot find module '" + moduleId + "'");
/******/ 			e.code = 'MODULE_NOT_FOUND';
/******/ 			throw e;
/******/ 		}
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry needs to be wrapped in an IIFE because it needs to be isolated against other modules in the chunk.
(() => {
/*!*****************************************!*\
  !*** ./src/blocks/infobox-row/index.js ***!
  \*****************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ Edit)
/* harmony export */ });
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./editor.scss */ "./src/blocks/infobox-row/editor.scss");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__);






function Edit({
  attributes,
  setAttributes
}) {
  const DRAFT_DEFAULTS = {
    title: "",
    text: "",
    linkUrl: "",
    linkText: "",
    linkNewTab: false,
    order: 0
  };
  const {
    items
  } = attributes;
  const [isModalOpen, setIsModalOpen] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useState)(false);
  const [editingIndex, setEditingIndex] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useState)(null);
  const [draft, setDraft] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useState)(DRAFT_DEFAULTS);
  function openAddModal() {
    setDraft(DRAFT_DEFAULTS);
    setEditingIndex(null);
    setIsModalOpen(true);
  }
  function openEditModal(index) {
    const item = items[index];
    setDraft({
      title: item.dt,
      text: item.ddText,
      linkUrl: item.linkUrl || "",
      linkText: item.linkText || "",
      linkNewTab: item.linkNewTab || false,
      order: item.order ?? 0
    });
    setEditingIndex(index);
    setIsModalOpen(true);
  }
  function closeModal() {
    setIsModalOpen(false);
  }
  function saveItem() {
    const newItem = {
      id: editingIndex !== null ? items[editingIndex].id : String(Date.now()),
      dt: draft.title,
      ddText: draft.text,
      linkUrl: draft.linkUrl,
      linkText: draft.linkText,
      linkNewTab: draft.linkNewTab,
      order: draft.order
    };
    if (editingIndex !== null) {
      setAttributes({
        items: items.map((item, i) => i === editingIndex ? newItem : item)
      });
    } else {
      setAttributes({
        items: [...items, newItem]
      });
    }
    closeModal();
  }
  function removeItem(index) {
    setAttributes({
      items: items.filter((_, i) => i !== index)
    });
  }
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsxs)("div", {
    ...(0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.useBlockProps)(),
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.InspectorControls, {
      children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.PanelBody, {
        title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)("Infobox Row Settings", "infobox-row"),
        initialOpen: true,
        children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.PanelRow, {})
      })
    }), isModalOpen && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsxs)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Modal, {
      title: editingIndex !== null ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)("Edit Item", "infobox-row") : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)("Add Item", "infobox-row"),
      onRequestClose: closeModal,
      className: "infobox-row__modal",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.TextControl, {
        label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)("Title", "infobox-row"),
        value: draft.title,
        onChange: value => setDraft(prev => ({
          ...prev,
          title: value
        }))
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.TextareaControl, {
        label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)("Description", "infobox-row"),
        value: draft.text,
        onChange: value => setDraft(prev => ({
          ...prev,
          text: value
        })),
        rows: 4
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsxs)("div", {
        className: "infobox-row__url-field",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)("label", {
          className: "components-base-control__label",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)("Search post or add url", "infobox-row")
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.URLInput, {
          value: draft.linkUrl,
          onChange: url => setDraft(prev => ({
            ...prev,
            linkUrl: url
          })),
          placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)("Search pages or paste URL…", "infobox-row")
        })]
      }), draft.linkUrl && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsxs)(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.Fragment, {
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.TextControl, {
          label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)("Link text", "infobox-row"),
          value: draft.linkText,
          onChange: value => setDraft(prev => ({
            ...prev,
            linkText: value
          })),
          placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)("Defaults to URL if empty", "infobox-row")
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.ToggleControl, {
          label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)("Open in new tab", "infobox-row"),
          checked: draft.linkNewTab,
          onChange: value => setDraft(prev => ({
            ...prev,
            linkNewTab: value
          }))
        })]
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsxs)("div", {
        className: "infobox-row__modal-actions",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Button, {
          variant: "primary",
          onClick: saveItem,
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)("Save", "infobox-row")
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Button, {
          variant: "secondary",
          onClick: closeModal,
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)("Cancel", "infobox-row")
        })]
      })]
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsxs)("dl", {
      className: "infobox-row__list",
      children: [items.length === 0 && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)("p", {
        className: "infobox-row__empty",
        children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)("Add info item below", "infobox-row")
      }), items.map((item, index) => /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsxs)("div", {
        className: "infobox-row__item",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)("dt", {
          children: item.dt || /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)("em", {
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)("(empty term)", "infobox-row")
          })
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsxs)("dd", {
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsxs)("span", {
            children: [item.ddText, item.linkUrl && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsxs)(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.Fragment, {
              children: [" ", /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)("a", {
                href: item.linkUrl,
                children: item.linkText || item.linkUrl
              })]
            })]
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsxs)("span", {
            className: "infobox-row__item-actions",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Button, {
              variant: "secondary",
              size: "small",
              onClick: () => openEditModal(index),
              children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)("svg", {
                width: "16px",
                height: "16px",
                viewBox: "0 0 24 24",
                fill: "none",
                xmlns: "http://www.w3.org/2000/svg",
                children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)("path", {
                  d: "M12 3.99997H6C4.89543 3.99997 4 4.8954 4 5.99997V18C4 19.1045 4.89543 20 6 20H18C19.1046 20 20 19.1045 20 18V12M18.4142 8.41417L19.5 7.32842C20.281 6.54737 20.281 5.28104 19.5 4.5C18.7189 3.71895 17.4526 3.71895 16.6715 4.50001L15.5858 5.58575M18.4142 8.41417L12.3779 14.4505C12.0987 14.7297 11.7431 14.9201 11.356 14.9975L8.41422 15.5858L9.00257 12.6441C9.08001 12.2569 9.27032 11.9013 9.54951 11.6221L15.5858 5.58575M18.4142 8.41417L15.5858 5.58575",
                  stroke: "#000000",
                  "stroke-width": "1",
                  "stroke-linecap": "round",
                  "stroke-linejoin": "round"
                })
              })
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Button, {
              variant: "secondary",
              size: "small",
              isDestructive: true,
              onClick: () => removeItem(index),
              children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)("svg", {
                width: "16px",
                height: "16px",
                viewBox: "0 0 24 24",
                fill: "none",
                xmlns: "http://www.w3.org/2000/svg",
                children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)("path", {
                  "fill-rule": "evenodd",
                  "clip-rule": "evenodd",
                  d: "M7.10002 5H3C2.44772 5 2 5.44772 2 6C2 6.55228 2.44772 7 3 7H4.06055L4.88474 20.1871C4.98356 21.7682 6.29471 23 7.8789 23H16.1211C17.7053 23 19.0164 21.7682 19.1153 20.1871L19.9395 7H21C21.5523 7 22 6.55228 22 6C22 5.44772 21.5523 5 21 5H19.0073C19.0018 4.99995 18.9963 4.99995 18.9908 5H16.9C16.4367 2.71776 14.419 1 12 1C9.58104 1 7.56329 2.71776 7.10002 5ZM9.17071 5H14.8293C14.4175 3.83481 13.3062 3 12 3C10.6938 3 9.58254 3.83481 9.17071 5ZM17.9355 7H6.06445L6.88085 20.0624C6.91379 20.5894 7.35084 21 7.8789 21H16.1211C16.6492 21 17.0862 20.5894 17.1192 20.0624L17.9355 7ZM14.279 10.0097C14.83 10.0483 15.2454 10.5261 15.2068 11.0771L14.7883 17.0624C14.7498 17.6134 14.2719 18.0288 13.721 17.9903C13.17 17.9517 12.7546 17.4739 12.7932 16.9229L13.2117 10.9376C13.2502 10.3866 13.7281 9.97122 14.279 10.0097ZM9.721 10.0098C10.2719 9.97125 10.7498 10.3866 10.7883 10.9376L11.2069 16.923C11.2454 17.4739 10.83 17.9518 10.2791 17.9903C9.72811 18.0288 9.25026 17.6134 9.21173 17.0625L8.79319 11.0771C8.75467 10.5262 9.17006 10.0483 9.721 10.0098Z",
                  fill: "#0F1729"
                })
              })
            })]
          })]
        })]
      }, item.id))]
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_5__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Button, {
      variant: "primary",
      onClick: openAddModal,
      className: "infobox-row__add-btn",
      children: "+ Add row"
    })]
  });
}
})();

/******/ })()
;
//# sourceMappingURL=index.js.map