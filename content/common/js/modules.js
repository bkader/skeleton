/*!
 * CodeIgniter Skeleton - Modules (https://github.com/bkader/skeleton)
 * Copyright 2018 Kader Bouyakoub (https://goo.gl/wGXHO9)
 * Licensed under MIT (https://github.com/bkader/skeleton/blob/develop/LICENSE.md)
 */
(function ($, window, document, undefined) {
    "use strict";

    // Prepare globals.
    var csk = window.csk = window.csk || {};
    csk.i18n = csk.i18n || {};
    csk.modules = csk.modules || {};
    csk.i18n.modules = csk.i18n.modules || {};

    /**
     * Skeleton Modules.
     * @since   2.1.0
     */
    csk.modules.proceed = function(el, action) {
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
        var message = csk.i18n.modules[action] || undefined;
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

    $(document).ready(function() {
        /** Activate module. */
        $(document).on("click", ".module-activate", function(e) {
            e.preventDefault();
            return csk.modules.proceed(this, "activate");
        });

        /** Deactivate module. */
        $(document).on("click", ".module-deactivate", function(e) {
            e.preventDefault();
            return csk.modules.proceed(this, "deactivate");
        });

        /** Delete module. */
        $(document).on("click", ".module-delete", function(e) {
            e.preventDefault();
            return csk.modules.proceed(this, "delete");
        });
    });

})(window.jQuery || window.Zepto, window, document);
