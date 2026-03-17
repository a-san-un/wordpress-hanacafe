<?php

/**
 * Template Name: Menu Single Template (個別メニューページ)
 * [制作意図]
 * 1. 非破壊: ヘッダー部分（VIEW ALL リンク等）は 3/11 版を完全継承。
 * 2. 拡張: スペック表、前後ナビ、関連メニューを ACF 仕様に合わせて実装。
 * 3. 規約: コメントは PHP タグ内で行い、画面への露出を皆無にする。
 */
get_header(); ?>

<main class="l-main">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class('p-single-menu'); ?>>
                <div class="l-container">

                    <?php
                    $terms = get_the_terms(get_the_ID(), 'menu_category');
                    $category_display = ($terms && !is_wp_error($terms)) ? $terms[0]->name : 'Menu';
                    ?>

                    <?php // セクションヘッダー: 3/11 17時台の構造を完全同期 
                    ?>
                    <header class="p-single-menu__header p-menu__header">
                        <div class="p-menu__heading c-heading">
                            <span class="c-heading__sub"><?php echo esc_html($category_display); ?></span>
                            <h1 class="c-heading__main"><?php // [fix 1-4]
                                                        echo esc_html(get_the_title()); ?></h1>
                        </div>
                        <a href="<?php echo esc_url(get_post_type_archive_link('menu')); ?>" class="p-menu__view-all">
                            VIEW ALL MENU
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </a>
                    </header>

                    <div class="p-single-menu__inner">
                        <div class="p-single-menu__visual">
                            <div class="p-single-menu__img-wrapper">
                                <?php if (get_field('is_recommended')) : ?>
                                    <span class="c-badge-recommend">RECOMMEND</span>
                                <?php endif; ?>

                                <?php
                                $sub_img_array = get_field('menu_sub_img');
                                if ($sub_img_array && is_array($sub_img_array)) :
                                    $img_url = isset($sub_img_array['sizes']['large']) ? $sub_img_array['sizes']['large'] : $sub_img_array['url'];
                                    $img_alt = !empty($sub_img_array['alt']) ? $sub_img_array['alt'] : get_the_title();
                                    echo '<img src="' . esc_url($img_url) . '" class="p-single-menu__img" alt="' . esc_attr($img_alt) . '">';
                                elseif (has_post_thumbnail()) :
                                    the_post_thumbnail('large', array('class' => 'p-single-menu__img'));
                                else :
                                    // [fix 1-5]
                                    $alt = esc_attr(get_the_title() . ' の代替画像');
                                    echo '<img src="' . esc_url(get_hanacafe_default_image_url('menu-info')) . '" alt="' . $alt . '" class="p-single-menu__img">';
                                endif;
                                ?>
                            </div>
                        </div>

                        <div class="p-single-menu__content">
                            <?php if ($sub_name = get_field('sub_name')) : ?>
                                <p class="p-single-menu__sub"><?php echo esc_html($sub_name); ?></p>
                            <?php endif; ?>

                            <div class="p-single-menu__body">
                                <div class="p-single-menu__desc">
                                    <?php the_content(); ?>
                                </div>

                                <?php if ($price = get_field('price')) : ?>
                                    <p class="p-single-menu__price">
                                        <span class="p-single-menu__price-unit">¥</span>
                                        <?php echo esc_html(number_format((int)$price)); ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <dl class="p-single-menu__specs">
                                <?php if ($calorie = get_field('calorie')) : ?>
                                    <div class="p-single-menu__spec-item">
                                        <dt>エネルギー</dt>
                                        <dd><?php echo esc_html($calorie); ?> kcal</dd>
                                    </div>
                                <?php endif; ?>

                                <?php if ($allergies = get_field('allergies')) : ?>
                                    <div class="p-single-menu__spec-item">
                                        <dt>アレルギー</dt>
                                        <dd><?php echo esc_html(implode('、', (array)$allergies)); ?></dd>
                                    </div>
                                <?php endif; ?>
                            </dl>
                        </div>
                    </div>

                </div>
            </article>

    <?php endwhile;
    endif; ?>

    <?php
    $term_id = ($terms && !is_wp_error($terms)) ? $terms[0]->term_id : 0;
    $related_query = new WP_Query([
        'post_type' => 'menu',
        'posts_per_page' => 3,
        'post__not_in' => [get_the_ID()],
        'orderby' => 'date',
        'order' => 'DESC',
        'tax_query' => [[
            'taxonomy' => 'menu_category',
            'field' => 'term_id',
            'terms' => $term_id,
        ]],
    ]);

    if ($related_query->have_posts()) : ?>
        <section class="l-section p-menu-related">
            <div class="l-container">
                <div class="p-menu-related__header">
                    <h2 class="p-menu-related__title">RECOMMEND</h2>
                    <p class="p-menu-related__subtitle">こちらのメニューもいかがですか？</p>
                </div>
                <div class="p-menu__list">
                    <?php
                    while ($related_query->have_posts()) : $related_query->the_post();
                        get_template_part('template-parts/loop', 'menu');
                    endwhile;
                    ?>
                </div>
            </div>
        </section>
    <?php
        wp_reset_postdata();
    endif;
    ?>
</main>

<?php get_footer(); ?>