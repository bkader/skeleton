/*!
 * CodeIgniter Skeleton - Language Module (https://github.com/bkader/skeleton)
 * Copyright 2018 Kader Bouyakoub (https://goo.gl/wGXHO9)
 * Licensed under MIT (https://github.com/bkader/skeleton/blob/develop/LICENSE.md)
 */
(function($, window, document, undefined) {
    "use strict";

    // Prepare globals.
    var csk           = window.csk = window.csk || {};
    csk.i18n = csk.i18n || {};
    csk.i18n.language = csk.i18n.language || {};

    /**
     * Language Object.
     * Handles all operations done on language module.
     * @since   1.3.0
     */
    csk.language = {

        // Enable a language.
        enable: function (el) {
            return csk.language._do(el, "enable");
        },

        // Disable a language.
        disable: function (el) {
            return csk.language._do(el, "disable");
        },

        // Make default.
        make_default: function (el) {
            return csk.language._do(el, "default");
        },

        // Actions handler.
        _do: function (el, action) {
            var $this = $(el),
                href = $this.data("endpoint"),
                row = $this.closest("tr"),
                lang = row.data("lang"),
                id = row.attr("id"),
                action = action || -1;

            // No URL provided? Nothing to do...
            if (typeof href === "undefined" || !href.length || action <= 0) {
                return false;
            }

            csk.ui.confirm(csk.i18n.language[action], function () {
                csk.ajax.request(href, {
                    type: "POST",
                    data: {action: action + "-language_" + lang},
                    complete: function (jqXHR, textStatus) {
                        if (textStatus !== "success") {
                            return;
                        }

                        // Refresh the page is we disable the current language.
                        if (action === "disable" && lang === csk.config.lang.folder) {
                            location.reload();
                            return;
                        }

                        // Simply reload the UI.
                        csk.ui.reload();
                    }
                });
            });
        }
    };

    $(document).ready(function () {
        // Enable language.
        $(document).on("click", ".language-enable", function (e) {
            e.preventDefault();
            return csk.language.enable(this);
        });

        // Disable language.
        $(document).on("click", ".language-disable", function (e) {
            e.preventDefault();
            return csk.language.disable(this);
        });

        // Make default.
        $(document).on("click", ".language-default", function (e) {
            e.preventDefault();
            return csk.language.make_default(this);
        });
    });

})(window.jQuery || window.Zepto, window, document);
