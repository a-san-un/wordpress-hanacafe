<?php

/**
 * Header template
 */

// DRY原則：ナビゲーション項目を配列で定義
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
    <?php // Google Fonts / Icons の読み込み（文字化け解消用） 
    ?>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <header class="l-header p-header js-header">
        <div class="l-container">
            <div class="p-header__inner">

                <?php // ロゴ：常に左端へ配置 
                ?>
                <div class="p-header__logo-wrapper">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="p-header__logo">
                        HanaCAFE <span class="p-header__logo-sub">nappa69</span>
                    </a>
                </div>

                <?php // PCナビ：常に右端へ配置（SPでは非表示） 
                ?>
                <nav class="p-header__nav u-desktop" aria-label="PC用ナビゲーション">
                    <ul class="p-header__nav-list">
                        <?php foreach ($nav_items as $label => $url) : ?>
                            <li class="p-header__nav-item">
                                <a href="<?php echo esc_url($url); ?>" class="p-header__nav-link"><?php echo esc_html($label); ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>

                <?php // SPハンバーガー：SP時のみ右端に表示 
                ?>
                <button class="p-header__hamburger js-hamburger u-mobile" aria-expanded="false" aria-controls="drawer-menu" aria-label="メニューを開く">
                    <span class="material-symbols-outlined">menu</span>
                </button>

            </div>
        </div>
    </header>

    <?php // SP用ドロワーメニュー 
    ?>
    <div class="p-drawer js-drawer" id="drawer-menu" aria-hidden="true">
        <div class="p-drawer__inner">
            <nav class="p-drawer__nav">
                <ul class="p-drawer__list">
                    <?php foreach ($nav_items as $label => $url) : ?>
                        <li class="p-drawer__item">
                            <a href="<?php echo esc_url($url); ?>" class="p-drawer__link"><?php echo esc_html($label); ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </div>
    </div>