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
            var that = $(el),
                href = that.attr("href"),
                id = that.parents("tr").data("id");

            // We cannot proceed if the URL is not provided.
            if (!href.length) {
                return false;
            }
            
            var logCount = $("#reports-list").children(".report-item").length;

            return csk.ui.confirm(csk.i18n.reports.delete, function () {
                var data = {action: "delete-report_" + id};
                csk.ajax.request(href, {
                    type: "POST",
                    data: data,
                    complete: function (jqXHR, textStatus) {
                        if (textStatus === "success") {
                            logCount--;
                            if (logCount <= 0) {
                                window.location.href = reportsURL;
                            } else {
                                $("#report-" + id).animate({opacity: 0}, function () {
                                    $("#wrapper").load(csk.config.currentURL + " #wrapper > *");
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
