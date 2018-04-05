(function($) {
    "use strict";

    // Sidebar toggle.
    jQuery(document).on("click", ".sidebar-toggle", function (e) {
        e.preventDefault();
        jQuery("#sidebar").toggleClass("open");
    });

    // Links or buttons with confirmation.
    jQuery(document).on("click", "[data-confirm]", function (e) {
        e.preventDefault();
        var that = jQuery(this),
            href = that.attr("href"),
            message = that.attr("data-confirm");

        bootbox.confirm({
            size: "small",
            message: message,
            callback: function(result) {
                bootbox.hideAll();
                if (result === true && href.length) {
                    window.location.href = href;
                }
            }
        });
        return false;
    });

    $(document).ready(function() {

        // Some Toastr options.
        toastr.options = {
            "closeButton": true,
            "positionClass": "toast-top-center",
            "hideDuration": "300",
            "timeOut": "3000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        if (config.lang.direction === 'rtl') {
            toastr.options.rtl = true;
        }

        $(document).on('click', '[data-modal]', function(e) {
            e.preventDefault();
            var that = $(this),
                id = that.attr('data-media-id');
            var target = $(this).attr('data-modal');
            var modal = document.getElementById(target).innerHTML;
            var the_modal = Handlebars.compile(modal, {id: id});
            $(modal).modal();
        });

        /**
         * (A)Synchronous anchors.
         */
        $(document).on("click", "a[rel=async]", function (e) {
            /* Collect needed data first. */
            var $a = $(this),
                rel = $a.attr('rel'),
                url = $a.attr('ajaxify'),
                action = $a.attr('data-action'),
                confirm = $a.attr('data-confirm');

            /* Does it have a confirm message? */
            if (typeof confirm !== "undefined" && confirm !== false) {
                var _modal = document.getElementById("tpl-confirm").innerHTML;
                var _the_modal = Handlebars.compile(_modal);
                $(_the_modal({message: confirm, href: url})).modal();
                return false;
                bootbox.confirm({
                    size: "small",
                    message: confirm,
                    callback: function(result) {
                        bootbox.hideAll();
                        if (result === true) {
                            sendAjaxRequest('GET', url, {action: action});
                        }
                    }
                });
            } else {
                sendAjaxRequest('GET', url, {action: action});
            }
            return;


            /* No valid URL? Nothing to do. */
            if (proceed === false || typeof url === "undefined") {
                e.preventDefault();
                return;
            }

            /* Send the AJAX GET request. */
            $.get(url, {next: config.currenURL}, function (response) {
                if (response.status == false) {
                    toastr.error(response.message);
                }
            }, 'json');

            return false;
        });

        $(".alert-dismissable").fadeTo(2000, 500).slideUp(500, function() {
            $(this).alert("close");
        });

        $("[data-toggle=tooltip]").tooltip();

    });

    /**
     * AJAX Requests handler.
     * @param   string  _type   The AJAX call method.
     * @param   string  _url    The URL to send request to.
     * @param   array   _data   Array of data to send.
     * @return  void
     */
    function sendAjaxRequest(_type, _url, _data = {}) {

        /* We make sure the _url is defined! */
        if (_url === "undefined") {
            return;
        }

        /* In case of sending a GET request. */
        if (_type == 'GET' && _data.action) {

            /* If some data is provided, we append them. */
            if (_data.action) {
                _url = _url + "&action=" + _data.action;
            }

            /* Send the request. */
            $.get(_url, function (response) {

                /* We catch the response. */
                if (response.status === false) {
                    toastr.error(response.message);
                } else {
                    if (response.action) {
                        eval(response.action);
                    }
                    toastr.success(response.message);
                }
            }, 'json');
            return;
        }

        /* In case of sending a POST request. */
        $.post(_url, _data, function (response) {
            if (response.status === false) {
                toastr.error(response.message);
            } else {
                if (response.action) {
                    eval(response.action);
                }
                toastr.success(response.message);
            }
        }, 'json');
    }

})(jQuery);
