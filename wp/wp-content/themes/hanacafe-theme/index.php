<?php

/**
 * The main template file.
 *
 * @package hanacafe-theme
 */

get_header(); ?>

<main id="primary" class="site-main">
    <section style="padding-top: 160px; padding-bottom: 160px;">
        <div class="container">
            <?php
            if (have_posts()) {
                while (have_posts()) {
                    the_post();
                    the_content();
                }
            } else {
                echo '<p style="text-align: center;">記事が見つかりませんでした。</p>';
            }
            ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>