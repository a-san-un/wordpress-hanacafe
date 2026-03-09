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

/**
 * ===================================================
 * 1. トップページ用：Menu投稿取得関数
 * ===================================================
 * 目的: トップページに表示するメニューをACFのポストオブジェクトから取得。
 * 未選択の場合は、自動的に最新1件を取得するフォールバック機能付き。
 * * @param string $field_name ACFのフィールド名（例: 'top_menu_food'）
 * @param string $term_slug  タクソノミースラッグ（例: 'food'）
 * @return WP_Post|null      投稿オブジェクト、存在しない場合は null
 */
function get_hanacafe_top_menu_post($field_name, $term_slug) {

    // [ステップ1] ACFのポストオブジェクト（固定ページID: トップページ）からデータを取得
    // ※今回はトップページで実行される前提なので、get_field() でそのまま取れます。
    $post_obj = get_field($field_name);

    // [ステップ2] ACFで選択されていれば、そのままそのオブジェクトを返す（第1優先）
    if ($post_obj) {
        return $post_obj;
    }

    // [ステップ3] ACFが未選択の場合、バックアップとして最新の1件を取得する（第2優先）
    $args = [
        'post_type'      => 'menu',         // カスタム投稿「menu」を指定
        'posts_per_page' => 1,              // 1件だけ取得
        'tax_query'      => [               // タクソノミー（カテゴリー）での絞り込み
            [
                'taxonomy' => 'menu_category',
                'field'    => 'slug',
                'terms'    => $term_slug,
            ]
        ],
    ];
    $query = new WP_Query($args);

    // [ステップ4] 取得できた場合はその1件目の投稿オブジェクトを返し、無ければ null を返す
    return $query->have_posts() ? $query->posts[0] : null;
}
