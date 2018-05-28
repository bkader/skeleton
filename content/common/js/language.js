/*!
 * CodeIgniter Skeleton - Language Module (https://github.com/bkader/skeleton)
 * Copyright 2018 Kader Bouyakoub (https://goo.gl/wGXHO9)
 * Licensed under MIT (https://github.com/bkader/skeleton/blob/develop/LICENSE.md)
 */
(function($, window, document, undefined) {
    "use strict";

    // Prepare globals.
    var csk = window.csk = window.csk || {};
    csk.i18n = csk.i18n || {};
    csk.languages = csk.languages || {};
    csk.i18n.languages = csk.i18n.languages || {};

    /**
     * Skeleton Languages.
     * @since   2.1.1
     */
    csk.languages.proceed = function(el, action) {
        var $this = $(el),
            href = $this.data("endpoint"),
            row = $this.closest("tr"),
            id = row.attr("id") || undefined,
            name = row.data("name") || 'this',
            action = action || -1;

        /** If no URL is provided, nothing to do... */
        if (typeof href === "undefined" || !href.length) {
            return false;
        }

        /** Add opacity to siblings */
        row.siblings("tr").addClass("op-2");

        /** We define the confirmation message. */
        var message = csk.i18n.languages[action] || undefined;
        if (typeof message === "undefined") {
            message = csk.i18n.default[action] || undefined;
            if (typeof message === "undefined") {
                message = "Are you sure you to " + action + " %s?";
            }
        }

        /** We add the id to the URL if defined. */
        if (typeof id !== "undefined" && id.length) {
            href = href + "#" + id;
        }

        /** Display confirmation message. */
        csk.ui.confirm($.sprintf(message, name), function () {
            window.location.href = href;
        }, function () {
            /** Make sure to remove opacity class from siblings. */
            row.siblings("tr").removeClass("op-2");
        });
    };

    $(document).ready(function () {
        /** Enable language. */
        $(document).on("click", ".language-enable", function (e) {
            e.preventDefault();
            return csk.languages.proceed(this, "enable");
        });

        /** Disable language. */
        $(document).on("click", ".language-disable", function (e) {
            e.preventDefault();
            return csk.languages.proceed(this, "disable");
        });

        /** Make default. */
        $(document).on("click", ".language-default", function (e) {
            e.preventDefault();
            return csk.languages.proceed(this, "make_default");
        });
    });

})(window.jQuery || window.Zepto, window, document);
