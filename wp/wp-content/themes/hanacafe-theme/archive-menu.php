<?php

/**
 * Template Name: Menu Archive (メニュー一覧)
 * [制作意図]
 * 1. 順序の動的制御: スラッグ指定(food, drink, dessert)により、環境を問わず意図した順番で表示。
 * 2. 階層構造: get_term_link() によるタクソノミーページへの導線を確保。
 * 3. 黄金律(ソート): おすすめ(is_recommended)を最優先しつつ、未設定の商品も消さずに表示。
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
                    'orderby'    => 'include', // スラッグ指定順(Food -> Drink -> Dessert)を守る
                ]);

                if (!empty($terms) && !is_wp_error($terms)) :
                    foreach ($terms as $term) :
                        $term_id = $term->term_id;
                ?>
                        <section class="p-menu-archive l-section">
                            <header class="p-menu__header">
                                <div class="p-menu__heading c-heading">
                                    <span class="c-heading__sub"><?php echo esc_html(strtoupper($term->slug)); ?></span>
                                    <h2 class="c-heading__main"><?php echo esc_html($term->name); ?></h2>
                                </div>
                            </header>

                            <div class="p-menu__list">
                                <?php
                                $args = [
                                    'post_type'      => 'menu',
                                    'posts_per_page' => -1,
                                    'tax_query'      => [
                                        [
                                            'taxonomy' => 'menu_category',
                                            'field'    => 'term_id',
                                            'terms'    => $term_id,
                                        ],
                                    ],
                                    // [設計意図] おすすめフラグ(is_recommended)の有無でソート。
                                    // トップレベルの meta_key を排除し、meta_query の名前付き句(recommend_clause)を
                                    // 用いることで、一度も設定されていない投稿（NULL）の消失を防ぐ。
                                    'meta_query' => [
                                        'relation' => 'OR',
                                        'recommend_clause' => [
                                            'key'     => 'is_recommended',
                                            'compare' => 'EXISTS',
                                        ],
                                        [
                                            'key'     => 'is_recommended',
                                            'compare' => 'NOT EXISTS',
                                        ],
                                    ],
                                    'orderby' => [
                                        'recommend_clause' => 'DESC', // 1(おすすめ)を先に表示
                                        'date'             => 'DESC', // 次いで新しい順
                                    ],
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