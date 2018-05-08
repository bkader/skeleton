/*!
 * CodeIgniter Skeleton - Media Module (https://goo.gl/wGXHO9/skeleton)
 * Copyright 2018 Kader Bouyakoub (https://goo.gl/wGXHO9)
 * Licensed under MIT (https://goo.gl/wGXHO9/skeleton/blob/develop/LICENSE.md)
 */
(function ($, window, document, undefined) {
    "use strict";

    // Prepare globals.
    var csk = window.csk = window.csk || {};
    csk.i18n = csk.i18n || {};
    csk.i18n.themes = csk.i18n.themes || {};

    /**
     * Themes object.
     * Handle all operations done on themes module.
     * @since   1.4.0
     */
    csk.themes = {

        // To avoid repeating, we gather all action in one.
        _do: function (el, action) {
            var $this = $(el),
                href = $this.attr("href"),
                theme = $this.attr("data-theme");

            if (!href.length || !theme.length) {
                return false;
            }

            var action_raw = (action === -1) ? $action : action + "_theme_" + theme;

            return csk.ui.confirm(csk.i18n.themes[action], function () {
                csk.ajax.request(href, {
                    type: "POST",
                    data: {
                        action: action_raw
                    },
                    complete: function () {
                        // We remove the item in delete action.
                        if (action === "delete") {
                            $("#theme-" + theme).fadeOut(function () {
                                $(this).remove();
                            });
                        }

                        // Reload page content.
                        $("#wrapper").load(csk.config.adminURL + "/themes  #wrapper > *");

                        /*
                         * We always make sure to hide the theme modal 
                         * in case it was show.
                         * This will trigger the hidden.bs.modal event, so
                         * it will automatically push the URL.
                         */
                        $("#theme-modal").modal("hide");
                    }
                });
            });
        },

        // Main function: activate or delete.
        activate: function (el) {
            return this._do(el, "activate")
        },
        delete: function (el) {
            return this._do(el, "delete")
        },

        // Retrieve theme's details.
        details: function (el) {
            var $this = $(el),
                href = $this.attr("data-href"),
                url = $this.attr("href"),
                theme = $this.attr("data-theme");

            if (!href.length || !theme.length) {
                return false;
            }

            // Compile Handlebars modal template
            var modalSource = document.getElementById("theme-details-modal").innerHTML;
            var modalTemplate = Handlebars.compile(modalSource);
            csk.ajax.request(href, {
                success: function (response) {
                    var _modal = modalTemplate(response.results);
                    $("#wrapper").append(_modal);
                    $("#theme-modal").modal("show");
                    window.history.pushState({
                        href: url
                    }, "", url);
                }
            });
        },
    };

    $(document).ready(function () {
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
            window.history.pushState({
                href: csk.config.adminURL + "/themes"
            }, "", csk.config.adminURL + "/themes");
            $(this).remove();
        });
    });

})(window.jQuery || window.Zepto, window, document);
