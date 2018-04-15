/*!
 * CodeIgniter Skeleton - Media Module (https://github.com/bkader/skeleton)
 * Copyright 2018 Kader Bouyakoub (https://github.com/bkader)
 * Licensed under MIT (https://github.com/bkader/skeleton/blob/develop/LICENSE.md)
 */
(function($, window, document, undefined) {

    $.noConflict();
    "use strict";

    // ========================================================
    // View media details.
    // ========================================================
    $(document).on("click", ".media-view", function (e) {
        e.preventDefault();
        var that = $(this), href = that.attr("href");
        if (!href.length) { return; }
        $("#media-modal-container").load(href + " #media-modal-container > *", function () {
            window.history.pushState({href: href}, '', href);
            $("#media-modal").modal("show");
        });
    });


    // ========================================================
    // Delete media.
    // ========================================================
    $(document).on("click", ".media-delete", function (e) {
        e.preventDefault();
        var that = $(this), href = that.attr("href"), id = that.attr("data-media-id");
        if (!href.length) { return; }
        var mediaCount = $(".attachments").children(".attachment").length,
            mediaModal = mediaModal || $("#media-modal");
        bootbox.confirm({
            message: i18n.media.delete,
            callback: function (result) {
                bootbox.hideAll();
                if (result !== true) { return; }
                $.get(href, function (response) {
                    toastr.success(response);
                }).done(function () {
                    mediaCount--;
                    if (mediaCount <= 0) { location.reload(); return; }
                    $("#media-" + id).fadeOut(function () {
                        if (mediaModal.length) { mediaModal.modal("hide"); }
                        $(this).remove();
                    });
                }).fail(function (response) {
                    toastr.error(response.responseJSON);
                });
            }
        });
    });

    // ========================================================
    // Update media details.
    // ========================================================
    $(document).on("submit", "form.media-update", function (e) {
        e.preventDefault();
        var that = $(this), href = that.attr("action");
        if (!href.length) { return; }
        var mediaModal = mediaModal || $("#media-modal"),
            data = {
                name: $.trim(that.find("#name").val()),
                description: $.trim(that.find("#description").val())
            };
        // if (!data.length) { return; }
        $.post(href, data, function (response) {
            toastr.success(response);
        }).done(function () {
            mediaModal.modal("hide");
            window.history.pushState({href: Config.adminURL + "/media"}, '', Config.adminURL + "/media");
        }).fail(function (response) {
            console.log(response);
            toastr.error(response.responseJSON);
        });
    });

    // ========================================================
    // Put back URL when modal is closed.
    // ========================================================
    $(document).on("hidden.bs.modal", "#media-modal", function (e) {
        window.history.pushState({href: Config.adminURL + "/media"}, '', Config.adminURL + "/media");
        $(this).remove();
    });

    // ========================================================
    // When the DOM is ready.
    // ========================================================
    $(document).ready(function () {
        // LazyLoad images.
        lazyload();
        // Should we display the modal?
        var mediaModal = mediaModal || $("#media-modal");
        if (mediaModal.length) { mediaModal.modal("show"); }

        // Dropzone handler.
        var droparea = $("[data-dropzone]");
        if (droparea.length) {
            var drop = new Dropzone("[data-dropzone]", {
                url: droparea.attr("data-upload-url"),
                success: function (file, response) {
                    droparea.load(window.location.href + " [data-dropzone] .attachments");
                    toastr.success(response);
                },
                error: function (file, error, xhr) {
                    toastr.error(error);
                }
            });
        }
    });
})(window.jQuery || window.Zepto, window, document);
