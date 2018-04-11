/*!
 * CodeIgniter Skeleton - Media Module (https://github.com/bkader/skeleton)
 * Copyright 2018 Kader Bouyakoub (https://github.com/bkader)
 * Licensed under MIT (https://github.com/bkader/skeleton/blob/develop/LICENSE.md)
 */
(function ($, undefined) {

    jQuery.noConflict();
    "use strict";

    // ========================================================
    // Hold some needed variables.
    // ========================================================
    var wrapper = wrapper || jQuery("#wrapper"),
        mediaURL = Config.adminURL + "/media",
        droparea = jQuery('[data-dropzone]'),
        upload_url = droparea.attr('data-upload-url');

    // ========================================================
    // View media details.
    // ========================================================
    jQuery(document).on("click", ".media-view", function (e) {
        e.preventDefault();
        var that = jQuery(this),
            href = that.attr("data-href");
        wrapper.load(href + " #wrapper > *", function() {
            window.history.pushState({href: href}, '', href);
            jQuery("#media-modal").modal("show");
        });
    });


    // ========================================================
    // Delete media.
    // ========================================================
    jQuery(document).on("click", ".media-delete", function (e) {
        e.preventDefault();

        // Prepare variables to be used.
        var media_count = jQuery(".attachments > .attachment").length,
            that = jQuery(this),
            href = href = that.attr("data-href"),
            id = that.attr("data-media-id"),
            _modal = _modal || jQuery("#media-modal");

        // Display the confirmation message.
        bootbox.confirm({
            size: "small",
            message: mediaAlert.delete,
            callback: function (result) {
                bootbox.hideAll();
                if (result === true && href.length) {
                    jQuery.get(href, function (response, textStatus) {
                        if (textStatus == "success") {
                            media_count--;
                            _modal.modal("hide");
                            toastr.success(response);
                            if (media_count <= 0) {
                                location.reload();
                            } else {
                                jQuery("#media-" + id).fadeOut(function () {
                                    jQuery(this).remove();
                                });
                            }
                            window.history.pushState({href: mediaURL}, '', mediaURL);
                        } else {
                            toastr.error(response);
                        }
                    });
                }
            }
        });
    });

    // ========================================================
    // Update media details.
    // ========================================================
    jQuery(document).on("submit", "form.media-update", function (e) {
        e.preventDefault();
        var that = jQuery(this),
            href = that.attr("action"),
            _modal = _modal || jQuery("#media-modal"),
            data = {
                name: jQuery.trim(that.find("#name").val()),
                description: jQuery.trim(that.find("#description").val())
            };
        jQuery.post(href, data, function (response, textStatus, jqXHR) {
            toastr.success(response);
            _modal.modal("hide");
            window.history.pushState({href: mediaURL}, '', mediaURL);
        }, "json").fail(function(jqXHR, textStatus, errorThrown) {
            toastr.error(jqXHR.responseJSON);
        });
    });

    // ========================================================
    // Put back URL when modal is closed.
    // ========================================================
    jQuery(document).on("hide.bs.modal hidden.bs.modal", "#media-modal", function (e) {
        window.history.pushState({href: mediaURL}, '', mediaURL);
    });

    // ========================================================
    // When the DOM is ready.
    // ========================================================
    jQuery(document).ready(function () {

        // Should we display the modal?
        var _modal = _modal || jQuery("#media-modal");
        if (_modal.length) {
            _modal.modal("show");
        }

        // Dropzone handler.
        var drop = new Dropzone("[data-dropzone]", {
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
    });

})(jQuery);
