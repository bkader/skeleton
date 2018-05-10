/*!
 * Skeleton Dashboard - Admin JS (https://github.com/bkader/skeleton)
 * Copyright 2018 Kader Bouyakoub (https://goo.gl/wGXHO9)
 * Licensed under MIT (https://github.com/bkader/skeleton/blob/develop/LICENSE.md)
 */
(function ($, window, document, undefined) {
    "use strict";

    // Prepare Skeleton globals.
    var csk = window.csk = window.csk || {};
    csk.i18n = csk.i18n || {};

    /**
     * BootBox default configuration.
     * @since   1.2.0
     */
    if (typeof bootbox !== "undefined") {
        bootbox.setDefaults({
            backdrop: false,
            closeButton: false,
            locale: csk.config.lang.code,
            size: "small"
        });
    }

    /**
     * Skeleton UI module.
     * @since   1.2.0
     */
    csk.ui = {
        /**
         * Confirmation alert using either bootbox or default alert.
         * @since   1.2.0
         * @param   string  message
         * @param   trueCallback    The callback to use once confirmed.
         * @param   falseCallback    The callback to use once canceled.
         * @return  void
         */
        confirm: function (message, trueCallback, falseCallback) {
            if (typeof bootbox !== "undefined") {
                bootbox.confirm({
                    message: message,
                    buttons: {
                        confirm: {className: "btn btn-primary btn-sm"},
                        cancel: {className: "btn btn-default btn-sm"}
                    },
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
            
            if (!message.length) {
                return false;
            }

            type = type || 'info';
            if (type === "error") {
                type = "danger";
            }

            // If toastr is avaiable, we use it.
            if (typeof toastr !== "undefined") {
                switch (type) {
                    case "success":
                        toastr.success(message);
                        break;
                    case "error":
                    case "danger":
                        toastr.error(message);
                        break;
                    case "warning":
                        toastr.warning(message);
                        break;
                    case "info":
                    default:
                        toastr.info(message);
                        break;
                }
                return;
            }

            /**
             * If Handlebars is loaded, we already have an alert template
             * stored within the dashboard default layout. So we use it.
             */
            if (typeof Handlebars === "object") {
                // We store any old alert so we can remove it later.
                var oldAlert = $("#csk-alert"),
                    alertSource = document.getElementById("csk-alert-template").innerHTML,
                    alertTemplate = Handlebars.compile(alertSource);
                
                // Compile the alert.
                var alertCompiled = alertTemplate({message: message, type: type});

                // If we have an old alert, remove it first.
                if (oldAlert.length) {
                    oldAlert.fadeOut(function() {
                        $(this).remove();
                        $(alertCompiled).prependTo("#wrapper > .container");
                    });
                } else {
                    $(alertCompiled).prependTo("#wrapper > .container");
                }

                // Stop the script.
                return;
            }

            /**
             * Otherwise, we make sure to strip any HTML tags from the message
             * and simply use browser's default alert.
             */
            alert(message.replace(/(<([^>]+)>)/ig,""));

        },

        // Reload main page parts.
        reload: function(el, navbar) {
            
            // Shall we reload the admin navbar?
            navbar = navbar || true;

            // If no element is provided, we use "#wrapper".
            el = el || "#wrapper";

            if (navbar === true) {
                $("#navbar-admin").load(csk.config.currentURL + " #navbar-admin > *");
            }
            if (el.length) {
                $(el).load(csk.config.currentURL + " " + el + " > *");
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
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    var response = jqXHR.responseJSON || undefined;
                    if (typeof response !== "undefined" 
                        && response.message !== "undefined" 
                        && response.message.length) {
                        csk.ui.alert(response.message, "error");
                    }
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

        /**
         * Toatr default configuration.
         * @since   1.2.0
         */
        if (typeof toastr !== "undefined") {
            toastr.options = {
                "closeButton": true,
                "positionClass": "toast-top-center",
                "hideDuration": "300",
                "timeOut": "2500",
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

        /**
         * Check all feature.
         * @since   2.0.0
         */
        $(document).on("change", ":checkbox[name=check-all]", function () {
            var that = $(this);
            that
                .closest("table")
                .find("tbody :checkbox")
                .prop("checked", this.checked)
                .closest("tr").toggleClass("selected", this.checked);
        });
        $(document).on("change", ":checkbox.check-this", function () {
            $(this).parents("tr").toggleClass("selected", this.checked);
        });

        // Bootstrap tooltip and popover.
        if (typeof $.fn.tooltip !== "undefined") {
            $("[data-toggle=tooltip], [rel=tooltip]").tooltip();
        }
        if (typeof $.fn.popover !== "undefined") {
            $("[data-toggle=popover], [rel=popover]").popover();
        }

        /**
         * To avoid multiple form submission, we make sure to 
         * disable submit buttons once hit.
         * @since   1.2.0
         */
        $(document).on("submit", "form", function (e) {
            var $form = $(this);
            $form
                .find("[type=submit]")
                .prop("disabled", true)
                .addClass("disabled");
            
            // Disable the submit event.
            $form.submit(function () {
                return false;
            });

            return true;
        });

        // Make form inputs keep values even after refresh.
        if (typeof $.fn.garlic !== "undefined") {
            $("[rel=persist]").garlic();
        }

        /**
         * AJAXify anchors with attribute rel="async".
         * @since   1.3.3
         */
        $(document).on("click", "a[rel]", function (e) {
            var $this = $(this),
                rel = $this.attr("rel"),
                href = $this.attr("href");

            if (typeof href === "undefined" || !href.length) {
                e.preventDefault();
                return false;
            }

            // Not valid rel attribute? Proceed by default.
            if (!rel.length || rel !== "async" || rel !== "async-post") {
                return;
            }

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
        });

        /**
         * We ajaxify forms with attribute rel="async".
         * @since   1.3.0
         */
        $(document).on("submit", "form[rel]", function (e) {
            var $this = $(this),
                rel = $this.attr("rel"),
                href = $this.attr("action");

            // No action provided? Nothing to do...
            if (typeof href === "undefined" || !href.length) {
                e.preventDefault();
                return false;
            }

            switch (rel) {
                // In case of an asynchronous use.
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
        
        /**
         * If there is a modal within the page, we make sure to display it
         * @since   1.0.0
         */
        if (typeof $.fn.modal !== "undefined") {
            var bsModal = $(".modal");
            if (bsModal.length) {
                bsModal.modal("show");
            }
        }
        // We make sure to completely remove the modal when closed.
        $(document).on("hidden.bs.modal", ".modal", function (e) {
            $(this).remove();
        });
        
        /**
         * Another way to add a confirmation message before proceeding is
         * to add the "data-confirm" tag with a required message.
         * @example:
         * <a href="..." data-confirm="Are you sure?">...</a>
         */
        $(document).on("click", "[data-confirm]", function (e) {
            e.preventDefault();

            var that = $(this),
                href = that.attr("href"),
                message = that.data("confirm");

            // No URL provided? Nothing to do...
            if (!href.length) {
                return false;
            }

            // No message provided? Just proceed.
            if (!message.length) {
                window.location.href = href;
                return;
            }

            // Display the confirmation box before proceeding.
            return csk.ui.confirm(message, function () {
                window.location.href = href;
            });
        });

    });

})(window.jQuery || window.Zepto, window, document);
