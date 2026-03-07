<?php

/**
 * HanaCAFE nappa69 functions and definitions
 */

/**
 * テーマのセットアップ
 */
add_action('after_setup_theme', 'hanacafe_setup');
function hanacafe_setup() {
    // titleタグを出力
    add_theme_support('title-tag');
    // アイキャッチ画像を有効化
    add_theme_support('post-thumbnails');
    // HTML5サポート
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);
}

/**
 * CSS, JSの読み込み（Food Science流）
 */
add_action('wp_enqueue_scripts', 'hanacafe_enqueue_scripts');
function hanacafe_enqueue_scripts() {
    // 1. Google Fonts（HanaCAFEのフォント指定を維持）
    wp_enqueue_style('hanacafe-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Noto+Sans+JP:wght@400;700&display=swap', [], null);

    // 2. メインCSS（app.css）
    // filemtimeを使用することで、CSSを更新するたびにブラウザキャッシュを自動でクリアします。
    wp_enqueue_style(
        'hanacafe-app-style',
        get_template_directory_uri() . '/assets/css/app.css',
        [],
        filemtime(get_template_directory() . '/assets/css/app.css')
    );

    // 3. メインJavaScript（assets/js/main.js）
    // defer（遅延読み込み）とin_footerを指定し、パフォーマンスを向上させています。
    wp_enqueue_script(
        'hanacafe-main-js',
        get_template_directory_uri() . '/assets/js/main.js',
        ['jquery'],
        filemtime(get_template_directory() . '/assets/js/main.js'),
        [
            'strategy'  => 'defer', // 遅延読み込み
            'in_footer' => true     // フッターで出力
        ]
    );
}
