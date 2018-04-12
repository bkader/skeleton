/*!
 * CodeIgniter Skeleton - Language Module (https://github.com/bkader/skeleton)
 * Copyright 2018 Kader Bouyakoub (https://github.com/bkader)
 * Licensed under MIT (https://github.com/bkader/skeleton/blob/develop/LICENSE.md)
 */
(function($, window, document, undefined) {

    $.noConflict();
    "use strict";

    // ========================================================
    // Enabled language.
    // ========================================================
    $(document).on("click", ".lang-enable", function (e) {
        e.preventDefault();
        var href = $(this).attr("href");
        if (!href.length) { return; }
        $.get(href, function (response) {
            toastr.success(response);
        }).done(function () {
            $("#wrapper").load(Config.currentURL + " #wrapper > *");
        }).fail(function (response) {
            toastr.error(response.responseJSON);
        });
    });

    // ========================================================
    // Disable language.
    // ========================================================
    $(document).on("click", ".lang-disable", function (e) {
        e.preventDefault();
        var href = $(this).attr("href");
        if (!href.length) { return; }
        $.get(href, function (response) {
            toastr.success(response);
        }).done(function () {
            $("#wrapper").load(Config.currentURL + " #wrapper > *");
        }).fail(function (response) {
            toastr.error(response.responseJSON);;
        });
    });

    // ========================================================
    // Set default language.
    // ========================================================
    $(document).on("click", ".lang-default", function (e) {
        e.preventDefault();
        var href = $(this).attr("href");
        if (!href.length) { return; }
        $.get(href, function (response) {
            toastr.success(response);
        }).done(function () {
            $("#wrapper").load(Config.currentURL + " #wrapper > *");
        }).fail(function (response) {
            toastr.error(response.responseJSON);
        });
    });

})(window.jQuery || window.Zepto, window, document);
