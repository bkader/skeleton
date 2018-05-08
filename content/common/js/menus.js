/*!
 * CodeIgniter Skeleton - Menus Module (https://github.com/bkader/skeleton)
 * Copyright 2018 Kader Bouyakoub (https://goo.gl/wGXHO9)
 * Licensed under MIT (https://github.com/bkader/skeleton/blob/develop/LICENSE.md)
 */
(function ($, window, document, undefined) {
    "use strict";

    // Prepare globals.
    var csk = window.csk = window.csk || {};
    csk.i18n = csk.i18n || {};
    csk.i18n.menus = csk.i18n.menus || {};

    /**
     * Menus Object.
     * Handles all operations done on menus module.
     * @since   1.4.0
     */
    csk.menus = {
        delete: function (el, type) {
            var $this = $(el),
                href = $this.attr("href");

            if (!href.length || !type.length) {
                return false;
            }

            var id = (type === "menu") ?
                $this.attr("data-menu-id") :
                $this.attr("data-item-id");

            return csk.ui.confirm(csk.i18n.menus["delete_" + type], function () {
                csk.ajax.request(href, {
                    type: "POST",
                    data: {
                        action: "delete_" + type + "_" + id
                    },
                    complete: function (response) {
                        var target = (type === "menu") ? "menu-" : "menu-item-";
                        $("#" + target + id).fadeOut(function () {
                            $(this).remove();
                        });
                    }
                })
            });
        }
    };

    $(document).ready(function () {
        // Delete menu.
        $(document).on("click", ".menu-delete", function (e) {
            e.preventDefault();
            return csk.menus.delete(this, "menu");
        });

        // Delete item.
        $(document).on("click", ".item-delete", function (e) {
            e.preventDefault();
            return csk.menus.delete(this, "item");
        });

        // Menu items order.
        var itemsList = $("#menu-order");
        if (itemsList.length && typeof $.fn.sortable !== "undefined") {
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
