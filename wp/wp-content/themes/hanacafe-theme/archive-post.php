<?php

/**
 * Template: Archive
 * [設計意図]
 * カテゴリーやタグなどのアーカイブを表示するテンプレート。
 * 複数の投稿をリスト形式で表示し、ページネーション機能を提供。
 */
get_header(); ?>

<main class="l-main">
    <article class="p-page">
        <div class="l-container">

            <header class="p-page__header">
                <h1 class="p-page__title"><?php echo wp_kses_post(get_the_archive_title()); ?></h1>
            </header>

            <div class="p-page__content">
                <?php if (have_posts()) : ?>

                    <ul class="p-archive__list">
                        <?php while (have_posts()) : the_post(); ?>
                            <li class="p-archive__item">
                                <article class="p-archive-card">
                                    <h2 class="p-archive-card__title">
                                        <a href="<?php the_permalink(); ?>" class="p-archive-card__link">
                                            <?php echo esc_html(get_the_title()); ?>
                                        </a>
                                    </h2>
                                    <time class="p-archive-card__date" datetime="<?php echo get_the_date('c'); ?>">
                                        <?php echo esc_html(get_the_date('Y.m.d')); ?>
                                    </time>
                                    <div class="p-archive-card__excerpt">
                                        <?php echo wp_kses_post(get_the_excerpt()); ?>
                                    </div>
                                </article>
                            </li>
                        <?php endwhile; ?>
                    </ul>

                    <div class="p-archive__pagination">
                        <?php the_posts_pagination(); ?>
                    </div>

                <?php else : ?>

                    <p class="p-archive__empty"><?php echo esc_html('記事が見つかりませんでした。'); ?></p>

                <?php endif; ?>
            </div>

            <div class="p-page__footer">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="p-page__back-link">
                    <span class="material-symbols-outlined">arrow_back</span>
                    TOPページへ戻る
                </a>
            </div>

        </div>
    </article>
</main>

<?php get_footer(); ?>
