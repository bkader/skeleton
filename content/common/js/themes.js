/*!
 * CodeIgniter Skeleton - Media Module (https://github.com/bkader/skeleton)
 * Copyright 2018 Kader Bouyakoub (https://goo.gl/wGXHO9)
 * Licensed under MIT (https://github.com/bkader/skeleton/blob/develop/LICENSE.md)
 */
(function ($, window, document, undefined) {
    "use strict";

    // Prepare globals.
    var csk = window.csk = window.csk || {};
    csk.i18n = csk.i18n || {};
    csk.themes = csk.themes || {};
    csk.i18n.themes = csk.i18n.themes || {};
    var themesURL = csk.config.currentURL,
        themeModalContainer = "#theme-details",
        themeModal = "#theme-modal";

    /**
     * Skeleton Themes - Activation/Deletion handler.
     * @since   2.1.1
     */
    csk.themes.proceed = function(el, action) {
        var $this = $(el),
            href = $this.attr("href"),
            parent = $this.closest(".theme-item"),
            name = parent.data("name") || "this",
            action = action || -1;

        /** If no URL is provided, nothing to do... */
        if (typeof href === "undefined" || !href.length) {
            return false;
        }

        /** Add opacity to siblings */
        parent.siblings().addClass("op-2");

        /** We define the confirmation message. */
        var message = csk.i18n.themes[action] || undefined;
        if (typeof message === "undefined") {
            message = csk.i18n.default[action] || undefined;
            if (typeof message === "undefined") {
                message = "Are you sure you to " + action + " %s?";
            }
        }

        /** Display confirmation message. */
        csk.ui.confirm($.sprintf(message, name), function () {
            window.location.href = href;
        }, function () {
            /** Make sure to remove opacity class from siblings. */
            parent.siblings().removeClass("op-2");
        });
    };

    /**
     * Skeleton Themes - Theme details handler.
     * @since   2.1.1
     */
    csk.themes.details = function (el) {
        var $this = $(el), href = $this.attr("href");

        /** If no URL is provided, nothing to do. */
        if (typeof href === "undefined" || !href.length) {
            return false;
        }

        $(themeModalContainer).load(href + " " + themeModalContainer + " > *", function () {
            window.history.pushState({href: href}, "", href);
            $(themeModal).modal("show");
        });
    };

    $(document).ready(function () {
        /** Remove get parameters from URL. */
        if (themesURL.indexOf("?") > 0) {
            themesURL = themesURL.substring(0, themesURL.indexOf("?"));
        }

        /** Put back URL when modal is closed. */
        $(document).on("hidden.bs.modal", themeModal, function (e) {
            window.history.pushState({href: themesURL}, "", themesURL);
            $(this).remove();
        });

        /** Display theme's details. */
        $(document).on("click", ".theme-details", function (e) {
            e.preventDefault();
            return csk.themes.details(this);
        });

        /** Activate theme. */
        $(document).on("click", ".theme-activate", function (e) {
            e.preventDefault();
            return csk.themes.proceed(this, "activate");
        });

        /** Delete theme. */
        $(document).on("click", ".theme-delete", function (e) {
            e.preventDefault();
            return csk.themes.proceed(this, "delete");
        });
    });

})(window.jQuery || window.Zepto, window, document);
