/*!
 * Skeleton Dashboard - Admin JS (https://github.com/bkader/skeleton)
 * Copyright 2018 Kader Bouyakoub (https://github.com/bkader)
 * Licensed under MIT (https://github.com/bkader/skeleton/blob/develop/LICENSE.md)
 */
(function ($, window, document, undefined) {
    $.noConflict();
    "use strict";

    // ========================================================
    // Create $.put and $.delete.
    // ========================================================
    $.each(["put", "delete"], function (i, method) {
        $[method] = function (url, data, callback, type) {
            if ($.isFunction(data)) {
                type = type || callback;
                callback = data;
                data = undefined;
            }

            // Process AJAX.
            return $.ajax({
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
    $(document).on("click", ".sidebar-toggle", function (e) {
        e.preventDefault();
        $("#sidebar").toggleClass("open");
    });

    // ========================================================
    // Links and buttons with confirmation message.
    // ========================================================
    $(document).on("click", "[data-confirm]", function (e) {
        e.preventDefault();
        var that = $(this),
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
    // When the DOM is ready.
    // ========================================================
    $(document).ready(function () {

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
        $(".alert-dismissable").fadeTo(3000, 500).slideUp(500, function () {
            $(this).alert("close");
        });

        // Initialize Bootstrap tooltip.
        $(document).tooltip({selector: '[data-toggle="tooltip"]'});

        // Responsive table with dropdown buttons.
        $(".table-responsive").on("show.bs.dropdown", function () {
            $(".table-responsive").css("overflow", "inherit");
        });
        $(".table-responsive").on("hide.bs.dropdown", function () {
            $(".table-responsive").css("overflow", "auto");
        });

    });
})(window.jQuery || window.Zepto, window, document);
