/*!
 * CodeIgniter Skeleton - Plugins Module (https://github.com/bkader/skeleton)
 * Copyright 2018 Kader Bouyakoub (https://github.com/bkader)
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

        _do: function (el, action) {
            var $this = $(el),
                href = $this.attr("href"),
                id = $this.attr("data-plugin"),
                action = action || -1;

            if (!href.length) {
                return false;
            }

            var action_raw = (action === -1) ? action : action + '_plugin_' + id;

            // Delete plugin? Display confirm message.
            if (action === "delete") {
                return csk.ui.confirm(csk.i18n.plugins.delete, function () {
                    csk.ajax.request(href, {
                        type: "POST",
                        data: {action: action_raw},
                        complete: function () {
                            $("#plugin-" + id).fadeOut(function () { $(this).remove(); });
                        }
                    });
                });
            }

            return csk.ajax.request(href, {
                type: "POST",
                data: {action: action_raw},
                complete: function () {
                    switch (action) {

                        // This actions is handled first, but it is kept
                        // here as a backup plan.
                        case "delete":
                            $("#plugin-" + id).fadeOut(function () {
                                $(this).remove();
                            });
                            break;

                        // Same thing to do with activate and deactivate.
                        case "activate":
                        case "deactivate":
                            var rowId = "#plugin-" + id,
                                row = $(rowId);
                            row.load(csk.config.currentURL + " " +  rowId + " > *");
                            break;

                        // The default action would be to reload the page.
                        default:
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                            break;
                    }
                }
            });
        },

        // Default actions: activate, deactivate and delete.
        activate: function (el) { return this._do(el, 'activate'); },
        deactivate: function (el) { return this._do(el, 'deactivate'); },
        delete: function (el) { return this._do(el, 'delete') }
    };

    $(document).ready(function () {
        $(document).on("click", ".plugin-activate", function (e) {
            e.preventDefault();
            return csk.plugins.activate(this)
        });
        
        $(document).on("click", ".plugin-deactivate", function (e) {
            e.preventDefault();
            return csk.plugins.deactivate(this)
        });
        
        $(document).on("click", ".plugin-delete", function (e) {
            e.preventDefault();
            return csk.plugins.delete(this)
        });
    });

})(window.jQuery || window.Zepto, window, document);
