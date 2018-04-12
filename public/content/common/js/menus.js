/*!
 * CodeIgniter Skeleton - Menus Module (https://github.com/bkader/skeleton)
 * Copyright 2018 Kader Bouyakoub (https://github.com/bkader)
 * Licensed under MIT (https://github.com/bkader/skeleton/blob/develop/LICENSE.md)
 */
(function($, window, document, undefined) {

    $.noConflict();
    "use strict";

    // ========================================================
    // Delete menu action.
    // ========================================================
    $(document).on("click", ".menu-delete", function (e) {
        e.preventDefault();
        var that = $(this), href = that.attr("href"), id = that.attr("data-menu-id");
        if (!href.length) { return; }
        bootbox.confirm({
            message: i18n.menus.delete_menu,
            callback: function (result) {
                bootbox.hideAll();
                if (result !== true) { return; }
                $.get(href, function (response) {
                    toastr.success(response);
                }).done(function () {
                    $("#menu-" + id).fadeOut(function () {
                        $(this).remove();
                    });
                }).fail(function (response) {
                    toastr.error(response.responseJSON);
                });
            }
        });
        return Kbcore.menus.delete_menu(this);
    });

    // ========================================================
    // Delete menu item action.
    // ========================================================
    $(document).on("click", ".item-delete", function (e) {
        e.preventDefault();
        var that = $(this), href = that.attr("href"), id = that.attr("data-item-id");
        if (!href.length) { return; }
        bootbox.confirm({
            message: i18n.menus.delete_item,
            callback: function (result) {
                bootbox.hideAll();
                if (result !== true) { return; }
                $.get(href, function (response) {
                    toastr.success(response);
                }).done(function () {
                    $("#menu-item-" + id).slideUp(function () {
                        $(this).remove();
                    });
                }).fail(function (response) {
                    toastr.error(response.responseJSON);
                });
            }
        });
    });

    // ========================================================
    // When DOM is ready.
    // ========================================================
    $(document).ready(function () {
        var itemsList = $("#menu-order");
        if (itemsList.length) {
            $("#menu-order").sortable({
                stop: function (event, ui) {
                    var itemsOrder = $("#menu-order").sortable('toArray');
                    for (var i = 0; i < itemsOrder.length; i++) {
                        $("#order-" + itemsOrder[i]).val(i);
                    }
                }
            });
        }
    });

})(window.jQuery || window.Zepto, window, document);
