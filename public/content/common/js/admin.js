(function(window, undefined) {
	'use strict';

	// Localize globals.
	var document = window.document,
		$ = window.$;

	$(document).ready(function() {

		$('.alert-dismissable').fadeTo(2000, 500).slideUp(500, function() {
			$(this).alert('close');
		});

		$('[data-toggle="tooltip"]').tooltip();

		$('[data-confirm]').click(function(e) {
			var that = $(this);
			bootbox.confirm({
				size: "small",
				title: that.attr('title') || null,
				message: that.attr('data-confirm'),
				callback: function(result) {
					if (result == true) {
						window.location.href = that.attr('data-href');
					} else {
						bootbox.hideAll()
					}
				}
			});
			e.preventDefault();
		});

	});

})(window);
