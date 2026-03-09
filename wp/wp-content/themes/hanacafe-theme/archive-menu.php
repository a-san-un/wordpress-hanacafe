<?php get_header(); ?>

<main class="l-main">
    <section class="p-page js-animate">
        <div class="l-container">
            <div class="p-page__header">
                <p class="p-page__subtitle">MENU</p>
                <h1 class="p-page__title">メニュー一覧</h1>
            </div>

            <div class="p-page__content">
                <?php
                $terms = get_terms([
                    'taxonomy' => 'menu_category',
                    'hide_empty' => true,
                ]);

                if (!empty($terms)) :
                    foreach ($terms as $term) :
                ?>
                        <section class="l-section p-menu-archive" id="menu-<?php echo esc_attr($term->slug); ?>">
                            <div class="p-menu__header">
                                <div class="p-menu__heading">
                                    <span class="p-menu__subtitle"><?php echo esc_html(strtoupper($term->slug)); ?></span>
                                    <h2 class="p-menu__title"><?php echo esc_html($term->name); ?></h2>
                                </div>
                            </div>

                            <div class="p-menu__list u-mt-40">
                                <?php
                                $args = [
                                    'post_type' => 'menu',
                                    'posts_per_page' => -1, // 全件表示
                                    'tax_query' => [
                                        [
                                            'taxonomy' => 'menu_category',
                                            'field'    => 'slug',
                                            'terms'    => $term->slug,
                                        ],
                                    ],
                                ];
                                $menu_query = new WP_Query($args);
                                if ($menu_query->have_posts()) :
                                    while ($menu_query->have_posts()) : $menu_query->the_post();
                                        $price = get_field('price');
                                        $sub_name = get_field('sub_name');
                                        $is_recommended = get_field('is_recommended');
                                ?>
                                        <article class="p-menu__item">
                                            <div class="p-menu__img-wrapper">
                                                <?php if ($is_recommended) : ?>
                                                    <span class="c-badge c-badge--recommend">RECOMMEND</span>
                                                <?php endif; ?>
                                                <?php if (has_post_thumbnail()) : ?>
                                                    <?php the_post_thumbnail('full', ['class' => 'p-menu__img']); ?>
                                                <?php else : ?>
                                                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/placeholder-menu.jpg" alt="" class="p-menu__img">
                                                <?php endif; ?>
                                            </div>
                                            <div class="p-menu__info">
                                                <h3 class="p-menu__name">
                                                    <?php the_title(); ?>
                                                    <?php if ($sub_name) : ?>
                                                        <span class="u-block u-fs-12 u-fw-400"><?php echo esc_html($sub_name); ?></span>
                                                    <?php endif; ?>
                                                </h3>
                                                <div class="p-menu__desc u-mt-8">
                                                    <?php the_content(); ?>
                                                </div>
                                                <p class="p-menu__price">
                                                    <?php echo $price ? '¥' . number_format($price) : 'ASK'; ?>
                                                </p>
                                            </div>
                                        </article>
                                <?php
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

<?php get_header(); // ※footerの誤記防止：通常はget_footer()ですがここではfooterを呼びます 
?>
<?php get_footer(); ?>