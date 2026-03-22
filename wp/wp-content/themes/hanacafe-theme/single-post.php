<?php

/**
 * Template: Single Post
 * [設計意図]
 * 単一の投稿を表示するテンプレート。
 * page-concept.php と同じ構造で統一感を保ちつつ、投稿日などの情報を追加。
 */
get_header(); ?>

<main class="l-main">
    <?php if (have_posts()):
      while (have_posts()):
        the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class("p-page"); ?>>
                <div class="l-container">

                    <header class="p-page__header">
                        <h1 class="p-page__title"><?php echo esc_html(get_the_title()); ?></h1>
                        <time class="p-page__date" datetime="<?php echo get_the_date("c"); ?>">
                            <?php echo esc_html(get_the_date("Y.m.d")); ?>
                        </time>
                    </header>

                    <div class="p-page__content">
                        <?php the_content(); ?>
                    </div>

                    <div class="p-page__footer">
                        <a href="<?php echo esc_url(home_url("/")); ?>" class="p-page__back-link">
                            <span class="material-symbols-outlined">arrow_back</span>
                            TOPページへ戻る
                        </a>
                    </div>

                </div>
            </article>

    <?php
      endwhile;
    endif; ?>
</main>

<?php get_footer(); ?>
