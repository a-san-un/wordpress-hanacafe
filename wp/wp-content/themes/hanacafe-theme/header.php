<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;400;500;700&family=Noto+Sans+JP:wght@100;300;400;500;700&family=Noto+Serif+JP:wght@200;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <header class="site-header">
        <div class="header-inner">
            <a class="header-logo" href="<?php echo esc_url(home_url('/')); ?>">
                <span class="logo-hanacafe">HanaCAFE</span>
                <span class="logo-nappa">nappa69</span>
            </a>

            <nav class="header-nav js-menu">
                <a href="<?php echo esc_url(home_url('/')); ?>">HOME</a>
                <a href="<?php echo esc_url(home_url('/')); ?>#about">ABOUT</a>
                <a href="<?php echo esc_url(home_url('/')); ?>#menu">MENU</a>
                <a href="<?php echo esc_url(home_url('/')); ?>#access">ACCESS</a>
                <a href="<?php echo esc_url(home_url('/')); ?>#news">NEWS</a>
            </nav>

            <button class="mobile-menu-btn js-hamburger" aria-label="メニュー">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </div>
    </header>