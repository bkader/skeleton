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

    /**
     * Activities Object.
     * Handles all operations done on activities module.
     * @since   1.4.0
     */
    csk.activities = {

        // Delete the targeted activity.
        delete: function (el) {
            var that = $(el),
                href = that.attr("ajaxify"),
                id = that.data("activity-id");

            // We cannot proceed if the URL is not provided.
            if (!href.length) {
                return false;
            }
            
            var logCount = $(".activity-log").children(".activity-item").length;

            return csk.ui.confirm(csk.i18n.activities.delete, function () {
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
                                $("#wrapper").load(csk.config.currentURL + " #wrapper > *");
                            });
                        }
                    }
                });
            })
        }
    };

    $(document).ready(function () {
        $(document).on("click", ".activity-delete", function (e) {
            e.preventDefault();
            return csk.activities.delete(this);
        });
    });

})(window.jQuery || window.Zepto, window, document);
