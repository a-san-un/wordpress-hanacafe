<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <header class="l-header p-header">
        <div class="l-container">
            <div class="p-header__inner">

                <div class="p-header__logo-wrapper">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="p-header__logo">
                        HanaCAFE <span class="p-header__logo-sub">nappa69</span>
                    </a>
                </div>

                <nav class="p-header__nav" aria-label="PC用ナビゲーション">
                    <ul class="p-header__nav-list">
                        <li><a href="<?php echo esc_url(home_url('/')); ?>">HOME</a></li>
                        <li><a href="<?php echo esc_url(home_url('/#about')); ?>">ABOUT</a></li>
                        <li><a href="<?php echo esc_url(home_url('/#menu')); ?>">MENU</a></li>
                        <li><a href="<?php echo esc_url(home_url('/#access')); ?>">ACCESS</a></li>
                        <li><a href="<?php echo esc_url(home_url('/#news')); ?>">NEWS</a></li>
                    </ul>
                </nav>

                <button class="p-header__hamburger js-hamburger" aria-expanded="false" aria-label="メニューを開閉する">
                    <span class="material-symbols-outlined">menu</span>
                </button>

            </div>
        </div>

        <div class="p-header__drawer js-menu" aria-hidden="true">
            <nav class="p-header__drawer-nav">
                <ul class="p-header__drawer-list">
                    <li><a href="<?php echo esc_url(home_url('/')); ?>">HOME</a></li>
                    <li><a href="<?php echo esc_url(home_url('/#about')); ?>">ABOUT</a></li>
                    <li><a href="<?php echo esc_url(home_url('/#menu')); ?>">MENU</a></li>
                    <li><a href="<?php echo esc_url(home_url('/#access')); ?>">ACCESS</a></li>
                    <li><a href="<?php echo esc_url(home_url('/#news')); ?>">NEWS</a></li>
                </ul>
            </nav>
        </div>
    </header>