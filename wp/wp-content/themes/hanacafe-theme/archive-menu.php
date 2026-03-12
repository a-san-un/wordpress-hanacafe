<?php

/**
 * Template Name: Menu Archive (メニュー一覧)
 * [制作意図]
 * 1. 順序の動的制御: スラッグ指定(food, drink, dessert)により、環境を問わず意図した順番で表示。
 * 2. 階層構造: get_term_link() によるタクソノミーページへの導線を確保。
 * 3. 表示保証: l-section を排除し、p-page__header との余白衝突（100px+）を解消。
 */
get_header(); ?>

<main class="l-main">
    <section class="p-page">
        <div class="l-container">
            <div class="p-page__header">
                <p class="p-page__subtitle">MENU</p>
                <h1 class="p-page__title">メニュー一覧</h1>
            </div>

            <div class="p-page__content">
                <?php
                // [方法B] スラッグから動的にIDを取得し、表示順を固定する
                $target_slugs = ['food', 'drink', 'dessert'];
                $ordered_ids = [];

                foreach ($target_slugs as $slug) {
                    $term = get_term_by('slug', $slug, 'menu_category');
                    if ($term && !is_wp_error($term)) {
                        $ordered_ids[] = $term->term_id;
                    }
                }

                $terms = get_terms([
                    'taxonomy'   => 'menu_category',
                    'hide_empty' => true,
                    'include'    => $ordered_ids,
                    'orderby'    => 'include', // 指定したスラッグの順番通りに並べる
                ]);

                if (!empty($terms) && !is_wp_error($terms)) :
                    foreach ($terms as $term) :
                ?>
                        <section class="p-menu-archive" id="menu-<?php echo esc_attr($term->slug); ?>">
                            <div class="p-menu__header">
                                <a href="<?php echo esc_url(get_term_link($term)); ?>" class="p-menu__heading-link">
                                    <div class="p-menu__heading">
                                        <span class="p-menu__subtitle"><?php echo esc_html(strtoupper($term->slug)); ?></span>
                                        <h2 class="p-menu__title"><?php echo esc_html($term->name); ?></h2>
                                    </div>
                                </a>
                            </div>

                            <div class="p-menu__list">
                                <?php
                                $args = [
                                    'post_type'      => 'menu',
                                    'posts_per_page' => -1,
                                    'tax_query'      => [[
                                        'taxonomy' => 'menu_category',
                                        'field'    => 'slug',
                                        'terms'    => $term->slug,
                                    ]],
                                ];
                                $menu_query = new WP_Query($args);

                                if ($menu_query->have_posts()) :
                                    while ($menu_query->have_posts()) : $menu_query->the_post();
                                        get_template_part('template-parts/loop', 'menu');
                                    endwhile;
                                    wp_reset_postdata();
                                endif;
                                ?>
                            </div>
                        </section>
                <?php
                    endforeach;
                endif;
                ?>
            </div>

            <div class="p-page__footer">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="p-page__back-link">
                    <span class="material-symbols-outlined">arrow_back</span>
                    TOPへ戻る
                </a>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>