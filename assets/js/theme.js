(function ($) {
	$(document).foundation();

	// Add additional 'is-expanded' class to the button which triggers Foundation Toggle
	$('[data-toggle]').on('click', function () {
		$(this).toggleClass('is-expanded');
	});

})(jQuery);
