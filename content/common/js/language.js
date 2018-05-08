/*!
 * CodeIgniter Skeleton - Language Module (https://github.com/bkader/skeleton)
 * Copyright 2018 Kader Bouyakoub (https://goo.gl/wGXHO9)
 * Licensed under MIT (https://github.com/bkader/skeleton/blob/develop/LICENSE.md)
 */
(function($, window, document, undefined) {
    "use strict";

    // Prepare globals.
    var csk           = window.csk = window.csk || {};
    csk.i18n          = csk.i18n || {};
    csk.i18n.lang = csk.i18n.lang || {};

    /**
     * Language Object.
     * Handles all operations done on language module.
     * @since   1.3.0
     */
    csk.language = {

        // Enable the targeted language.
        enable: function (el, action) {
            var $this = $(el),
                href = $this.attr("href"),
                id = $this.data("lang"),
                action = action || 'enable-language_';
            
            if (!href.length || !action.length) {
                return false;
            }
            
            csk.ajax.request(href, {
                type: "POST",
                data: {action: action + id},
                complete: function () {
                    $("#wrapper").load(csk.config.currentURL + " #wrapper > *");
                    $("#lang-dropdown").load(csk.config.currentURL + " #lang-dropdown > *");
                }
            });
        },

        // Disable the targeted language.
        disable: function (el) {
            return this.enable(el, 'disable-language_');
        },

        // Make sure selected language default.
        make_default: function (el) {
            return this.enable(el, 'default-language_');
        }
    };

    $(document).ready(function () {

        // Enable language.
        $(document).on("click", ".lang-enable", function (e) {
            e.preventDefault();
            return csk.language.enable(this);
        });

        // Disable language.
        $(document).on("click", ".lang-disable", function (e) {
            e.preventDefault();
            return csk.language.disable(this);
        });

        // Make default.
        $(document).on("click", ".lang-default", function (e) {
            e.preventDefault();
            return csk.language.make_default(this);
        });
    });

})(window.jQuery || window.Zepto, window, document);
