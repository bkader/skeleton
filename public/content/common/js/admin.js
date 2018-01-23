(function(window, undefined) {
    "use strict";

    // Localize globals.
    var document = window.document,
        $ = window.$;

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

        /**
         * (A)Synchronous anchors.
         */
        $(document).on("click", "a[rel=async]", function (e) {
            /* Collect needed data first. */
            var $a = $(this),
                rel = $a.attr('rel'),
                url = $a.attr('ajaxify');

            /* No valid URL? Nothing to do. */
            if (typeof url === "undefined") {
                e.preventDefault();
                return;
            }

            /* Send the AJAX GET request. */
            $.ajax({
                type: "POST",
                data: {next: config.currenURL},
                dataType: "json",
                url: url,
                success: function (response) {
                    /* Did the user provide an action to eval? */
                    (response.action) && eval(response.action);
                    setTimeout((function () {
                        if (response.status == true) {
                            toastr.success(response.message);
                        } else {
                            toastr.error(response.message);
                        }
                    }), 500);
                }
            });

            return false;
        });

        $(".alert-dismissable").fadeTo(2000, 500).slideUp(500, function() {
            $(this).alert("close");
        });

        $("[data-toggle=tooltip]").tooltip();

        $("[data-confirm]").click(function(e) {
            var that = $(this);
            bootbox.confirm({
                size: "small",
                title: that.attr("title") || null,
                message: that.attr("data-confirm"),
                callback: function(result) {
                    if (result == true) {
                        window.location.href = that.attr("data-href");
                    } else {
                        bootbox.hideAll()
                    }
                }
            });
            e.preventDefault();
        });

    });

})(window);
