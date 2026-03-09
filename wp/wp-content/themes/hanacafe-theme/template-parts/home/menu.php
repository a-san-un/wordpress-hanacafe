<?php

/**
 * Home: Menu Section
 * [並び順] 左:FOOD / 中:DRINK / 右:DESSERT
 * [抽出条件] 各カテゴリーで 'is_top' にチェックが入っているものを優先表示
 */

// カテゴリースラッグの定義（管理画面のスラッグと一致させてください）
$menu_categories = [
    'food'    => 'food',
    'drink'   => 'drink',
    'dessert' => 'dessert'
];

$top_posts = [];

foreach ($menu_categories as $key => $slug) {
    $args = [
        'post_type'      => 'menu',
        'posts_per_page' => 1,
        'tax_query'      => [
            [
                'taxonomy' => 'menu_category',
                'field'    => 'slug',
                'terms'    => $slug,
            ],
        ],
        // 'is_top' が '1' のものを最優先で取得
        'meta_query'     => [
            [
                'key'   => 'is_top',
                'value' => '1',
                'compare' => '='
            ]
        ]
    ];

    $query = new WP_Query($args);

    // もし 'is_top' にチェックが入っているものがなければ、最新の1件をバックアップとして取得
    if (!$query->have_posts()) {
        unset($args['meta_query']); // meta_queryを解除して再検索
        $query = new WP_Query($args);
    }

    if ($query->have_posts()) {
        $top_posts[] = $query->posts[0];
    }
    wp_reset_postdata();
}
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
                if (!empty($top_posts)) :
                    foreach ($top_posts as $post) : setup_postdata($post);
                        // 写真 -> タイトル -> サブタイトル -> 本文 -> 値段 の順で出力
                        get_template_part('template-parts/loop', 'menu');
                    endforeach;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </div>
    </div>
</section>