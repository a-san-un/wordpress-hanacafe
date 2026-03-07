<?php

/**
 * Header template
 * * @package HanaCAFE_nappa69
 */

// DRY原則：ナビゲーション項目を変数（配列）で定義。将来のメニュー追加・変更を容易にする。
$nav_items = [
    'HOME'   => home_url('/'),
    'ABOUT'  => home_url('/#about'),
    'MENU'   => home_url('/#menu'),
    'ACCESS' => home_url('/#access'),
    'NEWS'   => home_url('/#news'),
];
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    // 外部フォント（Material Symbols等）はfunctions.phpからwp_enqueue_scripts経由で安全に読み込むため、
    // ここでの直書き<link>タグは排除。
    wp_head();
    ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <header class="l-header p-header js-header">
        <div class="l-container">
            <div class="p-header__inner">

                <div class="p-header__logo-wrapper">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="p-header__logo">
                        HanaCAFE <span class="p-header__logo-sub">nappa69</span>
                    </a>
                </div>

                <?php if (!empty($nav_items)) : ?>
                    <nav class="p-header__nav u-desktop" aria-label="PC用ナビゲーション">
                        <ul class="p-header__nav-list">
                            <?php foreach ($nav_items as $label => $url) : ?>
                                <li class="p-header__nav-item">
                                    <a href="<?php echo esc_url($url); ?>" class="p-header__nav-link">
                                        <?php echo esc_html($label); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </nav>
                <?php endif; ?>

                <button class="p-header__hamburger js-hamburger u-mobile" aria-expanded="false" aria-controls="drawer-menu" aria-label="メニューを開く">
                    <span class="material-symbols-outlined" aria-hidden="true">menu</span>
                </button>

            </div>
        </div>
    </header>

    <div class="p-drawer js-drawer" id="drawer-menu" aria-hidden="true">
        <div class="p-drawer__inner">
            <nav class="p-drawer__nav" aria-label="モバイル用ナビゲーション">
                <ul class="p-drawer__list">
                    <?php foreach ($nav_items as $label => $url) : ?>
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