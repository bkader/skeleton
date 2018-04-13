/*!
 * CodeIgniter Skeleton - Plugins Module (https://github.com/bkader/skeleton)
 * Copyright 2018 Kader Bouyakoub (https://github.com/bkader)
 * Licensed under MIT (https://github.com/bkader/skeleton/blob/develop/LICENSE.md)
 */
(function ($, window, document, undefined) {
    $.noConflict();
    "use strict";

    // ========================================================
    // Plugin activation.
    // ========================================================
    $(document).on("click", ".plugin-activate", function (e) {
        e.preventDefault();
        var that = $(this), href = that.attr("href");
        if (!href.length) { return; }
        $.get(href, function (response) {
            toastr.success(response);
        }).done(function () {
            setTimeout(function () {
                location.reload();
            }, 1000);
        }).fail(function (response) {
            toastr.error(response.responseJSON);
        });
    });

    // ========================================================
    // Plugin deactivation.
    // ========================================================
    $(document).on("click", ".plugin-deactivate", function (e) {
        e.preventDefault();
        var that = $(this), href = that.attr("href");
        if (!href.length) { return; }
        $.get(href, function (response) {
            toastr.success(response);
        }).done(function () {
            setTimeout(function () {
                location.reload();
            }, 1000);
        }).fail(function (response) {
            toastr.error(response.responseJSON);
        });
    });

    // ========================================================
    // Plugin delete.
    // ========================================================
    $(document).on("click", ".plugin-delete", function (e) {
        e.preventDefault();
        var that = $(this), href = that.attr("href"), slug = that.attr("data-plugin");
        if (!href.length || !slug.length) { return; }
        bootbox.confirm({
            message: i18n.plugins.delete,
            callback: function (result) {
                bootbox.hideAll();
                if (result !== true) { return; }
                $.get(href, function (response) {
                    toastr.success(response);
                }).done(function () {
                    $("#plugin-" + slug).fadeOut(function () {
                        $(this).remove();
                    });
                }).fail(function (response) {
                    toastr.error(response.responseJSON);
                });
            }
        });
    });

})(window.jQuery || window.Zepto, window, document);
