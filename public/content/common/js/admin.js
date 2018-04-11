/*!
 * Skeleton Dashboard - Admin JS (https://github.com/bkader/skeleton)
 * Copyright 2018 Kader Bouyakoub (https://github.com/bkader)
 * Licensed under MIT (https://github.com/bkader/skeleton/blob/develop/LICENSE.md)
 */
(function ($) {
    jQuery.noConflict();
    "use strict";

    // ========================================================
    // Create jQuery.put and jQuery.delete.
    // ========================================================
    jQuery.each(["put", "delete"], function (i, method) {
        jQuery[method] = function (url, data, callback, type) {
            if (jQuery.isFunction(data)) {
                type = type || callback;
                callback = data;
                data = undefined;
            }

            // Process AJAX.
            return jQuery.ajax({
                url: url,
                type: method,
                dataType: type,
                data: data,
                success: callback
            });
        };
    });

    // ========================================================
    // Sidebar toggle.
    // ========================================================
    jQuery(document).on("click", ".sidebar-toggle", function (e) {
        e.preventDefault();
        jQuery("#sidebar").toggleClass("open");
    });

    // ========================================================
    // Links and buttons with confirmation message.
    // ========================================================
    jQuery(document).on("click", "[data-confirm]", function (e) {
        e.preventDefault();
        var that = jQuery(this),
            href = that.attr("href"),
            message = that.attr("data-confirm");

        bootbox.confirm({
            size: "small",
            message: message,
            callback: function (result) {
                bootbox.hideAll();
                if (result === true && href.length) {
                    window.location.href = href;
                }
            }
        });
        return false;
    });

    // ========================================================
    // Menu Manager Action.
    // ========================================================

    // Delete a menu.
    jQuery(document).on("click", ".delete-menu", function (e) {
        e.preventDefault();
        var that = jQuery(this),
            id = that.attr("data-menu-id"),
            href = that.attr("data-href"),
            message = that.attr("data-alert") || "Are you sure?";

        if (confirm(message)) {
            jQuery.get(href, function (response, textStatus) {
                if (textStatus == "success") {
                    toastr.success(response);
                    jQuery("#menu-" + id).fadeOut(function() {
                        jQuery(this).remove();
                    });
                } else {
                    toastr.error(response);
                }
            }, 'json');
        }
    });

    // Delete a menu item.
    jQuery(document).on("click", ".delete-menu-item", function (e) {
        e.preventDefault();
        var that = jQuery(this),
            id = that.attr("data-item-id"),
            href = that.attr("data-href"),
            message = that.attr("data-alert") || "Are you sure?";

        if (confirm(message)) {
            jQuery.get(href, function (response, textStatus) {
                if (textStatus == "success") {
                    toastr.success(response);
                    jQuery("#item-" + id).fadeOut(function() {
                        jQuery(this).remove();
                    });
                } else {
                    toastr.error(response);
                }
            }, 'json');
        }
    });
    // ========================================================
    // When the DOM is ready.
    // ========================================================
    jQuery(document).ready(function () {

        // --------------------------------------------------------
        // Toastr Configuration.
        // --------------------------------------------------------
        toastr.options = {
            "closeButton": true,
            "positionClass": "toast-top-center",
            "hideDuration": "300",
            "timeOut": "3500",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        // Right-to-left language?
        if (Config.lang.direction === 'rtl') {
            toastr.options.rtl = true;
        }

        // --------------------------------------------------------
        // BootBox Configuration.
        // --------------------------------------------------------
        bootbox.setDefaults({
            backdrop: false,
            closeButton: false,
            locale: Config.lang.code,
            size: "small"
        });

        // Dismissable alert.
        jQuery(".alert-dismissable").fadeTo(3000, 500).slideUp(500, function () {
            jQuery(this).alert("close");
        });

        // Initialize Bootstrap tooltip.
        jQuery(document).tooltip({selector: '[data-toggle="tooltip"]'});

        // Responsive table with dropdown buttons.
        jQuery(".table-responsive").on("show.bs.dropdown", function () {
            jQuery(".table-responsive").css("overflow", "inherit");
        });
        jQuery(".table-responsive").on("hide.bs.dropdown", function () {
            jQuery(".table-responsive").css("overflow", "auto");
        });

    });
})(jQuery);
