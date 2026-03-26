<?php

/**
 * Template: News Archive (ニュース一覧)
 * [設計意図]
 * 1. template_include フィルター経由で is_home() 時に適用される（functions.php 参照）。
 * 2. loop-menu.php に準拠したカードグリッドレイアウト（BEM クラス）。
 * 3. 全エスケープ処理を厳格に適用（esc_html / esc_url / esc_attr）。
 */
get_header(); ?>

<main class="l-main">
    <section class="p-page">
        <div class="l-container">

            <div class="p-page__header">
                <?php get_template_part('template-parts/breadcrumb'); ?>
                <p class="p-page__subtitle">NEWS</p>
                <h1 class="p-page__title">大切なお知らせ</h1>
            </div>

            <div class="p-page__content">
                <?php if (have_posts()): ?>

                    <div class="p-news__list">
                        <?php while (have_posts()):
                            the_post(); ?>
                            <article <?php post_class("c-card c-card--news"); ?>>
                                <a href="<?php the_permalink(); ?>" class="c-card__link">

                                    <div class="c-card__media">
                                        <?php if (has_post_thumbnail()): ?>
                                            <?php the_post_thumbnail("medium", ["class" => "c-card__img"]); ?>
                                        <?php else: ?>
                                            <img
                                                src="<?php echo get_hanacafe_default_image_url("news-info"); ?>"
                                                alt="<?php echo esc_attr(get_the_title() . " の代替画像"); ?>"
                                                class="c-card__img">
                                        <?php endif; ?>
                                    </div>

                                    <div class="c-card__body">
                                        <time class="c-card__meta" datetime="<?php echo esc_attr(
                                                                                    get_the_date("c"),
                                                                                ); ?>">
                                            <?php echo esc_html(get_the_date("Y.m.d")); ?>
                                        </time>
                                        <h2 class="c-card__title">
                                            <?php echo esc_html(get_the_title()); ?>
                                        </h2>
                                        <div class="c-card__text">
                                            <?php echo wp_kses_post(get_the_excerpt()); ?>
                                        </div>
                                    </div>

                                </a>
                            </article>
                        <?php
                        endwhile; ?>
                    </div>

                    <div class="p-archive__pagination">
                        <?php the_posts_pagination(); ?>
                    </div>

                <?php else: ?>

                    <p class="p-archive__empty"><?php echo esc_html("現在、新しいお知らせはありません。"); ?></p>

                <?php endif; ?>
            </div>

            <div class="p-page__footer">
                <a href="<?php echo esc_url(home_url("/")); ?>" class="p-page__back-link">
                    <span class="material-symbols-outlined">arrow_back</span>
                    TOPページへ戻る
                </a>
            </div>

        </div>
    </section>
</main>

<?php get_footer(); ?>