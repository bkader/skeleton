/*!
 * CodeIgniter Skeleton - Media Module (https://github.com/bkader/skeleton)
 * Copyright 2018 Kader Bouyakoub (https://goo.gl/wGXHO9)
 * Licensed under MIT (https://github.com/bkader/skeleton/blob/develop/LICENSE.md)
 */
(function ($, window, document, undefined) {
    "use strict";

    // Prepare globals.
    var csk = window.csk = window.csk || {},
        mediaURL = csk.config.currentURL;
    csk.media = csk.media || {};
    csk.i18n = csk.i18n || {};
    csk.i18n.media = csk.i18n.media || {}

    var btnSelectBulk = ".media-select-bulk",
        btnSelectCancel = ".media-select-cancel",
        btnSelectDelete = ".media-select-delete",
        selectedItems = {},
        itemsCount = 0;

    /**
     * Medias Object.
     * Handles all operations done on media module.
     * @since   1.4.0
     */
    csk.media = $.extend(csk.media, {
        details: function (el) {
            var $this = $(el),
                url = $this.attr("href"),
                id = $this.parents(".attachment").data("id"),
                href = this.previewUrl + "/" + id;

            if (typeof href === "undefined" || !href.length) {
                return false;
            }

            $this.parents(".attachment").addClass("selected");

            var modalSource = document.getElementById("media-modal-template").innerHTML,
                modalTemplate = Handlebars.compile(modalSource);

            csk.ajax.request(href, {
                type: "POST",
                data: {
                    action: "view_media_" + id
                },
                success: function (data, textStatus) {
                    if (textStatus !== "success") {
                        return false;
                    }
                    window.history.pushState({href: url}, "", url);
                    var mediaModal = modalTemplate(data.results.data);
                    $("#media-modal-container").append(mediaModal);
                    $("#media-modal").modal("show");
                }
            });
        },

        update: function (el) {
            var $this = $(el),
                href = $this.attr("action"),
                id = $this.data("id") || '';

            if (!href.length) {
                return false;
            }

            var data = {
                _csknonce: $.trim($this.find("[name=_csknonce]").val()),
                name: $.trim($this.find("#name").val()),
                description: $.trim($this.find("#description").val()),
                action: "update_media_" + id
            };

            csk.ajax.request(href, {
                type: "POST",
                data: data,
                complete: function () {
                    $this.closest(".modal").modal("hide");
                }
            });
            return false;
        },
        // Delete media.
        delete: function (el) {
            var $this = $(el),
                href = $this.attr("href"),
                id = $this.data("id");

            if (!href.length) {
                return false;
            }

            return csk.ui.confirm(csk.i18n.media.delete, function () {
                csk.ajax.request(href, {
                    type: "POST",
                    data: {
                        action: "delete_media_" + id
                    },
                    complete: function () {
                        itemsCount--;
                        if (itemsCount <= 0) {
                            location.reload();
                        } else {
                            $("#media-" + id).fadeOut(function () {
                                $("#media-modal").modal("hide");
                                $(this).remove();
                            });
                        }
                    }
                });
            });
        }
    });

    $(document).ready(function () {
        
        if (mediaURL.indexOf("?") > 0) {
            mediaURL = mediaURL.substring(0, mediaURL.indexOf("?"));
        }

        // LazyLoad images.
        lazyload();

        // Count present items.
        itemsCount = $(".attachments").children(".attachment").length;
        if (itemsCount > 0) {
            $(btnSelectBulk).prop("disabled", false).removeClass("disabled");
        }

        // Should we display the modal?
        var mediaModal = mediaModal || $("#media-modal");

        if (mediaModal.length) {
            mediaModal.modal("show");
        }

        // Dropzone handler.
        if (typeof $.fn.dropzone !== "undefined") {
            $("#media-dropzone").dropzone({
                url: $(this).attr("action"),
                previewsContainer: ".attachments",
                clickable: "#media-add",
                params: {
                    action: csk.nonce.name,
                    _csknonce: csk.nonce.value
                },
                init: function () {
                    this.on("addedfile", function () {
                        $(".dz-message").remove();
                    });

                    this.on("success", function (file, response) {
                        var smd = response.results || '';
                        if (typeof smd !== "object") {
                            return false;
                        }
                        var smdSource = document.getElementById("attachment-template").innerHTML,
                            smdTemplate = Handlebars.compile(smdSource),
                            smdHTML = smdTemplate(smd);
                        $(smdHTML).hide().prependTo(".attachments").fadeIn("slow");
                        this.removeFile(file);

                        // We update count.
                        if (itemsCount <= 0) {
                            $(btnSelectBulk)
                                .prop("disabled", false)
                                .removeClass("disabled");
                        }
                        itemsCount++;
                    });

                    this.on("error", function (file, response) {
                        csk.ui.alert(response.message || response, "error");
                    });
                }
            });
        }

        // Always push history back.
        $(document).on("hidden.bs.modal", "#media-modal", function (e) {
            $(".attachment.selected").removeClass("selected");
            window.history.pushState({href: mediaURL}, "", mediaURL);
            $(this).remove();
        });

        /**
         * Bulk Selection Section
         * @since   1.4.0
         */
        // Bulk selection button.
        $(document).on("click", btnSelectBulk, function (e) {
            $(this).addClass("d-none");

            $(btnSelectCancel)
                .removeClass("d-none")
                .prop("autofocus", true);

            $(btnSelectDelete).removeClass("d-none");
            $(".attachments").addClass("select-mode");
        });

        // Cancel selection button.
        $(document).on("click", btnSelectCancel, function (e) {
            $(this)
                .addClass("d-none")
                .prop("autofocus", false);

            $(btnSelectDelete)
                .data("disabled", true)
                .addClass("d-none disabled");

            $(btnSelectBulk).removeClass("d-none");
            $(".attachments")
                .removeClass("select-mode")
                .children(".attachment")
                .removeClass("selected");
        });

        // Delete selection button.
        $(document).on("click", btnSelectDelete, function (e) {
            e.preventDefault();
            var that = $(this);
            if (!Object.keys(selectedItems).length) {
                that.prop("disabled", true).addClass("disabled");
                return false;
            }

            // Confirm before proceeding.
            csk.ui.confirm(csk.i18n.media.delete_bulk, function () {
                var itemsCount = $(".attachments").children(".attachment").length;
                $.each(selectedItems, function (id, nonce) {
                    csk.ajax.request(csk.media.deleteUrl + "/" + id, {
                        type: "POST",
                        data: {
                            action: "delete_media_" + id,
                            _csknonce: nonce
                        },
                        complete: function (jqXHR, textStatus) {
                            $("#media-" + id).fadeOut(function () {
                                if ($("#media-modal").length) {
                                    $("#media-modal").modal("hide");
                                }
                                $(this).remove();
                            });
                            itemsCount--;
                            if (itemsCount <= 0) {
                                window.location.href = csk.config.adminURL + "/media";
                            }
                        }
                    });
                });

                // We disable the delete button after all files are deleted.
                that.prop("disabled", true).addClass("disabled");
            });
        });

        /**
         * Single media actions.
         * @since   1.0.0
         */

        // View media details.
        $(document).on("click", ".media-view", function (e) {
            e.preventDefault();

            // Only open if not in selection mode.
            if ($(this).parents(".attachments").hasClass("select-mode")) {

                var that = $(this),
                    attachment = that.parents(".attachment"),
                    id = attachment.data("id"),
                    nonce = attachment.data("nonce");

                if (attachment.hasClass("selected")) {

                    attachment.removeClass("selected");
                    delete selectedItems[id];

                    if (!Object.keys(selectedItems).length) {
                        $(btnSelectDelete)
                            .prop("disabled", true)
                            .addClass("disabled");
                    }

                } else {

                    attachment.addClass("selected");
                    selectedItems[id] = nonce;

                    if (Object.keys(selectedItems).length) {
                        $(btnSelectDelete)
                            .prop("disabled", false)
                            .removeClass("disabled");
                    }

                }

                return false;
            }

            // Otherwise, display details.
            return csk.media.details(this);
        });

        // Update media details.
        $(document).on("submit", "form.media-update", function (e) {
            e.preventDefault();
            return csk.media.update(this);
        });

        // Delete media.
        $(document).on("click", ".media-delete", function (e) {
            e.preventDefault();
            return csk.media.delete(this);
        });

    });

})(window.jQuery || window.Zepto, window, document);
