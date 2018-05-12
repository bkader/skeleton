/*!
 * CodeIgniter Skeleton - Modules (https://github.com/bkader/skeleton)
 * Copyright 2018 Kader Bouyakoub (https://goo.gl/wGXHO9)
 * Licensed under MIT (https://github.com/bkader/skeleton/blob/develop/LICENSE.md)
 */
(function ($, window, document, undefined) {
    "use strict";

    // Prepare globals.
    var csk = window.csk = window.csk || {};
    csk.i18n = csk.i18n || {};
    csk.i18n.modules = csk.i18n.modules || {};

    /**
     * Skeleton Modules.
     * @since   2.0.0
     */
    csk.modules = {
        
        // Activate module.
        activate: function (el) {
            return csk.modules._do(el, "activate");
        },

        // Deactivate module.
        deactivate: function (el) {
            return csk.modules._do(el, "deactivate");
        },

        // Delete module.
        delete: function (el) {
            return csk.modules._do(el, "delete");
        },

        // Actions handler.
        _do: function (el, action) {
            var $this = $(el),
                href = $this.data("endpoint"),
                row = $this.closest("tr"),
                module = row.data("module"),
                name = row.data("name") || 'this',
                id = row.attr("id"),
                action = action || -1;

            // No URL provided? Nothing to do..
            if (typeof href === "undefined" || !href.length) {
                return false;
            }

            csk.ui.confirm($.sprintf(csk.i18n.modules[action], name), function () {
                csk.ajax.request(href, {
                    type: "POST",
                    data: {action: action + "-module_" + module},
                    complete: function (jqXHR, textStatus) {
                        if (textStatus !== "success") {
                            return;
                        }

                        // Delete action.
                        if (action === "delete") {
                            row.fadeOut(function () {
                                $(this).remove();
                                csk.ui.reload();
                            });
                            return;
                        }
                        
                        csk.ui.reload();
                    }
                });
            });
        }
    };

    $(document).ready(function() {
        // Activate module.
        $(document).on("click", ".module-activate", function(e) {
            e.preventDefault();
            return csk.modules.activate(this);
        });

        // Deactivate module.
        $(document).on("click", ".module-deactivate", function(e) {
            e.preventDefault();
            return csk.modules.deactivate(this);
        });

        // Delete module.
        $(document).on("click", ".module-delete", function(e) {
            e.preventDefault();
            return csk.modules.delete(this);
        });
    });

})(window.jQuery || window.Zepto, window, document);
