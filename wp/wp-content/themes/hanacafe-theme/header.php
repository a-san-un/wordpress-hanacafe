<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <header class="site-header">
        <div class="header-inner">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="header-logo">
                <span class="logo-hanacafe">HanaCAFE</span>
                <span class="logo-nappa">nappa69</span>
            </a>

            <nav class="header-nav js-menu">
                <a href="<?php echo esc_url(home_url('/')); ?>">HOME</a>
                <a href="<?php echo esc_url(home_url('/#about')); ?>">ABOUT</a>
                <a href="<?php echo esc_url(home_url('/#menu')); ?>">MENU</a>
                <a href="<?php echo esc_url(home_url('/#access')); ?>">ACCESS</a>
                <a href="<?php echo esc_url(home_url('/#news')); ?>">NEWS</a>
            </nav>

            <button type="button" class="header-hamburger js-hamburger" aria-label="メニューを開く">
                <span class="material-symbols-outlined icon-menu">menu</span>
                <span class="material-symbols-outlined icon-close">close</span>
            </button>
        </div>
    </header>

    <main class="site-main">