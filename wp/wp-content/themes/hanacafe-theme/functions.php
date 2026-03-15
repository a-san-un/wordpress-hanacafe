<?php

/**
 * HanaCAFE nappa69 Functions and Definitions
 * * 役割: テーマの機能拡張、外部ファイルの読み込み制御（SSOT）
 * * 更新日: 2026-03-15 - グローバルナビBEMクラス注入フィルターを追加
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
 */
function hanacafe_pre_get_posts($query) {
    if (is_admin() || ! $query->is_main_query()) {
        return;
    }

    if ($query->is_post_type_archive('menu')) {
        $query->set('posts_per_page', -1);
    }
}
add_action('pre_get_posts', 'hanacafe_pre_get_posts');

/**
 * 4. セキュリティ/最適化
 */
remove_action('wp_head', 'wp_generator');

/**
 * トップページ用：Menu投稿取得関数
 * 未選択の場合は、自動的に最新1件を取得するフォールバック機能付き。
 */
function get_hanacafe_top_menu_post($field_name, $term_slug) {
    $post_obj = get_field($field_name);
    if ($post_obj) {
        return $post_obj;
    }

    $args = [
        'post_type'      => 'menu',
        'posts_per_page' => 1,
        'tax_query'      => [
            [
                'taxonomy' => 'menu_category',
                'field'    => 'slug',
                'terms'    => $term_slug,
            ]
        ],
    ];
    $query = new WP_Query($args);
    return $query->have_posts() ? $query->posts : null;
}
/**
 * 5. メニューにBEMクラスを強制注入するフィルター (非破壊規約準拠)
 */
add_filter('nav_menu_css_class', function ($classes, $item, $args) {
    if ($args->theme_location === 'global-nav') {
        $classes[] = 'p-header__nav-item';
    } elseif ($args->theme_location === 'drawer-nav') {
        $classes[] = 'p-drawer__item';
    }
    return $classes;
}, 10, 3);

add_filter('nav_menu_link_attributes', function ($atts, $item, $args) {
    if ($args->theme_location === 'global-nav') {
        $atts['class'] = 'p-header__nav-link';
    } elseif ($args->theme_location === 'drawer-nav') {
        $atts['class'] = 'p-drawer__link';
    }
    return $atts;
}, 10, 3);

/**
 * 6. カスタムリンクのルート相対パスを動的に解決する (サブディレクトリ・移設対策)
 * [設計意図] 管理画面で /# で始まる相対パスが設定された場合、出力時に自動で
 * home_url() を付与し、環境に依存しない絶対パスへ変換する [3, 4]。
 */
add_filter('nav_menu_link_attributes', function ($atts, $item, $args) {
    if (isset($atts['href']) && strpos($atts['href'], '/#') === 0) {
        $atts['href'] = home_url($atts['href']);
    }
    return $atts;
}, 20, 3);
