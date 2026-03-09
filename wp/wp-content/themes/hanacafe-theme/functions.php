<?php

/**
 * HanaCAFE nappa69 Functions and Definitions
 * * 役割: テーマの機能拡張、外部ファイルの読み込み制御（SSOT）
 * * 更新日: 2026-03-09 - メニューアーカイブの表示件数制御を追加
 */

/**
 * 1. テーマの基本セットアップ
 */
if (!function_exists('hanacafe_setup')) {
    function hanacafe_setup() {
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('html5', [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script'
        ]);

        register_nav_menus([
            'global-nav' => 'グローバルナビゲーション',
            'drawer-nav' => 'ドロワーナビゲーション',
        ]);
    }
}
add_action('after_setup_theme', 'hanacafe_setup');

/**
 * 2. アセット（CSS/JS）の読み込み
 */
function hanacafe_enqueue_scripts() {
    // --- Google Fonts & Icons ---
    $fonts_url = 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Noto+Sans+JP:wght@400;700&family=Noto+Serif+JP:wght@700&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap';
    wp_enqueue_style('hanacafe-fonts', $fonts_url, [], null);

    // --- メインCSS (app.css) ---
    $app_css_path = '/assets/css/app.css';
    wp_enqueue_style(
        'hanacafe-app-style',
        get_template_directory_uri() . $app_css_path,
        ['hanacafe-fonts'],
        filemtime(get_template_directory() . $app_css_path)
    );

    // --- メインJavaScript (main.js) ---
    $main_js_path = '/assets/js/main.js';
    wp_enqueue_script(
        'hanacafe-main-js',
        get_template_directory_uri() . $main_js_path,
        ['jquery'],
        filemtime(get_template_directory() . $main_js_path),
        [
            'strategy'  => 'defer',
            'in_footer' => true,
        ]
    );
}
add_action('wp_enqueue_scripts', 'hanacafe_enqueue_scripts');

/**
 * 3. クエリのカスタマイズ（表示件数制御）
 * * メニュー一覧（archive-menu）ではページネーションを行わず全件表示にする。
 * * 根拠: カフェのメニュー表として、途中でページが分かれるUXを避けるため。
 */
function hanacafe_pre_get_posts($query) {
    // 管理画面やメインクエリ以外には干渉しない
    if (is_admin() || ! $query->is_main_query()) {
        return;
    }

    // カスタム投稿タイプ 'menu' のアーカイブページの場合
    if ($query->is_post_type_archive('menu')) {
        $query->set('posts_per_page', -1); // 全件取得
    }
}
add_action('pre_get_posts', 'hanacafe_pre_get_posts');

/**
 * 4. セキュリティ/最適化
 */
remove_action('wp_head', 'wp_generator');
