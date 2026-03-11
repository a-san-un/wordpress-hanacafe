<?php

/**
 * Header template
 *
 * [設計意図]
 * 1. JS有効判定の導入: <html>タグ直前にJSで .js-enabled クラスを付与。
 *    これにより、CSS側で「JSが動く時だけ初期状態を隠す（演出）」という制御が可能になる。
 * 2. 表示保証（Anti-Blackout）: JSが読み込まれない、あるいはオフの場合はクラスが付かないため、
 *    CSSの初期値(opacity:1)が維持され、コンテンツが消失しない。
 * 3. 非破壊の原則: 既存のナビゲーション配列、A11Y属性（aria-label等）、
 *    およびロゴ構造を完全に維持。
 */


// -----------------------------------------------------------
// ナビゲーション定義
// DRY原則: メニュー項目を連想配列で一元管理。
// キー = 表示ラベル, 値 = リンク先URL
// 追加・変更はこの配列のみ編集すればよい。
// -----------------------------------------------------------
$nav_items = [
    'HOME'   => home_url('/'),
    'ABOUT'  => home_url('/#about'),
    'MENU'   => home_url('/#menu'),
    'ACCESS' => home_url('/#access'),
    'NEWS'   => home_url('/#news'),
];
?>

<!DOCTYPE html>

<!--
    JS有効判定スクリプト（インライン・同期実行）
    DOMの解析開始と同時に .js-enabled を <html> に付与することで、
    CSSによるアニメーション初期状態の制御（FOUC防止）を実現する。
    wp_head() より前に実行する必要があるため、<head> 外に配置している。
-->
<script>
    document.documentElement.classList.add('js-enabled');
</script>

<html <?php language_attributes(); /* lang属性をWordPressの設定から動的出力 */ ?>>

<head>
    <meta charset="<?php bloginfo('charset'); /* 文字コードをWordPress設定から取得 */ ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    /**
     * wp_head() フック
     * CSSやフォント（Material Symbols等）の<link>タグは
     * functions.php の wp_enqueue_scripts 経由で出力する。
     * ここに直書きの<link>タグを置かないことで、
     * キャッシュ管理・依存関係の制御をWordPressに委ねる。
     */
    wp_head();
    ?>
</head>

<body <?php body_class(); /* テンプレート・条件に応じたクラスを自動付与 */ ?>>
    <?php wp_body_open(); /* <body>直後のフック。GTM等のスクリプト挿入に使用 */ ?>

    <!-- =============================================
         サイトヘッダー
         .js-header : JSによるスクロール固定・非表示制御の対象
    ============================================= -->
    <header class="l-header p-header js-header">
        <div class="l-container">
            <div class="p-header__inner">

                <!-- ロゴエリア: テキストロゴ + サブテキスト構成 -->
                <div class="p-header__logo-wrapper">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="p-header__logo">
                        HanaCAFE <span class="p-header__logo-sub">nappa69</span>
                    </a>
                </div>

                <?php
                // ナビゲーションが空でないことを確認してから出力（防御的レンダリング）
                if (!empty($nav_items)) : ?>
                    <!-- PC用ナビゲーション: .u-desktop によりモバイルでは非表示 -->
                    <nav class="p-header__nav u-desktop" aria-label="PC用ナビゲーション">
                        <ul class="p-header__nav-list">
                            <?php foreach ($nav_items as $label => $url) : ?>
                                <li class="p-header__nav-item">
                                    <!-- esc_url / esc_html でXSS対策 -->
                                    <a href="<?php echo esc_url($url); ?>" class="p-header__nav-link">
                                        <?php echo esc_html($label); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </nav>
                <?php endif; ?>

                <!--
                    ハンバーガーボタン（モバイル専用）
                    - aria-expanded : ドロワーの開閉状態をスクリーンリーダーに伝える（JSで動的更新）
                    - aria-controls : 操作対象要素のIDを明示（A11Y）
                    - .u-mobile    : PCでは非表示
                -->
                <button
                    class="p-header__hamburger js-hamburger u-mobile"
                    aria-expanded="false"
                    aria-controls="drawer-menu"
                    aria-label="メニューを開く">
                    <span class="material-symbols-outlined" aria-hidden="true">menu</span>
                </button>

            </div>
        </div>
    </header>

    <!-- =============================================
         ドロワーメニュー（モバイル用オーバーレイナビ）
         - aria-hidden="true" : 初期状態では非表示（JSで開閉時に切り替え）
         - id="drawer-menu"   : ハンバーガーボタンの aria-controls と対応
    ============================================= -->
    <div class="p-drawer js-drawer" id="drawer-menu" aria-hidden="true">
        <div class="p-drawer__inner">
            <nav class="p-drawer__nav" aria-label="モバイル用ナビゲーション">
                <ul class="p-drawer__list">
                    <?php
                    // PCナビと同じ $nav_items を再利用（DRY原則）
                    foreach ($nav_items as $label => $url) : ?>
                        <li class="p-drawer__item">
                            <a href="<?php echo esc_url($url); ?>" class="p-drawer__link">
                                <?php echo esc_html($label); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </div>
    </div>