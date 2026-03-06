<?php

/**
 * Template Name: コンセプトページ
 */
get_header(); ?>

<main class="l-main">
    <article class="p-page">
        <div class="l-container">

            <header class="p-page__header">
                <h1 class="p-page__title"><?php echo esc_html(get_the_title()); ?></h1>
                <p class="u-text-center">空間について</p>
            </header>

            <div class="p-page__content">
                <?php
                if (have_posts()) :
                    while (have_posts()) : the_post();
                        the_content(); // ★ ここに管理画面の文章が出ます
                    endwhile;
                endif;
                ?>
            </div>

            <div class="p-page__footer">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="p-page__back-link">
                    <span class="material-symbols-outlined">arrow_back_ios</span>
                    TOPページへ戻る
                </a>
            </div>

        </div>
    </article>
</main>

<?php get_footer(); ?>