<?php

/**
 * The main template file.
 *
 * @package hanacafe-theme
 */

get_header(); ?>

<main class="l-main">
    <section class="l-section">
        <div class="l-container">
            <?php if (have_posts()) {
              while (have_posts()) {
                the_post();
                the_content();
              }
            } else {
              // style属性を消し、必要なら共通のユーティリティクラス（u-text-center等）を当てる
              echo '<p class="u-text-center">記事が見つかりませんでした。</p>';
            } ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>
