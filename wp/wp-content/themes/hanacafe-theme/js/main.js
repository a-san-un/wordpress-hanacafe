/**
 * HanaCAFE nappa69 Main JavaScript
 */

// 1. スクロール監視 (Intersection Observer) - ふわっと表示するアニメーション用
document.addEventListener('DOMContentLoaded', () => {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // .reveal 要素が画面に入ったら .visible クラスを付与
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);

    // 全ての .reveal 要素を監視
    document.querySelectorAll('.reveal').forEach(el => {
        observer.observe(el);
    });
});

// 2. jQuery を使った動的制御 (ハンバーガー・ヘッダー)
jQuery(function($) {
    /**
     * ハンバーガーメニューの開閉制御
     */
    var $hamburger = $('.js-hamburger');
    var $menu = $('.js-menu');
    var isShow = false;

    $hamburger.on('click', function() {
        if (isShow === false) {
            // メニューを開く
            $hamburger.addClass('is-active');
            $menu.addClass('is-active');
            // 背景スクロールを防止したい場合は body にクラスを付ける
            $('body').css('overflow', 'hidden');
            isShow = true;
        } else {
            // メニューを閉じる
            $hamburger.removeClass('is-active');
            $menu.removeClass('is-active');
            $('body').css('overflow', 'auto');
            isShow = false;
        }
    });

    /**
     * メニュー内リンククリック時に閉じる
     * （アンカーリンク移動時にメニューが開きっぱなしになるのを防ぐ）
     */
    $('.js-menu a').on('click', function() {
        if (isShow === true) {
            $hamburger.removeClass('is-active');
            $menu.removeClass('is-active');
            $('body').css('overflow', 'auto');
            isShow = false;
        }
    });

    /**
     * スクロールに応じてヘッダーにクラスを付与
     */
    $(window).on('scroll', function () {
        if ($(this).scrollTop() > 100) {
            $(".site-header").addClass("is-scrolled");
        } else {
            $(".site-header").removeClass("is-scrolled");
        }
    });
});