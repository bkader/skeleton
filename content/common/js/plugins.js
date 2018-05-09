/*!
 * CodeIgniter Skeleton - Plugins Module (https://github.com/bkader/skeleton)
 * Copyright 2018 Kader Bouyakoub (https://goo.gl/wGXHO9)
 * Licensed under MIT (https://github.com/bkader/skeleton/blob/develop/LICENSE.md)
 */
(function ($, window, document, undefined) {

    // Prepare globals.
    var csk = window.csk = window.csk || {};
    csk.i18n = csk.i18n || {};
    csk.i18n.plugins = csk.i18n.plugins || {};

    /**
     * Plugins Object
     * Handles all operations done on plugins module.
     * @since   1.3.x
     */
    csk.plugins = {
        
        // Activate plugin.
        activate: function (el) {
            return this._do(el, "activate");
        },

        // Deactivate plugin.
        deactivate: function (el) {
            return this._do(el, "deactivate");
        },

        // Delete plugin.
        delete: function (el) {
            return this._do(el, "delete")
        },

        // Actions handler.
        _do: function (el, action) {
            var $this = $(el),
                href = $this.data("endpoint"),
                row = $this.closest("tr"),
                plugin = row.data("plugin"),
                name = row.data("name"),
                id = row.attr("id"),
                action = action || -1;

            // No URL provided? Nothing to do...
            if (typeof href === "undefined" || !href.length) {
                return false;
            }

            csk.ui.confirm(csk.i18n.plugins.delete, function () {
                csk.ajax.request(href, {
                    type: "POST",
                    data: {action: action + "-plugin_" + plugin},
                    complete: function (jqXHR, textStatus) {
                        if (textStatus !== "success") {
                            return;
                        }

                        // we reload UI if not in delete action.
                        if (action !== "delete") {
                            csk.ui.reload("#" + id);
                            return;
                        }

                        // Remove the row then reload UI.
                        row.fadeOut(function () {
                            $(this).remove();
                            csk.ui.reload();
                        });
                    }
                });
            });
        }
    };

    $(document).ready(function () {
        // Activate plugin.
        $(document).on("click", ".plugin-activate", function (e) {
            e.preventDefault();
            return csk.plugins.activate(this)
        });
        
        // Deactivate plugin.
        $(document).on("click", ".plugin-deactivate", function (e) {
            e.preventDefault();
            return csk.plugins.deactivate(this)
        });
        
        // Delete plugin.
        $(document).on("click", ".plugin-delete", function (e) {
            e.preventDefault();
            return csk.plugins.delete(this)
        });
    });

})(window.jQuery || window.Zepto, window, document);
