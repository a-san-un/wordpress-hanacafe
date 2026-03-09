/**
 * HanaCAFE nappa69 Main JS
 * * 2026-03-09: 
 * - Intersection Observer によるセクションフェードイン実装（.l-section, .p-page 対応）
 * - Heroセクションのロード時アニメーション実装
 * - A11Y対応ドロワーロジックの維持
 */
jQuery(function ($) {
	const $hamburger = $('.js-hamburger');
	const $drawer = $('.js-drawer');
	const $body = $('body');
	const $hero = $('.p-hero');
	// 監視対象をセクションと下層ページ全体に拡張
	const $animateTargets = $('.l-section, .p-page');

	/**
	 * 1. ハンバーガーメニュー開閉（A11Y対応）
	 */
	$hamburger.on('click', function () {
		const isExpanded = $(this).attr('aria-expanded') === 'true';
		
		$(this).attr('aria-expanded', !isExpanded);
		$drawer.attr('aria-hidden', isExpanded);
		$drawer.toggleClass('is-active');
		
		// 背景固定（スクロール抑制）
		if (!isExpanded) {
			$body.css('overflow', 'hidden');
		} else {
			$body.css('overflow', '');
		}
	});

	/* メニュー内リンククリックで自動閉鎖 */
	$drawer.find('a').on('click', function () {
		$hamburger.attr('aria-expanded', 'false');
		$drawer.attr('aria-hidden', 'true');
		$drawer.removeClass('is-active');
		$body.css('overflow', '');
	});

	/**
	 * 2. Intersection Observer によるフェードイン
	 * スクロールに合わせて各要素を下から浮上させる
	 */
	const observerOptions = {
		root: null,
		rootMargin: '0px 0px -15% 0px', // 画面下部から15%入ったところで発火
		threshold: 0.1
	};

	const sectionObserver = new IntersectionObserver((entries, observer) => {
		entries.forEach(entry => {
			if (entry.isIntersecting) {
				// 画面内に入ったらクラス付与
				entry.target.classList.add('is-inview');
				// 一度発火したら監視を解除（パフォーマンス最適化）
				observer.unobserve(entry.target);
			}
		});
	}, observerOptions);

	// 全ての対象要素を監視
	$animateTargets.each(function () {
		sectionObserver.observe(this);
	});

	/**
	 * 3. Heroセクションのロード演出
	 * 画像とタイトルの連動アニメーション用トリガー
	 */
	$(window).on('load', function () {
		// ページ全体の読み込み完了後に実行
		$hero.addClass('is-start');
	});
});