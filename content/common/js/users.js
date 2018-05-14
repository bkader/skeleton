/*!
 * CodeIgniter Skeleton - Users Module (https://github.com/bkader/skeleton)
 * Copyright 2018 Kader Bouyakoub (https://goo.gl/wGXHO9)
 * Licensed under MIT (https://github.com/bkader/skeleton/blob/develop/LICENSE.md)
 */
(function ($, undefined) {
    "use strict";

    // Prepare globals.
    var csk = window.csk = window.csk || {};
    csk.i18n = csk.i18n || {};
    csk.i18n.users = csk.i18n.users || {};

    /**
     * Users Object.
     * Handles all operations done on users module.
     * @since   1.4.0
     */
    csk.users = {

        // Activate user.
        activate: function (el) {
            return csk.users._do(el, "activate");
        },

        // Deactivate user.
        deactivate: function (el) {
            return csk.users._do(el, "deactivate");
        },

        // Delete user.
        delete: function (el) {
            return csk.users._do(el, "delete");
        },

        // Restore user.
        restore: function (el) {
            return csk.users._do(el, "restore");
        },

        // Remove user.
        remove: function (el) {
            return csk.users._do(el, "remove");
        },

        /**
         * All users actions handerl.
         * @since   2.0.0
         */
        _do: function (el, action) {
            var $this = $(el),
                endpoint = $this.data("endpoint"),
                row = $this.closest("tr"),
                row_id = row.attr("id"),
                id = row.data("id"),
                name = row.data("name"),
                action = action || -1;

            // No URL provided? Nothing to do...
            if (typeof endpoint === "undefined" || !endpoint.length) {
                return false;
            }

            csk.ui.confirm(csk.i18n.users[action], function () {
                csk.ajax.request(endpoint, {
                    type: "POST",
                    data: {action: action + "-user_" + id},
                    complete: function (jqXHR, textStatus) {
                        if (textStatus !== "success") {
                            return false;
                        }

                        if (action === "remove") {
                            row.animate({opacity: 0}, function () {
                                csk.ui.reload("#users-list", false, function () {
                                    row.remove();
                                });
                            });
                            return;
                        }

                        csk.ui.reload("#" + row_id, false);
                    }
                });
            });
        }
    };

    $(document).ready(function () {
        // Activate user.
        $(document).on("click", ".user-activate", function (e) {
            e.preventDefault();
            return csk.users.activate(this);
        });

        // Deactivate user.
        $(document).on("click", ".user-deactivate", function (e) {
            e.preventDefault();
            return csk.users.deactivate(this);
        });

        // Soft delete a user.
        $(document).on("click", ".user-delete", function (e) {
            e.preventDefault();
            return csk.users.delete(this);
        });

        // Restore a deleted user.
        $(document).on("click", ".user-restore", function (e) {
            e.preventDefault();
            return csk.users.restore(this);
        });

        // Remove user and related data.
        $(document).on("click", ".user-remove", function (e) {
            e.preventDefault();
            return csk.users.remove(this);
        });
    });

})(jQuery);
