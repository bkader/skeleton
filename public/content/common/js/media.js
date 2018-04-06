/*!
 * Skeleton Media - v1.3.0 (https://github.com/bkader/skeleton)
 * Copyright 2018 Kader Bouyakoub (https://github.com/bkader)
 * Licensed under MIT (https://github.com/bkader/skeleton/blob/develop/LICENSE.md)
 */
(function ($, undefined) {

    jQuery.noConflict();
    "use strict";

    // Prepare dropzone and upload URL for later use.
    var droparea = jQuery('[data-dropzone]'),
        upload_url = droparea.attr('data-upload-url'),
        media_url = window.location.origin + window.location.pathname;

    // ========================================================
    // Media actions: view, close modal, delete and update
    // ========================================================
    
    // Media view button.
    jQuery(document).on("click", ".media-view", function (e) {
        e.preventDefault();
        var that = jQuery(this),
            href = that.attr("data-href");
        jQuery("#wrapper").load(href + " #wrapper > *", function() {
            window.history.pushState({href: href}, '', href);
            jQuery("#media-modal").modal("show");
        });
    });

    // Close media modal.
    jQuery(document).on("click", ".media-close", function (e) {
        e.preventDefault();
        jQuery("#media-modal").modal("hide").on("hidden.bs.modal", function (f) {
            window.history.pushState({href: media_url}, '', media_url);
        });
    });

    // Delete media.
    jQuery(document).on("click", ".media-delete", function (e) {
        e.preventDefault();
        var that = jQuery(this),
            message = that.attr("data-alert") || "Are you sure?",
            href = that.attr("data-href");

        if (confirm(message)) {
            jQuery.ajax({
                method: "DELETE",
                type: "DELETE", // Fallback
                url: href,
                cache: false,
                async: true,
                success: function (data, textStatus, xhr) {
                    jQuery("#media-modal").modal("hide");
                    toastr.success(data);
                    jQuery("#wrapper").load(window.location.href + " #wrapper > *");
                    window.history.pushState({href: media_url}, '', media_url);
                },
                error: function (xhr, textStatus, errorThrown) {
                    toastr.error(textStatus);
                }
            });
        }
    });

    // Media update form.
    jQuery(document).on("submit", "form[data-update]", function (e) {
        e.preventDefault();
        var that = jQuery(this),
            href = that.attr("action");

        var data = {
            name: jQuery.trim(that.find("#name").val()),
            description: jQuery.trim(that.find("#description").val())
        };
        jQuery.post(href, data, function (response, textStatus, jqXHR) {
            toastr.success(response);
        }, "json").fail(function(jqXHR, textStatus, errorThrown) {
            toastr.error(jqXHR.responseJSON);
        });
    });

    // ========================================================
    // When the DOM is ready.
    // ========================================================
    jQuery(document).ready(function () {

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
    });

})(jQuery);
