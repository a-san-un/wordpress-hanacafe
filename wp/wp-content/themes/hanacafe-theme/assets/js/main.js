/**
 * HanaCAFE nappa69 Main JS
 */
jQuery(function ($) {
	const $hamburger = $('.js-hamburger');
	const $drawer = $('.js-drawer');
	const $body = $('body');

	/* ハンバーガーメニュー開閉 */
	$hamburger.on('click', function () {
		const expanded = $(this).attr('aria-expanded') === 'true';
		
		$(this).attr('aria-expanded', !expanded);
		$drawer.toggleClass('is-active');
		
		// 背景固定
		if (!expanded) {
			$body.css('overflow', 'hidden');
		} else {
			$body.css('overflow', '');
		}
	});

	/* メニュー内リンククリックで閉じる */
	$drawer.find('a').on('click', function () {
		$hamburger.attr('aria-expanded', 'false');
		$drawer.removeClass('is-active');
		$body.css('overflow', '');
	});
});