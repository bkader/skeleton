/*!
 * CodeIgniter Skeleton - Users Module (https://github.com/bkader/skeleton)
 * Copyright 2018 Kader Bouyakoub (https://github.com/bkader)
 * Licensed under MIT (https://github.com/bkader/skeleton/blob/develop/LICENSE.md)
 */
(function ($, undefined) {
    
    jQuery.noConflict();
    "use strict";

    // ========================================================
    // Hold some needed variables.
    // ========================================================
    var wrapper = wrapper || jQuery("#wrapper");

    // ========================================================
    // User Class.
    // ========================================================
    Kbcore.user = {

        // Activate user.
        activate: function (el) {
            var that = jQuery(el), href = that.attr("href"), id = that.attr("data-user-id");
            if (!href.length) {
                return;
            }
            bootbox.confirm({
                message: i18n.user.activate,
                callback: function (result) {
                    bootbox.hideAll();
                    if (result === true) {
                        jQuery.get(href, function (response) {
                            toastr.success(response);
                        }).done(function () {
                            jQuery("#user-" + id).load(Config.currentURL + " #user-" + id + " > *");
                        }).fail(function (response) {
                            toastr.error(response.responseJSON)
                        });
                    }
                }
            });
        },

        // Deactivate user.
        deactivate: function (el) {
            var that = jQuery(el), href = that.attr("href"), id = that.attr("data-user-id");
            if (!href.length) {
                return;
            }
            bootbox.confirm({
                message: i18n.user.deactivate,
                callback: function (result) {
                    bootbox.hideAll();
                    if (result === true) {
                        jQuery.get(href, function (response) {
                            toastr.success(response);
                        }).done(function () {
                            jQuery("#user-" + id).load(Config.currentURL + " #user-" + id + " > *");
                        }).fail(function (response) {
                            toastr.error(response.responseJSON)
                        });
                    }
                }
            });
        },

        // Delete user.
        delete: function (el) {
            var that = jQuery(el), href = that.attr("href"), id = that.attr("data-user-id");
            if (!href.length) {
                return;
            }
            bootbox.confirm({
                message: i18n.user.delete,
                callback: function (result) {
                    bootbox.hideAll();
                    if (result === true) {
                        jQuery.get(href, function (response) {
                            toastr.success(response);
                        }).done(function () {
                            jQuery("#user-" + id).load(Config.currentURL + " #user-" + id + " > *");
                        }).fail(function (response) {
                            toastr.error(response.responseJSON)
                        });
                    }
                }
            });
        },

        // Restore user.
        restore: function (el) {
            var that = jQuery(el), href = that.attr("href"), id = that.attr("data-user-id");
            if (!href.length) {
                return;
            }
            bootbox.confirm({
                message: i18n.user.restore,
                callback: function (result) {
                    bootbox.hideAll();
                    if (result === true) {
                        jQuery.get(href, function (response) {
                            toastr.success(response);
                        }).done(function () {
                            jQuery("#user-" + id).load(Config.currentURL + " #user-" + id + " > *");
                        }).fail(function (response) {
                            toastr.error(response.responseJSON)
                        });
                    }
                }
            });
        },

        // Remove user.
        remove: function (el) {
            var that = jQuery(el),
                href = that.attr("href"),
                id = that.attr("data-user-id"),
                row = jQuery("#user-" + id);
            if (!href.length) {
                return;
            }
            bootbox.confirm({
                size: "small",
                message: i18n.user.remove,
                callback: function (result) {
                    bootbox.hideAll();
                    if (result === true && href.length && id.length) {
                        jQuery.get(href, function (response) {
                            toastr.success(response);
                        }).done(function () {
                            row.animate({opacity: 0}, function () {
                                wrapper.load(Config.currentURL + " #wrapper > *", function () {
                                    row.remove();
                                });
                            });
                        }).fail(function (response) {
                            toastr.error(response.responseJSON)
                        });
                    }
                }
            });
        },
    };

    // ========================================================
    // Activate user.
    // ========================================================
    jQuery(document).on("click", ".user-activate", function (e) {
        e.preventDefault();
        return Kbcore.user.activate(this);
    });

    // ========================================================
    // Deactivate user.
    // ========================================================
    jQuery(document).on("click", ".user-deactivate", function (e) {
        e.preventDefault();
        return Kbcore.user.deactivate(this);
    });

    // ========================================================
    // Soft delete a user.
    // ========================================================
    jQuery(document).on("click", ".user-delete", function (e) {
        e.preventDefault();
        return Kbcore.user.delete(this);
    });

    // ========================================================
    // Restore a deleted user.
    // ========================================================
    jQuery(document).on("click", ".user-restore", function (e) {
        e.preventDefault();
        return Kbcore.user.restore(this);
    });

    // ========================================================
    // Remove user and related data.
    // ========================================================
    jQuery(document).on("click", ".user-remove", function (e) {
        e.preventDefault();
        return Kbcore.user.remove(this);
    });

})(jQuery);
