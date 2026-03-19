<?php

/**
 * Header template
 *
 * [設計意図]
 * 1. 完全CMS化: wp_nav_menu() に移行し、オーナーが管理画面から更新可能に。
 * 2. 非破壊の原則: container => false とフィルターを駆使し、FLOCSS BEM構造を100%維持。
 * 3. 表示保証（Anti-Blackout）: JS有効判定用 .js-enabled 付与の同期実行を継続。
 */
?>
<!DOCTYPE html>
<!--
JS有効判定スクリプト（インライン・同期実行）
DOMの解析開始と同時に .js-enabled を <html> に付与することで、
CSSによるアニメーション初期状態の制御（FOUC防止）を実現する。
wp_head() より前に実行する必要があるため、<head> 外に配置している。
-->

<html <?php language_attributes(); ?>>

<head>
    <script>
        // [fix 1-1]
        document.documentElement.classList.add('js-enabled');
    </script>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <header class="l-header p-header js-header">
        <div class="l-container">
            <div class="p-header__inner">

                <!-- ロゴエリア -->
                <div class="p-header__logo-wrapper">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="p-header__logo">
                        HanaCAFE <span class="p-header__logo-sub">nappa69</span>
                    </a>
                </div>

                <!-- PC用ナビゲーション (CMS連動版) -->
                <nav class="p-header__nav u-desktop" aria-label="PC用ナビゲーション">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'global-nav',
                        'container'      => false,
                        'menu_class'     => 'p-header__nav-list',
                        'fallback_cb'    => false,
                        'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                        'depth'          => 1,
                    ]);
                    ?>
                </nav>

                <!-- ハンバーガーボタン（モバイル専用） -->
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

    <!-- ドロワーメニュー（モバイル用オーバーレイナビ） -->
    <div class="p-drawer js-drawer" id="drawer-menu" aria-hidden="true">
        <div class="p-drawer__inner">
            <button class="p-drawer__close js-drawer-close" aria-label="メニューを閉じる">
                <span class="material-symbols-outlined" aria-hidden="true">close</span>
            </button>
            <nav class="p-drawer__nav" aria-label="モバイル用ナビゲーション">
                <?php
                wp_nav_menu([
                    'theme_location' => 'drawer-nav',
                    'container'      => false,
                    'menu_class'     => 'p-drawer__list',
                    'fallback_cb'    => false,
                    'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    'depth'          => 1,
                ]);
                ?>
            </nav>
        </div>
    </div>