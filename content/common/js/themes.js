/*!
 * CodeIgniter Skeleton - Media Module (https://github.com/bkader/skeleton)
 * Copyright 2018 Kader Bouyakoub (https://goo.gl/wGXHO9)
 * Licensed under MIT (https://github.com/bkader/skeleton/blob/develop/LICENSE.md)
 */
(function ($, window, document, undefined) {
    "use strict";

    // Prepare globals.
    var csk = window.csk = window.csk || {},
        themesURL = csk.config.currentURL;
    csk.i18n = csk.i18n || {};
    csk.i18n.themes = csk.i18n.themes || {};

    /**
     * Themes object.
     * Handle all operations done on themes module.
     * @since   1.4.0
     */
    csk.themes = {

        // Retrieve theme's details.
        details: function (el) {
            var $this = $(el),
                href = $this.attr("href"),
                endpoint = $this.data("endpoint"),
                row = $this.parents(".theme-item"),
                theme = row.data("theme"),
                id = row.attr("id"),
                action = action || -1;

            if (!endpoint.length || !theme.length) {
                return false;
            }

            // Compile Handlebars modal template
            csk.ajax.request(endpoint, {
                type: "POST",
                data: {action: "details-theme_" + theme},
                complete: function (jqXHR, textStatus) {
                    if (textStatus !== "success") {
                        return false;
                    }
                    var modalSource = document.getElementById("theme-details-modal").innerHTML,
                        modalTemplate = Handlebars.compile(modalSource),
                        response = jqXHR.responseJSON;

                    var _modal = modalTemplate(response.results);
                    $("#wrapper").append(_modal);
                    $("#theme-modal").modal("show");
                    window.history.pushState({href: href}, "", href);
                }
            });
        },

        // Main function: activate or delete.
        activate: function (el) {
            return csk.themes._do(el, "activate")
        },

        delete: function (el) {
            return csk.themes._do(el, "delete")
        },

        // To avoid repeating, we gather all action in one.
        _do: function (el, action) {
            var $this = $(el),
                href = $this.attr("href"),
                endpoint = $this.data("endpoint"),
                row = $this.parents(".theme-item"),
                theme = row.data("theme") || $this.data("theme"),
                id = row.attr("id") || "theme-" + theme,
                action = action || -1,
                themeModal = $("#theme-modal");

            if (!endpoint.length || !theme.length) {
                return false;
            }

            csk.ui.confirm(csk.i18n.themes[action], function () {
                
                // Hide modal first;
                if (themeModal.length) {
                    themeModal.modal("hide");
                }

                // Proceed to AJAX.
                csk.ajax.request(endpoint, {
                    type: "POST",
                    data: {action: action + '-theme_' + theme},
                    complete: function (jqXHR, textStatus) {
                        if (textStatus !== "success") {
                            return false;
                        }

                        if (action === "delete") {
                            $("#" + id).fadeOut(function() {
                                $(this).remove();
                                csk.ui.reload("#wrapper", false);
                            });
                            return;
                        }

                        csk.ui.reload("#wrapper", false);
                    }
                });
            });
        }
    };

    $(document).ready(function () {

        // Remove get parameters from URL.
        if (themesURL.indexOf("?") > 0) {
            themesURL = themesURL.substring(0, themesURL.indexOf("?"));
        }

        // Display theme's details.
        $(document).on("click", ".theme-details", function (e) {
            e.preventDefault();
            return csk.themes.details(this);
        });

        // Activate theme.
        $(document).on("click", ".theme-activate", function (e) {
            e.preventDefault();
            return csk.themes.activate(this);
        });

        // Delete theme.
        $(document).on("click", ".theme-delete", function (e) {
            e.preventDefault();
            return csk.themes.delete(this);
        });

        // Put back URL when modal is closed.
        $(document).on("hidden.bs.modal", "#theme-modal", function (e) {
            window.history.pushState({href: themesURL}, "", themesURL);
            $(this).remove();
        });
    });

})(window.jQuery || window.Zepto, window, document);
