/*!
 * Skeleton Media - v1.3.3 (https://github.com/bkader/skeleton)
 * Copyright 2018 Kader Bouyakoub (https://github.com/bkader)
 * Licensed under MIT (https://github.com/bkader/skeleton/blob/develop/LICENSE.md)
 */
(function ($, undefined) {

    jQuery.noConflict();
    "use strict";

    /*! Enable language. */
    jQuery(document).on("click", ".lang-enable", function (e) {
        e.preventDefault();
        var href = jQuery(this).attr("data-href");
        if (href.length) {
            jQuery.get(href, function (response, textStatus) {
                if (textStatus == "success") {
                    toastr.success(response);
                    jQuery("#wrapper").load(config.adminURL + "/language #wrapper > *");
                } else {
                    toastr.error(response);
                }
            });
        }
        return false;
    });

    /*! Disable language. */
    jQuery(document).on("click", ".lang-disable", function (e) {
        e.preventDefault();
        var href = jQuery(this).attr("data-href");
        if (href.length) {
            jQuery.get(href, function (response, textStatus) {
                if (textStatus == "success") {
                    toastr.success(response);
                    jQuery("#wrapper").load(config.adminURL + "/language #wrapper > *");
                } else {
                    toastr.error(response);
                }
            });
        }
        return false;
    });

    /*! Set default language. */
    jQuery(document).on("click", ".lang-default", function (e) {
        e.preventDefault();
        var href = jQuery(this).attr("data-href");
        if (href.length) {
            jQuery.get(href, function (response, textStatus) {
                if (textStatus == "success") {
                    toastr.success(response);
                    jQuery("#wrapper").load(config.adminURL + "/language #wrapper > *");
                } else {
                    toastr.error(response);
                }
            });
        }
        return false;
    });

})(jQuery);
