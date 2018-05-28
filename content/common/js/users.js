/*!
 * CodeIgniter Skeleton - Users Module (https://github.com/bkader/skeleton)
 * Copyright 2018 Kader Bouyakoub (https://goo.gl/wGXHO9)
 * Licensed under MIT (https://github.com/bkader/skeleton/blob/develop/LICENSE.md)
 */
(function ($, window, document, undefined) {
    "use strict";

    // Prepare globals.
    var csk = window.csk = window.csk || {};
    csk.i18n = csk.i18n || {};
    csk.users = csk.users || {};
    csk.i18n.users = csk.i18n.users || {};

    /**
     * Skeleton Users.
     * @since   2.1.1
     */
    csk.users.proceed = function(el, action) {
        var $this = $(el),
            href = $this.data("endpoint"),
            row = $this.closest("tr"),
            name = row.data("name") || 'this',
            id = row.attr("id") || undefined,
            action = action || -1;

        /** If no URL is provided, nothing to do... */
        if (typeof href === "undefined" || !href.length) {
            return false;
        }

        /** Add opacity to siblings */
        row.siblings("tr").addClass("op-2");

        /** We define the confirmation message. */
        var message = csk.i18n.users[action] || undefined;
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
        /** Activate user. */
        $(document).on("click", ".user-activate", function (e) {
            e.preventDefault();
            return csk.users.proceed(this, "activate");
        });

        /** Deactivate user. */
        $(document).on("click", ".user-deactivate", function (e) {
            e.preventDefault();
            return csk.users.proceed(this, "deactivate");
        });

        /** Soft delete a user. */
        $(document).on("click", ".user-delete", function (e) {
            e.preventDefault();
            return csk.users.proceed(this, "delete");
        });

        /** Restore a deleted user. */
        $(document).on("click", ".user-restore", function (e) {
            e.preventDefault();
            return csk.users.proceed(this, "restore");
        });

        /** Remove user and related data. */
        $(document).on("click", ".user-remove", function (e) {
            e.preventDefault();
            return csk.users.proceed(this, "remove");
        });
    });

})(window.jQuery || window.Zepto, window, document);
