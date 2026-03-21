<?php

/**
 * HanaCAFE Theme Functions
 * WordPress 6.9 / ACF / CPTUI
 */

// ============================================================
// 1. テーマセットアップ
// ============================================================
add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    register_nav_menus([
        'global-nav' => 'グローバルナビゲーション',
        'drawer-nav' => 'ドロワーナビゲーション',
    ]);
});

// ============================================================
// 2. アセット読み込み
// ============================================================

// Google Fonts preconnect タグ変換（グローバルで1回だけ登録）
add_filter('style_loader_tag', function ($html, $handle) {
    $preconnects = ['hanacafe-fonts-preconnect-1', 'hanacafe-fonts-preconnect-2'];
    return in_array($handle, $preconnects, true)
        ? str_replace("rel='stylesheet'", "rel='preconnect' crossorigin", $html)
        : $html;
}, 10, 2);

add_action('wp_enqueue_scripts', function () {
    $dir = get_template_directory();
    $uri = get_template_directory_uri();

    wp_enqueue_style('hanacafe-fonts-preconnect-1', 'https://fonts.googleapis.com', [], null);
    wp_enqueue_style('hanacafe-fonts-preconnect-2', 'https://fonts.gstatic.com', [], null);
    wp_enqueue_style(
        'hanacafe-fonts',
        'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Noto+Sans+JP:wght@400;700&family=Noto+Serif+JP:wght@700&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap',
        [],
        null
    );
    wp_enqueue_style(
        'hanacafe-app-style',
        $uri . '/assets/css/app.css',
        ['hanacafe-fonts'],
        filemtime($dir . '/assets/css/app.css')
    );
    wp_enqueue_script(
        'hanacafe-main-js',
        $uri . '/assets/js/main.js',
        [],
        filemtime($dir . '/assets/js/main.js'),
        ['strategy' => 'defer', 'in_footer' => true]
    );
});

// ============================================================
// 3. クエリ・テンプレート制御
// ============================================================
add_action('pre_get_posts', function ($query) {
    if (!is_admin() && $query->is_main_query() && $query->is_post_type_archive('menu')) {
        $query->set('posts_per_page', -1);
    }
});

add_filter('template_include', function ($template) {
    return is_home() && ($t = locate_template('archive-post.php')) ? $t : $template;
});

// ============================================================
// 4. ヘルパー関数（テンプレートから呼び出す／複数箇所で使用）
// ============================================================

/** スラッグから固定ページIDを取得 */
function get_hanacafe_master_page_id($slug) {
    $page = get_page_by_path($slug);
    return $page ? $page->ID : false;
}

/** ACF連動デフォルト画像URL（フォールバック付き） */
function get_hanacafe_default_image_url($slug = 'common-info') {
    $img_val = ($id = get_hanacafe_master_page_id($slug)) ? get_field('site_default_image', $id) : '';
    $url = is_array($img_val) ? ($img_val['url'] ?? '') : (is_string($img_val) ? $img_val : '');
    return esc_url($url ?: get_theme_file_uri('/assets/images/coming-soon.jpg'));
}

/** ニュース一覧ページURL */
function get_hanacafe_news_page_url() {
    $id = get_option('page_for_posts');
    return $id ? get_permalink($id) : home_url('/news/');
}

/** トップページ用メニュー投稿取得（menu.php から呼び出し） */
function get_hanacafe_top_menu_post($field_name, $term_slug) {
    $post_obj = get_field($field_name, get_hanacafe_master_page_id('menu-info'));
    if ($post_obj) return $post_obj;

    $query = new WP_Query([
        'post_type'      => 'menu',
        'posts_per_page' => 1,
        'tax_query'      => [[
            'taxonomy' => 'menu_category',
            'field'    => 'slug',
            'terms'    => $term_slug,
        ]],
    ]);
    return $query->have_posts() ? $query->posts[0] : null;
}

// ============================================================
// 5. 画像フォールバック & Alt補完
// ============================================================

/** アイキャッチ未設定時にデフォルト画像を表示（優先度10・引数5個必須） */
function hanacafe_fallback_thumbnail_html($html, $post_id, $post_thumbnail_id, $size, $attr) {
    if (!empty($html) || is_admin()) return $html;
    $class = esc_attr((isset($attr['class']) ? $attr['class'] : 'wp-post-image') . ' p-common-placeholder');
    return sprintf(
        '<img src="%s" alt="%s" class="%s" />',
        get_hanacafe_default_image_url(),
        esc_attr(get_the_title($post_id) . ' の代替画像'),
        $class
    );
}
add_filter('post_thumbnail_html', 'hanacafe_fallback_thumbnail_html', 10, 5);

/** Alt属性が空の場合に記事タイトルで補完（優先度20） */
add_filter('post_thumbnail_html', function ($html, $post_id) {
    return preg_match('/alt=(["\'])\1/', $html)
        ? preg_replace('/alt=(["\'])\1/', 'alt="' . esc_attr(get_the_title($post_id)) . '"', $html, 1)
        : $html;
}, 20, 2);

// ============================================================
// 6. ナビゲーション BEM クラス / リンク属性
// ============================================================
add_filter('nav_menu_css_class', function ($classes, $item, $args) {
    if ($args->theme_location === 'global-nav') $classes[] = 'l-header__nav-item';
    elseif ($args->theme_location === 'drawer-nav') $classes[] = 'p-drawer__item';
    return $classes;
}, 10, 3);

add_filter('nav_menu_link_attributes', function ($atts, $item, $args) {
    if ($args->theme_location === 'global-nav')     $atts['class'] = 'l-header__nav-link';
    elseif ($args->theme_location === 'drawer-nav') $atts['class'] = 'p-drawer__link';
    if (isset($atts['href']) && str_starts_with($atts['href'], '/#')) {
        $atts['href'] = home_url($atts['href']);
    }
    return $atts;
}, 10, 3);

// ============================================================
// 7. セキュリティ最適化
// ============================================================
remove_action('wp_head', 'wp_generator');
