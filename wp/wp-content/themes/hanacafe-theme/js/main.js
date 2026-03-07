/**
 * HanaCAFE nappa69 Main JavaScript
 */

jQuery(function($) {
    /**
     * ハンバーガーメニューとドロワーの制御
     */
    const $hamburger = $('.js-hamburger');
    const $drawer = $('.js-menu');
    let isShow = false;

    $hamburger.on('click', function() {
        // アクセシビリティ：開閉状態を通知
        const expanded = $(this).attr('aria-expanded') === 'true';
        $(this).attr('aria-expanded', !expanded);

        if (!isShow) {
            // メニューを開く
            $hamburger.addClass('is-active');
            $drawer.addClass('is-active').attr('aria-hidden', 'false');
            $('body').css('overflow', 'hidden'); // 背後をスクロールさせない
            isShow = true;
        } else {
            // メニューを閉じる
            $hamburger.removeClass('is-active');
            $drawer.removeClass('is-active').attr('aria-hidden', 'true');
            $('body').css('overflow', 'auto');
            isShow = false;
        }
    });

    /**
     * ドロワー内のリンクをクリックしたら閉じる
     */
    $('.js-menu a').on('click', function() {
        if (isShow) {
            $hamburger.removeClass('is-active').attr('aria-expanded', 'false');
            $drawer.removeClass('is-active').attr('aria-hidden', 'true');
            $('body').css('overflow', 'auto');
            isShow = false;
        }
    });

    /**
     * ヘッダーのスクロール検知 (20px)
     */
    const $header = $('.l-header');
    $(window).on('scroll', function() {
        if ($(this).scrollTop() > 20) {
            $header.addClass('is-scrolled');
        } else {
            $header.removeClass('is-scrolled');
        }
    });
});