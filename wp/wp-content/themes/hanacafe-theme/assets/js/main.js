/**
 * HanaCAFE nappa69 Main JavaScript
 */

// 1. スクロール監視 (Intersection Observer) - そのまま維持
document.addEventListener('DOMContentLoaded', () => {
	const observerOptions = {
		threshold: 0.1,
		rootMargin: '0px 0px -50px 0px'
	};

	const observer = new IntersectionObserver((entries) => {
		entries.forEach(entry => {
			if (entry.isIntersecting) {
				entry.target.classList.add('visible');
			}
		});
	}, observerOptions);

	document.querySelectorAll('.reveal').forEach(el => {
		observer.observe(el);
	});
});

// 2. ハンバーガー・ドロワー制御（Food Science流のシンプル実装）
jQuery(function ($) {
	const $hamburger = $('.js-hamburger');
	const $drawer = $('.js-drawer');

	$hamburger.on('click', function () {
		$(this).toggleClass('is-active');
		$drawer.toggleClass('is-active');

		const isActive = $(this).hasClass('is-active');
		$(this).attr('aria-expanded', isActive);

		if (isActive) {
			$('body').css('overflow', 'hidden');
		} else {
			$('body').css('overflow', '');
		}
	});

	// リンククリック時に閉じる
	$('.p-drawer a').on('click', function () {
		$hamburger.removeClass('is-active').attr('aria-expanded', 'false');
		$drawer.removeClass('is-active');
		$('body').css('overflow', '');
	});
});