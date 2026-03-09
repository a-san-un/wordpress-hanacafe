<?php

/**
 * Home: Menu Section
 */
?>
<section class="l-section p-menu" id="menu">
    <div class="l-container">
        <div class="p-menu__inner">
            <div class="p-menu__header">
                <div class="p-menu__heading">
                    <span class="p-menu__subtitle">Menu</span>
                    <h2 class="p-menu__title">身体が喜ぶ、旬の味覚</h2>
                </div>
                <a href="<?php echo esc_url(get_post_type_archive_link('menu')); ?>" class="p-menu__link">
                    VIEW ALL MENU
                    <span class="material-symbols-outlined">arrow_forward</span>
                </a>
            </div>

            <div class="p-menu__list">
                <?php
                $args_top = [
                    'post_type'      => 'menu',
                    'posts_per_page' => 3,
                    'meta_query'     => [['key' => 'is_top', 'value' => '1', 'compare' => '=']]
                ];
                $query_top = new WP_Query($args_top);
                $top_posts = $query_top->posts;

                $count_needed = 3 - count($top_posts);
                if ($count_needed > 0) {
                    $exclude_ids = wp_list_pluck($top_posts, 'ID');
                    $args_fill = [
                        'post_type'      => 'menu',
                        'posts_per_page' => $count_needed,
                        'post__not_in'   => $exclude_ids,
                        'orderby'        => 'date',
                        'order'          => 'DESC'
                    ];
                    $query_fill = new WP_Query($args_fill);
                    $top_posts = array_merge($top_posts, $query_fill->posts);
                }

                if ($top_posts) :
                    foreach ($top_posts as $post) : setup_postdata($post);
                        get_template_part('template-parts/loop', 'menu');
                    endforeach;
                    wp_reset_postdata();
                else :
                ?>
                    <p>現在メニューを準備中です。</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>