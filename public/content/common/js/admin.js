/*!
 * Skeleton Dashboard - Admin JS (https://github.com/bkader/skeleton)
 * Copyright 2018 Kader Bouyakoub (https://github.com/bkader)
 * Licensed under MIT (https://github.com/bkader/skeleton/blob/develop/LICENSE.md)
 */
(function ($, window, document, undefined) {
    "use strict";

    // Prepare "csk" global.
    var csk = window.csk = window.csk || {};
    csk.i18n = csk.i18n || {};

    // =======================================================
    // BootBox configuration is found.
    // =======================================================
    if (typeof bootbox !== "undefined") {
        bootbox.setDefaults({
            backdrop: false,
            closeButton: false,
            locale: csk.config.lang.code,
            size: "small"
        });
    }

    // =======================================================
    // Skeleton UI module.
    // =======================================================
    csk.ui = {
        
        // ---------------------------------------------------
        // Toggle sidebar action.
        // ---------------------------------------------------
        toggleSidebar: function (event) {
            event.preventDefault();
            event.stopPropagation();
            var sidebar = $("#sidebar");
            if (sidebar.length) {
                sidebar.toggleClass("open");
            }
        },

        // ---------------------------------------------------
        // Confirmation using BootBox or JavaScript alert.
        // ---------------------------------------------------
        confirm: function (message, callback) {
            if (typeof bootbox !== "undefined") {
                bootbox.confirm({
                    message: message,
                    callback: function (result) {
                        bootbox.hideAll();
                        if (result === true && typeof callback === "function") {
                            callback(true);
                        }
                    }
                });
            } else if (confirm(message) && typeof callback === "function") {
                callback(true);
            }
        },

        // Alert (Notification).
        alert: function (message, type) {
            if (typeof toastr === "undefined") {
                alert(message);
                return;
            }

            switch (type) {
                case "success": toastr.success(message); break;
                case "error": toastr.error(message); break;
                case "warning": toastr.warning(message); break;
                case "info": default: toastr.info(message); break;
            }
        }
    };

    // =======================================================
    // Skeleton AJAX Handler.
    // =======================================================
    csk.ajax = {
        
        // ---------------------------------------------------
        // The last context that was set by the request.
        // ---------------------------------------------------
        el: undefined,

        // ---------------------------------------------------
        // Performing AJAX request.
        // ---------------------------------------------------
        request: function (url, params) {
            params = params || {};
            var el = params.el || this,
                type = params.type || "GET";

            // Merge parameters with default ones.
            params = $.extend({
                method: type,
                type: type, // Backward compatibility.
                async: true,
                cache: false,
                dataType: "json",
                success: function (response) {
                    csk.ajax.response(response);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    if (typeof jqXHR.responseJSON.message !== "undefined") {
                        csk.ui.alert(jqXHR.responseJSON.message, "error");
                    }
                }
            }, params);

            // Perform the request.
            $.ajax(url, params);
        },

        // ---------------------------------------------------
        // Handle JSON data response sent by csk.ajax.request
        // ---------------------------------------------------
        response: function (data) {
            var data = data || {}, el = this;

            // Cache the used element.
            csk.ajax.el = el;

            // Did we receive a message?
            if (typeof data.message !== "undefined") {
                csk.ui.alert(data.message, "success");
            }

            // No scripts passed? Nothing to do.
            if (typeof data.scripts === "undefined") {
                return;
            }

            // Perform receive scripts.
            var _scripts = data.scripts.length;
            for (var i = 0; i < _scripts; i++) {
                try {
                    (new Function(data.scripts[i])).call(el);
                } catch(e) {
                    console.log(e);
                }
            }
        }
    };

    // =======================================================
    // To when DOM is ready.
    // =======================================================
    $(document).ready(function () {

        // ---------------------------------------------------
        // Toastr Configuration.
        // ---------------------------------------------------
        if (typeof toastr !== "undefined") {
            toastr.options = {
                "closeButton": true,
                "positionClass": "toast-top-center",
                "hideDuration": "300",
                "timeOut": "3500",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            // Right-to-left language?
            if (csk.config.lang.direction === 'rtl') {
                toastr.options.rtl = true;
            }
        }

        // ---------------------------------------------------
        // Sidebar toggle.
        // ---------------------------------------------------
        $(".sidebar-toggle").on("click", function (e) {
            return csk.ui.toggleSidebar(e);
        });

        // ---------------------------------------------------
        // Bootstrap tooltip and popover.
        // ---------------------------------------------------
        if (typeof $.fn.tooltip !== "undefined") {
            $("[data-toggle=tooltip], [rel=tooltip]").tooltip();
        }
        if (typeof $.fn.popover !== "undefined") {
            $("[data-toggle=popover], [rel=popover]").popover();
        }

        // ---------------------------------------------------
        // AJAXify anchors with rel attributes.
        // ---------------------------------------------------
        $(document).on("click", "a[rel]", function (e) {
            var $this = $(this), rel = $this.attr("rel"), href = $this.attr("ajaxify");

            if (typeof href === "undefined") {
                e.preventDefault();
                return;
            }

            switch (rel) {
                case "async":
                case "async-post":
                    var type = (rel === "async") ? "GET" : "POST";
                    csk.ajax.request(href, {
                        el: this,
                        type: type,
                        beforeSend: function () {
                            if ($this.data("disabled")) {
                                return;
                            }

                            // We disable the element before proceeding.
                            $this.attr("disabled", true).addClass("disabled");
                        },
                        complete: function () {
                            // We enable back the element.
                            $this.attr("disabled", false).removeClass("disabled");
                        }
                    }, (rel === "async-post") ? "POST" : "GET");
                    break;
            }

            return false;
        });

        // ---------------------------------------------------
        // AJAXify forms with rel attributes.
        // ---------------------------------------------------
        $(document).on("submit", "form[rel]", function (e) {
            var $this = $(this), rel = $this.attr("rel"), href = $this.attr("action");

            if (typeof href === "undefined") {
                e.preventDefault();
                return;
            }

            switch (rel) {
                case "async":
                    csk.ajax.request(href, {
                        el: this,
                        data: $this.serializeArray(),
                        beforeSend: function () {
                            if ($this.data("disabled")) {
                                return;
                            }

                            // We disable the form and its buttons.
                            $this.data("disable", true);
                            $this.find("[type=submit]").addClass("disabled");
                        },
                        complete: function () {
                            $this.data("disabled", false);
                            $this.find("[type=submit]").removeClass("disabled");
                        }
                    }, "POST");
                    break;
            }
            e.preventDefault();
        });
        
        // ---------------------------------------------------
        // If there is a modal, we make sure to show it.
        // if hidden, we make sure to completely remove it.
        // ---------------------------------------------------
        if (typeof $.fn.modal !== "undefined") {
            var bsModal = $(".modal");
            if (bsModal.length) { bsModal.modal("show"); }
            $(document).on("hidden.bs.modal", ".modal", function (e) {
                $(this).remove();
            });
        }
        
        // ---------------------------------------------------
        // Links and buttons with confirmation message.
        // ---------------------------------------------------
        $(document).on("click", "[data-confirm]", function (e) {
            e.preventDefault();
            var that = $(this), href = that.attr("href"), message = that.attr("data-confirm");
            if (csk.ui.confirm(message)) {
                window.location.href = href;
            }
            return false;
        });
        
        // ---------------------------------------------------
        // Make sure to automatically hide dismissable alerts.
        // ---------------------------------------------------
        var bsDismissAlert = $(".alert-dismissable");
        if (bsDismissAlert.length) {
            $(".alert-dismissable")
                .fadeTo(3000, 500)
                .slideUp(500, function () {
                    $(this).alert("close");
                });
        }

        // ---------------------------------------------------
        // Hack to make dropdown buttons possible inside responsive
        // tables without being hidden by table hidden overflow.
        // If dropdowns are closed, we return the table to it
        // initial status.
        // ---------------------------------------------------
        $(".table-responsive").on("show.bs.dropdown", function () {
            $(this).css("overflow", "inherit");
        }).on("hide.bs.dropdown", function () {
            $(this).css("overflow", "auto");
        });

    });

})(window.jQuery || window.Zepto, window, document);
