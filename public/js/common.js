(function ($) {
	$(document).ready(function () {
		var start = 1;
		$('.element').on('focus', function() {
			$('.element.active').removeClass('active');
			$(this).addClass('active');
		});

		$('#block-system-main-menu .content li.expanded').hover(
			function () {
				if ($(window).width() > 1000) {
					$(this).find('ul').fadeIn(200);
				}
			},
			function () {
				if ($(window).width() > 1000) {
					$(this).find('ul').fadeOut(200);
				}
			}
		);
		$('#header').on('click', function () {
			if ($(window).width() <= 1120) {
				$(this).toggleClass('menuVisible');
			}
		});
		$('#block-system-main-menu .content li.expanded').on('click', function (e) {
			e.stopPropagation();
			if ($(window).width() <= 1120 && !$(this).hasClass('open')) {
				$('.open').removeClass('open');
				$(this).addClass('open');
				return false;
			}
		});
	});
})(jQuery);