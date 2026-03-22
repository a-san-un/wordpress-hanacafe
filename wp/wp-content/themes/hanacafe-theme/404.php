<?php

/**
 * Template: 404 Not Found Page
 * [設計意図]
 * ページが見つからない場合に表示される標準エラーページ。
 * page-concept.php の構造を踏襲し、統一されたUIを提供。
 */
get_header(); ?>

<main class="l-main">
    <article class="p-page">
        <div class="l-container">

            <header class="p-page__header">
                <h1 class="p-page__title">404 - ページが見つかりません</h1>
            </header>

            <div class="p-page__content">
                <p><?php echo esc_html('お探しのページは移動または削除された可能性があります。'); ?></p>
            </div>ï

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