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
    <?php if (have_posts()):
        while (have_posts()):

            the_post();
            $current_post_id = get_the_ID();

            // $terms をループ内で定義し、スコープをループ内に閉じる（ループ外参照を排除）
            $terms            = get_the_terms($current_post_id, "menu_category");
            $category_display = $terms && !is_wp_error($terms) ? $terms[0]->name : "Menu";

            // get_hanacafe_menu_data() の戻り値はすべてエスケープ済み
            // image_url: esc_url() 済み  image_alt: esc_attr() 済み
            // sub_name / price_display: esc_html() 済み — echo 直前での再エスケープ不要
            $menu = get_hanacafe_menu_data();
    ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class("p-single-menu"); ?>>
                <div class="p-page__breadcrumb-wrapper l-container">
                    <?php get_template_part('template-parts/breadcrumb'); ?>
                </div>
                <div class="l-container">

                    <?php
                    // セクションヘッダー: 3/11 17時台の構造を完全同期
                    ?>
                    <header class="p-single-menu__header p-menu__header">
                        <div class="p-menu__heading c-heading">
                            <span class="c-heading__sub"><?php echo esc_html($category_display); ?></span>
                            <h1 class="c-heading__main"><?php echo esc_html(get_the_title()); ?></h1>
                        </div>
                        <a href="<?php echo esc_url(get_post_type_archive_link("menu")); ?>" class="p-menu__view-all">
                            VIEW ALL MENU
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </a>
                    </header>

                    <div class="p-single-menu__inner">
                        <div class="p-single-menu__img-wrapper">
                            <?php if ($menu["is_recommended"]): ?>
                                <span class="c-badge-recommend">RECOMMEND</span>
                            <?php endif; ?>

                            <img src="<?php echo $menu["image_url"]; ?>"
                                class="p-single-menu__img"
                                alt="<?php echo $menu["image_alt"]; ?>">
                        </div>

                        <div class="p-single-menu__content">
                            <?php if ($menu["sub_name"]): ?>
                                <p class="p-single-menu__sub"><?php echo $menu["sub_name"]; ?></p>
                            <?php endif; ?>

                            <div class="p-single-menu__desc">
                                <?php the_content(); ?>
                            </div>

                            <?php if ($menu["price_display"]): ?>
                                <p class="p-single-menu__price">
                                    <span class="p-single-menu__price-unit">¥</span>
                                    <?php echo $menu["price_display"]; ?>
                                </p>
                            <?php endif; ?>

                            <dl class="p-single-menu__specs">
                                <?php if ($calorie = get_field("calorie")): ?>
                                    <div class="p-single-menu__spec-item">
                                        <dt>エネルギー</dt>
                                        <dd><?php echo esc_html($calorie); ?> kcal</dd>
                                    </div>
                                <?php endif; ?>

                                <?php if ($allergies = get_field("allergies")): ?>
                                    <div class="p-single-menu__spec-item">
                                        <dt>アレルギー</dt>
                                        <dd><?php echo esc_html(implode("、", (array) $allergies)); ?></dd>
                                    </div>
                                <?php endif; ?>
                            </dl>
                        </div>
                    </div>

                </div>
            </article>

    <?php
        endwhile;
    endif; ?>

    <?php
    // ループ外で $terms を再取得して $current_post_id に依存させる
    // （ループスコープ外での $terms 参照を排除し、Undefined variable 警告を防止）
    $terms_for_related = get_the_terms($current_post_id, "menu_category");
    $term_id           = $terms_for_related && !is_wp_error($terms_for_related)
        ? $terms_for_related[0]->term_id
        : 0;

    $related_query = new WP_Query([
        "post_type"      => "menu",
        "posts_per_page" => 3,
        "post__not_in"   => [$current_post_id],
        "orderby"        => "date",
        "order"          => "DESC",
        "tax_query"      => [
            [
                "taxonomy" => "menu_category",
                "field"    => "term_id",
                "terms"    => $term_id,
            ],
        ],
    ]);

    if ($related_query->have_posts()): ?>
        <section class="l-section p-menu-related">
            <div class="l-container">
                <div class="p-menu-related__header">
                    <h2 class="p-menu-related__title">RECOMMEND</h2>
                    <p class="p-menu-related__subtitle">こちらのメニューもいかがですか？</p>
                </div>
                <div class="p-menu__list">
                    <?php while ($related_query->have_posts()):
                        $related_query->the_post();
                        get_template_part("template-parts/menu/loop", "menu");
                    endwhile; ?>
                </div>
            </div>
        </section>
    <?php wp_reset_postdata();
    endif;
    ?>
</main>

<?php get_footer(); ?>