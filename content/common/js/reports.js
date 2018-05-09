/*!
 * CodeIgniter Skeleton - Reports Module (https://github.com/bkader/skeleton)
 * Copyright 2018 Kader Bouyakoub (https://goo.gl/wGXHO9)
 * Licensed under MIT (https://github.com/bkader/skeleton/blob/develop/LICENSE.md)
 */
(function ($, window, document, undefined) {
    "use strict";

    // Prepare globals.
    var csk = window.csk = window.csk || {},
        reportsURL = csk.config.currentURL;
    csk.i18n = csk.i18n || {};
    csk.i18n.reports = csk.i18n.reports || {};

    /**
     * Activities Object.
     * Handles all operations done on reports module.
     * @since   1.4.0
     */
    csk.reports = {

        // Delete the targeted report.
        delete: function (el) {
            var $this = $(el),
                href = $this.data("endpoint"),
                row = $this.closest("tr"),
                id = row.data("id");

            // We cannot proceed if the URL is not provided.
            if (typeof href === "undefined" || !href.length) {
                return false;
            }
            
            // Keep the count to see if we shall refresh page.
            var logCount = $("#reports-list").children(".report-item").length;

            return csk.ui.confirm(csk.i18n.reports.delete, function () {
                var data = {action: "delete-report_" + id};
                csk.ajax.request(href, {
                    type: "POST",
                    data: {action: "delete-report_" + id},
                    complete: function (jqXHR, textStatus) {
                        if (textStatus === "success") {
                            logCount--;
                            if (logCount <= 0) {
                                window.location.href = reportsURL;
                            } else {
                                row.animate({opacity: 0}, function () {
                                    csk.ui.reload();
                                });
                            }
                        }
                    }
                });
            })
        }
    };

    $(document).ready(function () {
        // Remove get parameters.
        if (reportsURL.indexOf("?") > 0) {
            reportsURL = reportsURL.substring(0, reportsURL.indexOf("?"));
        }

        // Delete report.
        $(document).on("click", ".report-delete", function (e) {
            e.preventDefault();
            return csk.reports.delete(this);
        });
    });

})(window.jQuery || window.Zepto, window, document);
