/*!
 * CodeIgniter Skeleton - Plugins Module (https://github.com/bkader/skeleton)
 * Copyright 2018 Kader Bouyakoub (https://goo.gl/wGXHO9)
 * Licensed under MIT (https://github.com/bkader/skeleton/blob/develop/LICENSE.md)
 */
(function ($, window, document, undefined) {

    // Prepare globals.
    var csk = window.csk = window.csk || {};
    csk.i18n = csk.i18n || {};
    csk.plugins = csk.plugins || {};
    csk.i18n.plugins = csk.i18n.plugins || {};

    /**
     * Skeleton Plugins.
     * @since   2.1.0
     */
    csk.plugins.proceed = function(el, action) {
        var $this = $(el),
            href = $this.data("endpoint"),
            row = $this.closest("tr"),
            name = row.data("name") || 'this',
            action = action || -1;

        if (typeof href === "undefined" || !href.length) {
            return false;
        }

        row.siblings("tr").addClass("op-2");

        csk.ui.confirm($.sprintf(csk.i18n.plugins[action], name), function () {
            window.location.href = href;
        }, function () {
            row.siblings("tr").removeClass("op-2");
        });
    };

    $(document).ready(function() {
        // Activate plugin.
        $(document).on("click", ".plugin-activate", function(e) {
            e.preventDefault();
            return csk.plugins.proceed(this, "activate");
        });

        // Deactivate plugin.
        $(document).on("click", ".plugin-deactivate", function(e) {
            e.preventDefault();
            return csk.plugins.proceed(this, "deactivate");
        });

        // Delete plugin.
        $(document).on("click", ".plugin-delete", function(e) {
            e.preventDefault();
            return csk.plugins.proceed(this, "delete");
        });
    });

})(window.jQuery || window.Zepto, window, document);
