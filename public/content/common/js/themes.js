/*!
 * CodeIgniter Skeleton - Media Module (https://github.com/bkader/skeleton)
 * Copyright 2018 Kader Bouyakoub (https://github.com/bkader)
 * Licensed under MIT (https://github.com/bkader/skeleton/blob/develop/LICENSE.md)
 */
(function ($, window, document, undefined) {
    $.noConflict();
    "use strict";

    // ========================================================
    // Theme details.
    // ========================================================
    $(document).on("click", ".theme-details", function (e) {
        e.preventDefault();
        var that = $(this), href = that.attr("href"), themeModal = $("#theme-modal");
        if (!href.length) { return; }
        $.get(href, function (response) {
            // Nothing to do.
        }).done(function () {
            if (themeModal.length) { themeModal.modal("hide"); }
            $("#theme-modal-container").load(href + " #theme-modal-container > *", function () {
                window.history.pushState({href: href}, '', href);
                $("#theme-modal").modal("show");
            });
        }).fail(function (response) {
            toastr.error(response.responseJSON);
        });
    });

    // ========================================================
    // Theme activation.
    // ========================================================
    $(document).on("click", ".theme-activate", function (e) {
        e.preventDefault();
        var that = $(this), href = that.attr("href"), themeModal = $("#theme-modal");
        if (!href.length) { return; }
        bootbox.confirm({
            message: i18n.themes.activate,
            callback: function (result) {
                bootbox.hideAll();
                if (result !== true) { return; }
                $.get(href, function (response) {
                    toastr.success(response);
                }).done(function () {
                    if (themeModal.length) { themeModal.modal("hide"); }
                    $("#wrapper").load(Config.currentURL + " #wrapper > *");
                }).fail(function (response) {
                    toastr.error(response.responseJSON);
                });
            }
        });
    });

    // ========================================================
    // Theme deletion.
    // ========================================================
    $(document).on("click", ".theme-delete", function (e) {
        e.preventDefault();
        var that = $(this),
            href = that.attr("href"),
            theme = that.attr("data-theme"),
            themeModal = $("#theme-modal");
        if (!href.length || !theme.length) { return; }
        bootbox.confirm({
            message: i18n.themes.delete,
            callback: function (result) {
                bootbox.hideAll();
                if (result !== true) { return; }
                $.get(href, function (response) {
                    toastr.success(response);
                }).done(function () {
                    $("#theme-" + theme).fadeOut(function () {
                        if (themeModal.length) { themeModal.modal("hide"); }
                        $(this).remove();
                    });
                }).fail(function (response) {
                    toastr.error(response.responseJSON);
                });
            }
        });
    });

    // ========================================================
    // Put back URL when modal is closed.
    // ========================================================
    $(document).on("hidden.bs.modal", "#theme-modal", function (e) {
        window.history.pushState({href: Config.adminURL + "/themes"}, '', Config.adminURL + "/themes");
        $(this).remove();
    });

})(window.jQuery || window.Zepto, window, document);
