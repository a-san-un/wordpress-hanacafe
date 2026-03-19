/**
 * HanaCAFE nappa69 Main JS
 * * 2026-03-13:
 * - スクロール連動ヘッダー（.is-scrolled）の実装を追加
 * - 表示保証（Anti-Blackout）のため、監視対象から .p-page を除外
 * - Intersection Observer によるセクション（.l-section）フェードイン実装
 * - Heroセクションのトリガークラス名を SSOT(is-start) に再統合
 * - A11Y対応ドロワーロジックの維持
 */
jQuery(function ($) {
	const $header = $(".js-header");
	const $hamburger = $(".js-hamburger");
	const $drawer = $(".js-drawer");
	const $body = $("body");
	const $hero = $(".p-hero");
	// 監視対象を個別のセクション（.l-section）に限定
	// ※親コンテナ（.p-page）を監視すると、SP版で判定が不安定になり表示が消えるリスクがあるため除外
	const $animateTargets = $(".l-section");

	/**
	 * 0. スクロール連動ヘッダー (Food Science準拠)
	 * [設計意図] ページが1pxでも動いたらヘッダーの質感を変化させ、
	 * ユーザーに「隠れ家に入っていく」ような視覚的変化を促す。
	 */
	let rafId = null;
	$(window).on("scroll", function () {
		if (rafId) return;
		rafId = requestAnimationFrame(function () {
			if ($(window).scrollTop() > 0) {
				$header.addClass("is-scrolled");
			} else {
				$header.removeClass("is-scrolled");
			}
			rafId = null;
		});
	});

	/**
	 * 1. ハンバーガーメニュー開閉（A11Y対応）
	 */
	$hamburger.on("click", function () {
		const isExpanded = $(this).attr("aria-expanded") === "true";

		$(this).attr("aria-expanded", !isExpanded);
		$drawer.attr("aria-hidden", isExpanded);
		$drawer.toggleClass("is-active");

		// 背景固定（スクロール抑制）
		if (!isExpanded) {
			$body.css("overflow", "hidden");
		} else {
			$body.css("overflow", "");
		}
	});

	/* メニュー内リンククリックで自動閉鎖 */
	$drawer.find("a").on("click", function () {
		$hamburger.attr("aria-expanded", "false");
		$drawer.attr("aria-hidden", "true");
		$drawer.removeClass("is-active");
		$body.css("overflow", "");
	});

	/**
	 * 2. Intersection Observer によるフェードイン
	 * スクロールに合わせて各要素（.l-section）を下から浮上させる
	 */
	const observerOptions = {
		root: null,
		rootMargin: "0px 0px -15% 0px", // 画面下部から15%入ったところで発火
		threshold: 0.1,
	};

	const sectionObserver = new IntersectionObserver((entries) => {
		entries.forEach((entry) => {
			if (entry.isIntersecting) {
				entry.target.classList.add("is-inview");
				sectionObserver.unobserve(entry.target); // 一度表示されたら監視終了
			}
		});
	}, observerOptions);

	$animateTargets.each(function () {
		sectionObserver.observe(this);
	});

	/**
	 * 3. ヒーローセクションの初期アニメーション
	 * [修正点] _p-hero.scss の定義に合わせ is-start を付与
	 */
	if ($hero.length) {
		if (document.readyState === "complete") {
			$hero.addClass("is-start");
		} else {
			$(window).on("load", function () {
				$hero.addClass("is-start");
			});
		}
	}
});
