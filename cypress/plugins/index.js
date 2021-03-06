/**
 * @file Cypress plugins index.js
 * @summary
 *     Custom plugins for UI testing
 * @version   0.1.0
 * @since     0.8.7 DTRT WordPress Plugin Boilerplate Generator
 */

/* eslint-env node */
/* globals Promise */

const normalizeWhitespace = require("normalize-html-whitespace");
const TenonNode = require("tenon-node");

// export a function
module.exports = (on) => {
  // configure plugins here
  on("task", {
    /**
     * Lint a URL in Tenon
     *
     * @param {string} url Fully qualified URL
     * @return {object} Tenon response object
     *
     * @see https://github.com/poorgeek/tenon-selenium-example/blob/master/test/helpers/tenonCommands.js
     * @see https://www.npmjs.com/package/tenon-node
     * @see https://github.com/dotherightthing/wpdtrt-plugin-boilerplate/wiki/Testing-&-Debugging#d-cypressio-front-end-unit-tests
     */
    tenonAnalyzeUrl(url) {
      const tenonApi = new TenonNode({
        key: process.env.TENON_API_KEY
      });

      return new Promise((resolve, reject) => {
        tenonApi.analyze(url, (err, tenonResult) => {
          if (err) {
            reject(err);
          }

          if (tenonResult.status > 400) {
            reject(tenonResult.info);
          } else {
            resolve(tenonResult);
          }
        });
      });
    },

    /**
     * Lint an HTML fragment in Tenon
     *
     * @param {string} selectorHtml HTML fragment
     * @return {object} Tenon response object
     * 
     * @see https://github.com/poorgeek/tenon-selenium-example/blob/master/test/helpers/tenonCommands.js
     * @see https://www.npmjs.com/package/tenon-node
     * @see https://github.com/dotherightthing/wpdtrt-plugin-boilerplate/wiki/Testing-&-Debugging#d-cypressio-front-end-unit-tests
     */
    tenonAnalyzeHtml(selectorHtml) {
      const html = normalizeWhitespace(selectorHtml); // strip whitespace between html tags
      const tenonApi = new TenonNode({
        key: process.env.TENON_API_KEY
      });

      return new Promise((resolve, reject) => {
        tenonApi.analyze(html, (err, tenonResult) => {
          if (err) {
            reject(err);
          }

          if (tenonResult.status > 400) {
            console.log(tenonResult.info);
            reject(tenonResult.info);
          } else {
            resolve(tenonResult);
          }
        });
      });
    }
  });
};
