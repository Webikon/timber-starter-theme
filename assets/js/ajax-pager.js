(function ($) {

	/**
	 * Load more posts with AJAX.
	 * Really simple. All you need is this JS and some HTML markup.
	 *
	 * Markup requirements:
	 * .js-ajax-posts - outer wrapper for loop and pagination
	 * .js-ajax-posts-loop - wrapper for actual posts loop, we will look for posts in this wrapper
	 * .js-ajax-loader - icon or animation, which is showed when ajax is processed
	 * .js-loop-cta - pagination wrapper
	 * .js-ajax-load-posts - pagination button with link to next page
	 *
	 * Source: previous projects like Softec and Bratislavaman
	 *
	 */
	$('body').on('click', '.js-ajax-load-posts', function (e) {
		e.preventDefault();

		// Get next page link
		var $link = $(this).attr('href');
		var $btn = $(this);

		$.ajax({
			url: $link,
			context: $('.js-ajax-posts'), // Outer wrapper for ajax
			dataType: 'html',
			beforeSend: function () {
				$btn.hide();
				$('.js-ajax-loader').show(); // Show loading svg

				$('.js-loop-cta').addClass('is-loading'); // Add loading class to pagination wrapper
				$btn.bind('click', false); // Disable button click event
			},
			success: function (result) {
				// Append articles
				$('.js-ajax-posts-loop').append($(result).find('.js-ajax-posts-loop article'));

				// Append navigation
				$(this).append($(result).find('.js-loop-cta'));

				$('.js-loop-cta.is-loading').remove(); // Remove previous pagination wrapper
				$('.js-ajax-loader').hide(); // Hide loading svg

				$btn.unbind('click', false); // Re-enable button click event
			}
		});
	});

})(jQuery);
