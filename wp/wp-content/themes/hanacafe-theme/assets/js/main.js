/**
 * HanaCAFE nappa69 Main JS
 */
jQuery(function ($) {
	const $hamburger = $('.js-hamburger');
	const $drawer = $('.js-drawer');
	const $body = $('body');

	/* ハンバーガーメニュー開閉 */
	$hamburger.on('click', function () {
		// 現在開いているかどうかの状態（true / false）を取得
		const isExpanded = $(this).attr('aria-expanded') === 'true';
		
		// ハンバーガーボタンの属性を反転（開いていれば閉じる、閉じていれば開く）
		$(this).attr('aria-expanded', !isExpanded);
		
		// ★追加：ドロワー側の aria-hidden を切り替え
		// 開く時(isExpandedがfalse)は aria-hidden="false" にする
		$drawer.attr('aria-hidden', isExpanded);

		$drawer.toggleClass('is-active');
		
		// 背景固定
		if (!isExpanded) {
			$body.css('overflow', 'hidden');
		} else {
			$body.css('overflow', '');
		}
	});

	/* メニュー内リンククリックで閉じる */
	$drawer.find('a').on('click', function () {
		$hamburger.attr('aria-expanded', 'false');
		
		// ★追加：メニューが閉じるので、再びスクリーンリーダーから隠す
		$drawer.attr('aria-hidden', 'true');
		
		$drawer.removeClass('is-active');
		$body.css('overflow', '');
	});
});