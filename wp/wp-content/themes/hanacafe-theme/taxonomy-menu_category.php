<?php

/**
 * Taxonomy Template: Menu Category (カテゴリー別一覧ページ)
 * [制作意図]
 * 1. 階層構造: Food Science流の「全体 > カテゴリー > 詳細」の動的解決。
 * 2. 余白適正化: l-section を排除。
 */
get_header(); ?>

<main class="l-main">
    <section class="p-page">
        <div class="l-container">
            <div class="p-page__header">
                <p class="p-page__subtitle">MENU CATEGORY</p>
                <h1 class="p-page__title"><?php single_term_title(); ?></h1>
            </div>

            <div class="p-page__content">
                <section class="p-menu-archive">
                    <div class="p-menu__list">
                        <?php
                        if (have_posts()) :
                            while (have_posts()) : the_post();
                                get_template_part('template-parts/loop', 'menu');
                            endwhile;
                        else :
                            echo '<p class="u-text-center">準備中です。</p>';
                        endif;
                        ?>
                    </div>
                </section>
            </div>

            <div class="p-page__footer">
                <a href="<?php echo esc_url(get_post_type_archive_link('menu')); ?>" class="p-page__back-link">
                    <span class="material-symbols-outlined">arrow_back</span>
                    全メニュー一覧へ戻る
                </a>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>