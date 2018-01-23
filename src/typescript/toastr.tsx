!function($) {
	"use strict";

	$(document).ready(function () {
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
	});
}
function deleteUser(id: number = 0) {
	if (id == 0) {
		return;
	}

	$.ajax({
		type: "GET",
		url: "",
		dataType: "json",
		success: function() {
			console.log('hahaha');
		},
		error: function() {
			console.error('error');
		}
	});
}
