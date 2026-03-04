<?php

/**
 * HanaCAFE nappa69 functions and definitions
 *
 * @package hanacafe-theme
 */

function hanacafe_setup()
{
    // タイトルタグの自動生成
    add_theme_support('title-tag');
    // アイキャッチ画像の有効化
    add_theme_support('post-thumbnails');
    // HTML5サポート
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
}
add_action('after_setup_theme', 'hanacafe_setup');

/**
 * スクリプトとスタイルの読み込み
 */
function hanacafe_scripts()
{
    // メインのCSS
    wp_enqueue_style('hanacafe-style', get_stylesheet_uri(), array(), '1.0.0');

    // Google Fonts
    wp_enqueue_style('hanacafe-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Noto+Sans+JP:wght@400;500;700&family=Noto+Serif+JP:wght@700&display=swap', array(), null);

    // Tailwind CSS CDN (制作フェーズ用)
    wp_enqueue_script('tailwind-cdn', 'https://cdn.tailwindcss.com', array(), null, false);

    // Material Symbols
    wp_enqueue_style('material-symbols', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0', array(), null);

    // メインのJavaScript（Intersection Observer用）を追加
    wp_enqueue_script('hanacafe-main', get_template_directory_uri() . '/js/main.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'hanacafe_scripts');
