/**
 * HanaCAFE nappa69 Main JS
 * 2026-03-21:
 * - jQuery -> Vanilla JS 全面書き換え完了（STEP 5-9）
 * - DOMContentLoaded ラッパーに統一・jQuery依存を完全撤去
 * * 2026-03-13:
 * - スクロール連動ヘッダー（.is-scrolled）の実装を追加
 * - 表示保証（Anti-Blackout）のため、監視対象から .p-page を除外
 * - Intersection Observer によるセクション（.l-section）フェードイン実装
 * - Heroセクションのトリガークラス名を SSOT(is-start) に再統合
 * - A11Y対応ドロワーロジックの維持
 */
document.addEventListener("DOMContentLoaded", function () {
  const header = document.querySelector(".js-header");
  const hamburger = document.querySelector(".js-hamburger");
  const drawer = document.querySelector(".js-drawer");
  const drawerClose = document.querySelector(".js-drawer-close");
  const hero = document.querySelector(".p-hero");
  // 監視対象を個別のセクション（.l-section）に限定
  // ※親コンテナ（.p-page）を監視すると、SP版で判定が不安定になり表示が消えるリスクがあるため除外
  /**
   * 0. スクロール連動ヘッダー (Food Science準拠)
   * [設計意図] ページが1pxでも動いたらヘッダーの質感を変化させ、
   * ユーザーに「隠れ家に入っていく」ような視覚的変化を促す。
   */
  let rafId = null;
  window.addEventListener("scroll", function () {
    if (rafId) return;
    rafId = requestAnimationFrame(function () {
      if (window.scrollY > 0) {
        header.classList.add("is-scrolled");
      } else {
        header.classList.remove("is-scrolled");
      }
      rafId = null;
    });
  });

  /**
   * 1. ハンバーガーメニュー開閉（A11Y対応）
   */
  function closeDrawer() {
    hamburger.setAttribute("aria-expanded", "false");
    drawer.setAttribute("aria-hidden", "true");
    drawer.classList.remove("is-active");
    document.body.style.overflow = "";
  }

  hamburger.addEventListener("click", function () {
    const isExpanded = hamburger.getAttribute("aria-expanded") === "true";

    hamburger.setAttribute("aria-expanded", String(!isExpanded));
    drawer.setAttribute("aria-hidden", String(isExpanded));
    drawer.classList.toggle("is-active");

    // 背景固定（スクロール抑制）
    if (!isExpanded) {
      document.body.style.overflow = "hidden";
    } else {
      document.body.style.overflow = "";
    }
  });

  /* メニュー内リンククリックで自動閉鎖 */
  drawer.querySelectorAll("a").forEach(function (link) {
    link.addEventListener("click", function () {
      closeDrawer();
    });
  });

  /* 閉じるボタンクリックでドロワーを閉じる */
  drawerClose.addEventListener("click", function () {
    closeDrawer();
    hamburger.focus();
  });

  /* Escキーでドロワーを閉じる */
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape" && drawer.classList.contains("is-active")) {
      closeDrawer();
      hamburger.focus();
    }
  });

  /* フォーカストラップ：ドロワー開放中はTab/Shift+Tabをドロワー内に閉じ込める */
  drawer.addEventListener("keydown", function (e) {
    if (e.key !== "Tab") return;
    const focusable = Array.from(drawer.querySelectorAll("a, button, [tabindex]:not([tabindex='-1'])")).filter(
      function (el) {
        return getComputedStyle(el).display !== "none";
      }
    );
    if (focusable.length === 0) return;
    const first = focusable[0];
    const last = focusable[focusable.length - 1];
    if (e.shiftKey) {
      if (document.activeElement === first) {
        e.preventDefault();
        last.focus();
      }
    } else {
      if (document.activeElement === last) {
        e.preventDefault();
        first.focus();
      }
    }
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

  document.querySelectorAll(".l-section").forEach(function (el) {
    sectionObserver.observe(el);
  });

  /**
   * 3. ヒーローセクションの初期アニメーション
   * [修正点] _p-hero.scss の定義に合わせ is-start を付与
   */
  if (hero) {
    if (document.readyState === "complete") {
      hero.classList.add("is-start");
    } else {
      window.addEventListener("load", function () {
        hero.classList.add("is-start");
      });
    }
  }
});
