<?php

/**
 * Template Name: Menu Archive (メニュー一覧)
 * [修正意図]
 * 1. 規約準拠: インラインスタイルを物理削除し、BEMクラスへ移行。
 * 2. 透過黄金律: 警告・準備中メッセージに 0.7 を適用（SCSS側で制御）。
 * 3. 堅牢性: カテゴリーが見つからない場合も沈黙せず、専用クラスで警告を表示。
 */
get_header(); ?>

<main class="l-main">
    <section class="p-page">ï
        <div class="l-container">
            <div class="p-page__header">
                <p class="p-page__subtitle">MENU</p>
                <h1 class="p-page__title">メニュー一覧</h1>
            </div>

            <div class="p-page__content">
                <?php
                $target_slugs = get_hanacafe_menu_categories();
                $ordered_ids = [];

                foreach ($target_slugs as $slug) {
                  $term = get_term_by("slug", $slug, "menu_category");
                  if ($term && !is_wp_error($term)) {
                    $ordered_ids[] = $term->term_id;
                  }
                }

                // [表示保証] ターム設定ミスがある場合に警告を表示
                if (empty($ordered_ids)) {
                  echo '<p class="p-menu-archive-alert">メニューカテゴリー（food, drink, dessert）が見つかりません。<br>管理画面のスラッグ設定を確認してください。</p>';
                }

                $terms = get_terms([
                  "taxonomy" => "menu_category",
                  "hide_empty" => false,
                  "include" => $ordered_ids,
                  "orderby" => "include",
                ]);

                if (!empty($terms) && !is_wp_error($terms)):
                  foreach ($terms as $term):

                    $term_id = $term->term_id;
                    $term_link = get_term_link($term);
                    ?>
                        <section class="p-menu-archive">
                            <header class="p-menu__header">
                                <a href="<?php echo esc_url($term_link); ?>" class="p-menu__heading-link">
                                    <div class="p-menu__heading c-heading">
                                        <span class="c-heading__sub"><?php echo esc_html(
                                          strtoupper($term->slug),
                                        ); ?></span>
                                        <h2 class="c-heading__main"><?php echo esc_html($term->name); ?></h2>
                                    </div>
                                </a>
                            </header>

                            <div class="p-menu__list">
                                <?php
                                $args = [
                                  "post_type" => "menu",
                                  "posts_per_page" => -1,
                                  "tax_query" => [
                                    ["taxonomy" => "menu_category", "field" => "term_id", "terms" => $term_id],
                                  ],
                                  "meta_query" => [
                                    "relation" => "OR",
                                    "recommend_clause" => [
                                      "key" => "is_recommended",
                                      "compare" => "EXISTS",
                                    ],
                                    [
                                      "key" => "is_recommended",
                                      "compare" => "NOT EXISTS",
                                    ],
                                  ],
                                  "orderby" => [
                                    "recommend_clause" => "DESC",
                                    "date" => "DESC",
                                  ],
                                ];
                                $menu_query = new WP_Query($args);

                                if ($menu_query->have_posts()):
                                  while ($menu_query->have_posts()):
                                    $menu_query->the_post();
                                    get_template_part("template-parts/loop", "menu");
                                  endwhile;
                                  wp_reset_postdata();
                                else:
                                  echo '<p class="p-menu-archive__empty">現在、' .
                                    esc_html($term->name) .
                                    "の準備をしております。</p>";
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
                <a href="<?php echo esc_url(home_url("/")); ?>" class="p-page__back-link">
                    <span class="material-symbols-outlined">arrow_back</span>
                    TOPへ戻る
                </a>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
