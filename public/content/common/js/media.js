(function ($, bootbox, axios, undefined) {

    /* Everything is done when DOM is fully loaded. */
    $(document).ready(function () {

        var droparea = $('[data-dropzone]');
        var upload_url = droparea.attr('data-upload-url');

        var drop = new Dropzone('[data-dropzone]', {
            url: upload_url,
            init: function () {
                this.on('sending', function (file, xhr, formData) {
                    formData.append('action', 'upload');
                });
            },
            success: function (file, response) {
                droparea.load(window.location.href + " [data-dropzone] .attachments");
                toastr.success(response);
            },
            error: function (file, error, xhr) {
                toastr.error(error);
            }
        });

        $(document).on('click', '[data-show]', function (e) {
            e.preventDefault();
            var that = $(this),
                id = that.attr('data-mid'),
                url = that.attr('ajaxify');

            if ( ! id || ! url) {
                return;
            }

            var _modal = document.getElementById('tpl-media-show').innerHTML;
            var media_model = Handlebars.compile(_modal);

            $.ajax({
                method: "GET",
                type: "GET",
                url: url,
                dataType: "json",
                success: function (html) {
                    $(media_model(JSON.parse(html))).modal();
                }
            });
        });

        $(document).on('submit', 'form[data-update]', function (e) {
            e.preventDefault();
            var that = $(this),
                url = that.attr('action');

            var data = {
                name: that.find('#name').serializeArray(),
                description: that.find('#description').serializeArray()
            };

            $.ajax({
                method: "PUT",
                type: "PUT",
                data: data,
                url: url,
                success: function (response) {
                    console.log(response);
                    toastr.success(response);
                },
                error: function (err) {
                    console.log(err);
                }
            });
            return false;
        });

        /**
         * Delete media action.
         */
        $(document).on('click', '[data-delete]', function (e) {
            e.preventDefault();
            var that = $(this),
                id = that.attr("data-mid"),
                url = that.attr("ajaxify"),
                message = document.getElementById("tpl-delete-alert").innerHTML,
                target = $("#media-" + id);

            // Make sure the message is set.
            message = message || "Are you suer?";

            // Ask the user first.
            bootbox.confirm({
                size: "small",
                message: message,
                buttons: {
                    confirm: {className: "btn-danger"},
                    cancel: {className: "pull-left"}
                },
                callback: function (response) {
                    if (response === true) {
                        $.ajax({
                            method: "DELETE",
                            type: "DELETE", // Fallback
                            url: url,
                            cache: false,
                            async: true,
                            success: function (data, textStatus, xhr) {
                                droparea.load(window.location.href + " [data-dropzone] .attachments", function () {
                                    toastr.success(data);
                                });
                            },
                            error: function (xhr, textStatus, errorThrown) {
                                toastr.error(textStatus);
                            }
                        });
                    }
                    bootbox.hideAll();
                }
            });
            // bootbox.confirm(message, function (response) {
            //     if (response === true) {
            //         $.ajax({
            //             method: "GET",
            //             type: "GET", // Fallback
            //             url: url,
            //             cache: false,
            //             async: true,
            //             success: function (data, textStatus, xhr) {
            //                 droparea.load(window.location.href + " [data-dropzone] .attachments");
            //                 toastr.success(data);
            //             },
            //             error: function (xhr, textStatus, errorThrown) {
            //                 toastr.error(textStatus);
            //             }
            //         });
            //     }
            //     bootbox.hideAll();
            // });
            // if (confirm(message)) {
            //     $.ajax({
            //         method: "GET",
            //         type: "GET", // Fallback
            //         url: url,
            //         cache: false,
            //         async: true,
            //         success: function (data, textStatus, xhr) {
            //             droparea.load(window.location.href + " [data-dropzone] .attachments");
            //             toastr.success(data);
            //         },
            //         error: function (xhr, textStatus, errorThrown) {
            //             toastr.error(textStatus);
            //         }
            //     });
            // }
            return false;
        });
        // $('[data-delete]').on('click', function (e) {
        //     e.preventDefault();
        //     var that = $(this),
        //         id = that.attr('data-delete'),
        //         url = config.ajaxURL + "/media/delete",
        //         message = document.getElementById("tpl-delete-alert").innerHTML,
        //         target = that.parent().parent().parent();

        //     message = message || 'Are you sure?';

        //     if (confirm(message)) {
        //         $.ajax({
        //             method: "POST",
        //             type: "POST", /* Fallback */
        //             url: url,
        //             data: {action: "delete", id: id},
        //             success: function (html) {
        //                 toastr.success(html);
        //             },
        //             error: function (html) {
        //                 toastr.error(html);
        //             }
        //         });
        //     }
        //     return false;
        // });
    });

})(jQuery, bootbox, axios);
