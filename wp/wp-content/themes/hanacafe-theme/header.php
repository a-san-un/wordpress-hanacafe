<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <header class="l-header">
        <div class="l-container">
            <div class="l-header__inner">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="p-header__logo">
                    HanaCAFE <span class="p-header__logo-sub">nappa69</span>
                </a>

                <nav class="p-header__nav">
                    <ul class="p-header__nav-list">
                        <?php /* HOMEを復活 */ ?>
                        <li><a href="<?php echo esc_url(home_url('/')); ?>">HOME</a></li>
                        <li><a href="#about">ABOUT</a></li>
                        <li><a href="#menu">MENU</a></li>
                        <li><a href="#access">ACCESS</a></li>
                        <li><a href="#news">NEWS</a></li>
                    </ul>
                </nav>

                <button class="p-header__hamburger js-hamburger" aria-label="メニューを開く">
                    <span class="material-symbols-outlined">menu</span>
                </button>
            </div>
        </div>
    </header>