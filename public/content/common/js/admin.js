(function($) {
	'use strict';

	$(document).ready(function() {

		$('.alert-dismissable').fadeTo(2000, 500).slideUp(500, function() {
			$(this).alert('close');
		});

	});

})(jQuery);
