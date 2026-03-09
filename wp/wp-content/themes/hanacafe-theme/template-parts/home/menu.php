<?php

/**
 * Home: Menu Section
 * * 2026-03-09: VIEW ALL MENU のリンクをカスタム投稿アーカイブへ動的化
 */
?>
<section class="l-section p-menu" id="menu">
    <div class="l-container">
        <div class="p-menu__inner">
            <div class="p-menu__header">
                <div class="p-menu__heading">
                    <span class="p-menu__subtitle">Menu</span>
                    <h2 class="p-menu__title">お料理</h2>
                </div>
                <a href="<?php echo esc_url(get_post_type_archive_link('menu')); ?>" class="p-menu__link">
                    VIEW ALL MENU
                    <span class="material-symbols-outlined">arrow_forward</span>
                </a>
            </div>

            <div class="p-menu__list">
                <?php
                // TOPページには「おすすめ（is_recommended）」がついたメニューを優先的に3件表示する例
                $args = [
                    'post_type' => 'menu',
                    'posts_per_page' => 3,
                    'meta_key' => 'is_recommended',
                    'orderby' => 'meta_value_num',
                    'order' => 'DESC',
                ];
                $menu_query = new WP_Query($args);
                if ($menu_query->have_posts()) :
                    while ($menu_query->have_posts()) : $menu_query->the_post();
                        $price = get_field('price');
                        $sub_name = get_field('sub_name');
                ?>
                        <article class="p-menu__item">
                            <div class="p-menu__img-wrapper">
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
                                <p class="p-menu__price">
                                    <?php echo $price ? '¥' . number_format($price) : 'ASK'; ?>
                                </p>
                            </div>
                        </article>
                    <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    ?>
                    <p>現在メニューを準備中です。</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>