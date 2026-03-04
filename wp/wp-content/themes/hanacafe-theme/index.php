<?php

/**
 * The main template file.
 *
 * @package hanacafe-theme
 */

get_header(); ?>

<main id="primary" class="site-main py-20">
    <div class="container mx-auto px-4">
        <?php
        if (have_posts()) {
            while (have_posts()) {
                the_post();
                the_content();
            }
        } else {
            echo '<p>記事が見つかりませんでした。</p>';
        }
        ?>
    </div>
</main>

<?php
get_footer();
