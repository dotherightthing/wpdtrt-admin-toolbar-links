/**
 * @file DTRT Admin Toolbar Links frontend.js
 * @summary
 *     Front-end scripting for public pages
 *     PHP variables are provided in `wpdtrt_admin_toolbar_links_config`.
 * @version 0.1.0
 * @since   0.8.7 DTRT WordPress Plugin Boilerplate Generator
 */

/* eslint-env browser */
/* global document, jQuery, wpdtrt_admin_toolbar_links_config */
/* eslint-disable no-unused-vars */

/**
 * @namespace wpdtrt_admin_toolbar_links_ui
 */
const wpdtrt_admin_toolbar_links_ui = {

    /**
     * Initialise front-end scripting
     * @since 0.1.0
     */
    init: () => {
        console.log("wpdtrt_admin_toolbar_links_ui.init");
    }
}

// http://stackoverflow.com/a/28771425
document.addEventListener("touchstart", () => {
  // nada, this is just a hack to make :focus state render on touch
}, false);

jQuery(document).ready( ($) => {
    const config = wpdtrt_admin_toolbar_links_config;
    wpdtrt_admin_toolbar_links_ui.init();
});
