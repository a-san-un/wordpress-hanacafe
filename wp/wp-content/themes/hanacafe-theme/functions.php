<?php

/**
 * HanaCAFE nappa69 Functions and Definitions
 * * 役割: テーマの機能拡張、外部ファイルの読み込み制御（SSOT）
 * * 更新日: 2026-03-17 - ACFフィールド名の一致と表示保証クラスの追加
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
 * スラッグから固定ページIDを取得するヘルパー関数
 */
function get_hanacafe_master_page_id($slug) {
    $page = get_page_by_path($slug);
    return $page ? $page->ID : false;
}

/**
 * デフォルト画像を取得する関数 (CMS連動)
 * [SSOT] フィールド名を site_default_image に統一
 */
function get_hanacafe_default_image_url($slug = 'common-info') {
    $page_id = get_hanacafe_master_page_id($slug);

    // ACF設定名 'site_default_image' と完全に一致させる
    $img_val = $page_id ? get_field('site_default_image', $page_id) : '';
    $img_url = '';

    if (is_array($img_val) && isset($img_val['url'])) {
        $img_url = $img_val['url'];
    } elseif (is_string($img_val)) {
        $img_url = $img_val;
    }

    if ($img_url) {
        return esc_url($img_url);
    }

    // 最終防衛ライン
    return esc_url(get_theme_file_uri('/assets/images/coming-soon.jpg'));
}

/**
 * アイキャッチ画像がない場合にグローバルデフォルト画像を表示するフィルター
 */
function hanacafe_fallback_thumbnail_html($html, $post_id, $post_thumbnail_id, $size, $attr) {
    if (empty($html) && ! is_admin()) {
        $default_img_url = get_hanacafe_default_image_url();
        $alt_text = esc_attr(get_the_title($post_id) . ' の代替画像');

        // フィルター経由であることを示す p-common-placeholder を追加
        $base_class = isset($attr['class']) ? $attr['class'] : 'wp-post-image';
        $class = $base_class . ' p-common-placeholder';

        $html = sprintf(
            '<img src="%s" alt="%s" class="%s" />',
            $default_img_url,
            $alt_text,
            esc_attr($class)
        );
    }
    return $html;
}
add_filter('post_thumbnail_html', 'hanacafe_fallback_thumbnail_html', 10, 5);

/**
 * トップページ用：Menu投稿取得関数
 */
function get_hanacafe_top_menu_post($field_name, $term_slug) {
    $post_obj = get_field($field_name, get_hanacafe_master_page_id('menu-info'));
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
 * 5. メニューにBEMクラスを強制注入するフィルター
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
 * 6. カスタムリンクのルート相対パスを動的に解決する
 */
add_filter('nav_menu_link_attributes', function ($atts, $item, $args) {
    if (isset($atts['href']) && strpos($atts['href'], '/#') === 0) {
        $atts['href'] = home_url($atts['href']);
    }
    return $atts;
}, 20, 3);

/**
 * 7. カスタム投稿タイプ：メインビジュアルの登録
 */
function hc_register_main_visual() {
    $args = [
        'label'               => 'メインビジュアル',
        'public'              => true,
        'has_archive'         => false,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-format-image',
        'show_in_rest'        => true,
        'supports'            => ['title', 'thumbnail', 'page-attributes'],
        'hierarchical'        => false,
    ];
    register_post_type('main-visual', $args);
}
add_action('init', 'hc_register_main_visual');


/**
 * 8. オリジナル画像のAlt属性自動補完
 * [設計意図] 運用者が代替テキストの入力を忘れた場合でも、自動で記事タイトルを補完する。
 */
add_filter('post_thumbnail_html', function($html, $post_id) {
    // alt属性が空（alt="" または alt=''）かどうかを正規表現でチェック
    if (preg_match('/alt=(["\'])\1/', $html)) {
        $title = esc_attr(get_the_title($post_id));
        // 空のalt属性を記事タイトルで置換（最初に一致したもの1つだけ）
        $html = preg_replace('/alt=(["\'])\1/', 'alt="' . $title . '"', $html, 1);
    }
    return $html;
}, 20, 2);
