/*!
 * CodeIgniter Skeleton - Activities Module (https://github.com/bkader/skeleton)
 * Copyright 2018 Kader Bouyakoub (https://github.com/bkader)
 * Licensed under MIT (https://github.com/bkader/skeleton/blob/develop/LICENSE.md)
 */
(function ($, window, document, undefined) {
    "use strict";

    // Prepare globals.
    var csk = window.csk = window.csk || {};
    csk.i18n = csk.i18n || {};
    csk.i18n.activities = csk.i18n.activities || {};

    // =======================================================
    // Activities object.
    // =======================================================
    csk.activities = {

        // ---------------------------------------------------
        // Delete a single activity.
        // ---------------------------------------------------
        delete: function (el) {
            var that = $(el),
                href = that.attr("ajaxify"),
                id = that.data("activity-id");

            if (!href.length) { return; }
            var message = csk.i18n.activities.delete || "Are you sure you want to delete this activity?",
                logCount = $(".activity-log").children(".activity-item").length;
            return csk.ui.confirm(message, function () {
                var data = {action: 'delete_activity_' + id}, _html = that.html();
                csk.ajax.request(href, {
                    type: "POST",
                    data: data,
                    complete: function () {
                        logCount--;
                        if (logCount <= 0) {
                            window.location.href = csk.config.adminURL + "/activities";
                        } else {
                            $("#activity-" + id).animate({opacity: 0}, function () {
                                // $("#wrapper").load(csk.config.currentURL + " #wrapper > *");
                            });
                        }
                    }
                });
            })
        }
    };

    // =======================================================
    // Only when the DOM is ready.
    // =======================================================
    $(document).ready(function () {
        $(document).on("click", ".activity-delete", function (e) {
            e.preventDefault();
            return csk.activities.delete(this);
        });
    });

})(window.jQuery || window.Zepto, window, document);
