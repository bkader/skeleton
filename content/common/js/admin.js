/*!
 * Skeleton Dashboard - Admin JS (https://goo.gl/wGXHO9/skeleton)
 * Copyright 2018 Kader Bouyakoub (https://goo.gl/wGXHO9)
 * Licensed under MIT (https://goo.gl/wGXHO9/skeleton/blob/develop/LICENSE.md)
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
            var sidebar = $("#csk-sidebar");
            if (sidebar.length) {
                sidebar.toggleClass("open");
            }
        },

        // ---------------------------------------------------
        // Confirmation using BootBox or JavaScript alert.
        // ---------------------------------------------------
        confirm: function (message, trueCallback, falseCallback) {
            if (typeof bootbox !== "undefined") {
                bootbox.confirm({
                    message: message,
                    callback: function (result) {
                        bootbox.hideAll();
                        if (result === true && typeof trueCallback === "function") {
                            trueCallback(true);
                        } else if (typeof falseCallback === "function") {
                            falseCallback(true);
                        }
                    }
                });
            } else if (confirm(message) && typeof trueCallback === "function") {
                trueCallback(true);
            } else if (typeof falseCallback === "function") {
                falseCallback(true);
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

    /**
     * Skeleton AJAX handler.
     * @since   1.4.0
     */
    csk.ajax = {
        /**
         * Array of queued AJAX requests.
         * @type {Array}
         */
        requests: [],

        /**
         * Flag to check whether a request is being processed.
         * @type {Boolean}
         */
        requesting: false,
        
        /**
         * The last context that was set by the request.
         * @type {object}
         */
        context: undefined,

        /**
         * Queues an AJAX request and fires if needed.
         * @param  {string}     url     The URL to send AJAX to.
         * @param  {array}      params  Objec of AJAX settings.
         */
        request: function (url, params) {
            params = params || {};
            var context = params.context || this,
                type = params.type || "GET";

            // Merge parameters with default ones.
            params = $.extend({
                url: url,
                method: type,
                type: type, // Backward compatibility.
                async: true,
                cache: false,
                dataType: "json",
                success: function (data, textStatus, jqXHR) {
                    csk.ajax._response(data);
                }
            }, params);

            this.requests.push(params);
            this._execute();
        },

        // Stops AJAX requests and dequeue them all.
        stop: function () {
            this.requests = [];
        },

        /**
         * Handles the queue an run AJAX requests.
         */
        _execute: function () {
            if (this.requests.length == 0) {
                return;
            }
            if (this.requesting == true) {
                return;
            }

            var request = this.requests.splice(0, 1)[0],
                complete = request.complete;

            var self = this;

            if (request._execute) {
                request._execute(request);
            }

            request.complete = function () {
                if (complete) {
                    complete.apply(this, arguments);
                }
                self.requesting = false;
                self._execute();
            }

            this.requesting = true;
            $.ajax(request);
        },

        /**
         * Handle JSON data response sent by csk.ajax.request
         * @param  {strng} data Normally, it should be a JSON encoded response.
         */
        _response: function (data) {
            var data = data || {}, context = this;

            // Cache the used element.
            csk.ajax.context = context;

            // Did we receive a message?
            if (typeof data.message !== "undefined" && data.message.length) {
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
                    (new Function(data.scripts[i])).call(context);
                } catch(e) {
                    console.log(e);
                }
            }
        }
    };

    $(document).ready(function () {

        // Toastr Configuration.
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

        // Check all feature.
        $(document).on("change", ":checkbox[name=check-all]", function () {
            var that = $(this);
            that
                .closest("table")
                .find("tbody :checkbox")
                .prop("checked", this.checked)
                .closest("tr").toggleClass("selected", this.checked);
        });

        //Sidebar toggle.
        $(document).on("click", ".sidebar-toggle", function (e) {
            return csk.ui.toggleSidebar(e);
        });

        // Bootstrap tooltip and popover.
        if (typeof $.fn.tooltip !== "undefined") {
            $("[data-toggle=tooltip], [rel=tooltip]").tooltip();
        }
        if (typeof $.fn.popover !== "undefined") {
            $("[data-toggle=popover], [rel=popover]").popover();
        }

        // Avoid multiple form submission.
        $(document).on("submit", "form", function (e) {
            var $form = $(this);
            $form.find("[type=submit]").prop("disabled", true).addClass("disabled");
            
            $form.submit(function () {
                return false;
            });

            return true;
        });

        // Make form inputs keep values even after refresh.
        if (typeof $.fn.garlic !== "undefined") {
            $("[rel=persist]").garlic();
        }

        // AJAXify anchors with rel attributes.
        $(document).on("click", "a[rel]", function (e) {
            var $this = $(this), rel = $this.attr("rel"), href = $this.attr("href");

            if (typeof href === "undefined") {
                e.preventDefault();
                return;
            }

            switch (rel) {
                case "async":
                case "async-post":
                    e.preventDefault();
                    var type = (rel === "async") ? "GET" : "POST";
                    csk.ajax.request(href, {
                        el: this,
                        type: type,
                        beforeSend: function () {
                            if ($this.prop("disabled")) {
                                return;
                            }

                            // We disable the element before proceeding.
                            $this.prop("disabled", true).addClass("disabled");
                        },
                        complete: function () {
                            // We enable back the element.
                            $this.prop("disabled", false).removeClass("disabled");
                        }
                    });
                    return false;
                    break;
            }
        });

        // AJAXify forms with rel attributes.
        $(document).on("submit", "form[rel]", function (e) {
            var $this = $(this), rel = $this.attr("rel"), href = $this.attr("action");

            if (typeof href === "undefined") {
                e.preventDefault();
                return;
            }

            switch (rel) {
                case "async":
                    e.preventDefault();
                    csk.ajax.request(href, {
                        el: this,
                        type: "POST",
                        data: $this.serializeArray(),
                        beforeSend: function () {
                            if ($this.prop("disabled")) {
                                return;
                            }

                            $this
                                .find("[type=submit]")
                                .prop("disabled", true)
                                .addClass("disabled");
                        },
                        complete: function () {
                            $this
                                .find("[type=submit]")
                                .prop("disabled", false)
                                .removeClass("disabled");
                        }
                    });
                    return false;
                    break;
            }
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

        $(document).on("click", ".plugin-delete", function(e) {
            if (!confirm(csk.i18n.plugins.delete)) {
                e.preventDefault();
                return false;
            }
        });

        // ---------------------------------------------------
        // Hack to make dropdown buttons possible inside responsive
        // tables without being hidden by table hidden overflow.
        // If dropdowns are closed, we return the table to it
        // initial status.
        // ---------------------------------------------------
        $(document).on("show.bs.dropdown", ".table-responsive", function () {
            $(this).css("overflow", "inherit");
        }).on("hide.bs.dropdown", ".table-responsive", function () {
            $(this).css("overflow", "auto");
        });

    });

})(window.jQuery || window.Zepto, window, document);
