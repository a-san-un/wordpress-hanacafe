<?php

/**
 * HanaCAFE nappa69 Functions and Definitions
 * * 役割: テーマの機能拡張、外部ファイルの読み込み制御（SSOT）
 */

/**
 * 1. テーマの基本セットアップ
 * * 公式ドキュメントに基づき、after_setup_themeフックを使用。
 * 子テーマでの上書きを考慮し、function_existsチェックを推奨（プロの習慣）。
 */
if (!function_exists('hanacafe_setup')) {
    function hanacafe_setup() {
        // <title>タグをWordPressが自動生成
        add_theme_support('title-tag');

        // アイキャッチ画像の有効化
        add_theme_support('post-thumbnails');

        // HTML5サポート（最新のセマンティックなマークアップに対応）
        add_theme_support('html5', [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script'
        ]);

        // カスタムメニューの登録（管理画面からメニューを編集可能にする準備）
        register_nav_menus([
            'global-nav' => 'グローバルナビゲーション',
            'drawer-nav' => 'ドロワーナビゲーション',
        ]);
    }
}
add_action('after_setup_theme', 'hanacafe_setup');

/**
 * 2. アセット（CSS/JS）の読み込み
 * * WordPress 6.3以降の最新仕様（strategyパラメータ）を適用。
 * filemtimeによるキャッシュ自動クリアも継続実装。
 */
function hanacafe_enqueue_scripts() {
    // --- Google Fonts & Icons ---
    // 複数フォントを一括で読み込み。display=swapでフォント読み込み中のテキスト表示を担保。
    $fonts_url = 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Noto+Sans+JP:wght@400;700&family=Noto+Serif+JP:wght@700&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap';
    wp_enqueue_style('hanacafe-fonts', $fonts_url, [], null);

    // --- メインCSS (app.css) ---
    $app_css_path = '/assets/css/app.css';
    wp_enqueue_style(
        'hanacafe-app-style',
        get_template_directory_uri() . $app_css_path,
        ['hanacafe-fonts'], // フォントの後に読み込む依存関係を定義
        filemtime(get_template_directory() . $app_css_path)
    );

	// --- メインJavaScript (main.js) ---
    /**
     * 最新の公式仕様（WP 6.3+）:
     * $in_footerパラメータが配列に拡張され、'strategy' => 'defer' が指定可能になりました。
     */
    $main_js_path = '/assets/js/main.js';
    wp_enqueue_script(
        'hanacafe-main-js',
        get_template_directory_uri() . $main_js_path,
        ['jquery'], // WordPress同梱のjQueryを先に読み込む
        filemtime(get_template_directory() . $main_js_path),
        [
            'strategy'  => 'defer', // 【最新】ブラウザがHTML解析後にスクリプトを実行
            'in_footer' => true,    // フッターでの出力を維持
        ]
    );
}
add_action('wp_enqueue_scripts', 'hanacafe_enqueue_scripts');

/**
 * 3. セキュリティ/最適化
 * * 余計な情報をheadから削除（公式ベストプラクティス）
 */
remove_action('wp_head', 'wp_generator'); // WPバージョンの非表示