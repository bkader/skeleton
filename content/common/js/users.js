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
            var that = $(el), 
                href = that.attr("href"), 
                id = that.data("id"),
                row = $("#user-" + id);
            
            if (!href.length) { return; }
            csk.ui.confirm(csk.i18n.users.activate, function () {
                csk.ajax.request(href, {
                    type: "POST",
                    data: {action: "activate-user_" + id},
                    success: function (data, textStatus) {
                        if (textStatus === "success") {
                            csk.ui.alert(data.message, "success");
                            $("#user-" + id).load(csk.config.currentURL + " #user-" + id + " > *");
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        csk.ui.alert(jqXHR.responseJSON.message, "error");
                    }
                });
            });
        },

        // Deactivate user.
        deactivate: function (el) {
            var that = $(el), 
                href = that.attr("href"), 
                id = that.data("id"),
                row = $("#user-" + id);
            
            if (!href.length) { return; }

            csk.ui.confirm(csk.i18n.users.deactivate, function () {
                csk.ajax.request(href, {
                    type: "POST",
                    data: {action: "deactivate-user_" + id},
                    success: function (data, textStatus) {
                        if (textStatus === "success") {
                            csk.ui.alert(data.message, "success");
                            $("#user-" + id).load(csk.config.currentURL + " #user-" + id + " > *");
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        csk.ui.alert(jqXHR.responseJSON.message, "error");
                    }
                });
            });
        },

        // Delete user.
        delete: function (el) {
            var that = $(el), 
                href = that.attr("href"), 
                id = that.data("id"),
                row = $("#user-" + id);
            
            if (!href.length) { return; }

            csk.ui.confirm(csk.i18n.users.delete, function () {
                csk.ajax.request(href, {
                    type: "POST",
                    data: {action: "delete-user_" + id},
                    success: function (data, textStatus) {
                        if (textStatus === "success") {
                            csk.ui.alert(data.message, "success");
                            $("#user-" + id).load(csk.config.currentURL + " #user-" + id + " > *");
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        csk.ui.alert(jqXHR.responseJSON.message, "error");
                    }
                });
            });
        },

        // Restore user.
        restore: function (el) {
            var that = $(el), 
                href = that.attr("href"), 
                id = that.data("id"),
                row = $("#user-" + id);
            
            if (!href.length) { return; }

            csk.ui.confirm(csk.i18n.users.restore, function () {
                csk.ajax.request(href, {
                    type: "POST",
                    data: {action: "restore-user_" + id},
                    success: function (data, textStatus) {
                        if (textStatus === "success") {
                            csk.ui.alert(data.message, "success");
                            $("#user-" + id).load(csk.config.currentURL + " #user-" + id + " > *");
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        csk.ui.alert(jqXHR.responseJSON.message, "error");
                    }
                });
            });
        },

        // Remove user.
        remove: function (el) {
            var that = $(el), 
                href = that.attr("href"), 
                id = that.data("id"),
                row = $("#user-" + id);

            if (!href.length) { return;}

            csk.ui.confirm(csk.i18n.users.remove, function () {
                csk.ajax.request(href, {
                    type: "POST",
                    data: {action: "remove-user_" + id},
                    success: function (data, textStatus) {
                        if (textStatus === "success") {
                            csk.ui.alert(data.message, "success");
                            row.animate({opacity: 0}, function () {
                                $("#wrapper").load(csk.config.currentURL + " #wrapper > *", function () {
                                    row.remove();
                                });
                            });
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        csk.ui.alert(jqXHR.responseJSON.message, "error");
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
