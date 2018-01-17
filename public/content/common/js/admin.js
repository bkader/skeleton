(function($) {
	'use strict';

	$(document).ready(function() {

		$('.alert-dismissable').fadeTo(2000, 500).slideUp(500, function() {
			$(this).alert('close');
		});

		$('[data-confirm]').click(function(e) {
			e.preventDefault();
			bootbox.confirm({
				size: "small",
				title: $(this).attr('title') || null,
				message: $(this).attr('data-confirm'),
				callback: function(result) {
					if (result == true) {
						$.get($(this).attr('data-href'), function(html) {
							console.log(html);
						});
					}
					console.log(result);
					return false;
				}
			});
			return false;
		});

	});

})(jQuery);
