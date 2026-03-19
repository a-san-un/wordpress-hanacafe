<?php

/**
 * Hero Section Template
 */

// 1. デフォルト値の準備
$hero_img_url = get_template_directory_uri() . '/assets/images/hero.jpg';
$hero_title_jp = '木漏れ日と、手作りの温もり。';
$hero_alt = 'HanaCAFE nappa69 メインビジュアル';

// 2. データの取得 (WP_Query)
$args = [
    'post_type'      => 'main-visual',
    'posts_per_page' => 1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
];
$the_query = new WP_Query($args);

// 3. 投稿がある場合はデータを上書き
if ($the_query->have_posts()) {
    while ($the_query->have_posts()) {
        $the_query->the_post();
        if (has_post_thumbnail()) {
            $hero_img_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
        }
        // 投稿タイトルを日本語タイトルとして使用
        $hero_title_jp = get_the_title();

        // アクセシビリティ対応: alt属性の動的設定（タイトルがあれば上書き）
        if (get_the_title()) {
            $hero_alt = get_the_title();
        }
    }
    wp_reset_postdata();
}
?>

<section class="p-hero u-alignfull">
    <div class="p-hero__inner">
        <div class="p-hero__img">
            <img
                src="<?php echo esc_url($hero_img_url); ?>"
                alt="<?php echo esc_attr($hero_alt); ?>"
                fetchpriority="high"
                loading="eager">
        </div>

        <div class="p-hero__content">
            <div class="l-container">
                <div class="p-hero__title-box">
                    <h2 class="p-hero__title">
                        <span class="p-hero__title-en">Slow Time,</span>
                        <span class="p-hero__title-en">Slow Life.</span>
                        <span class="p-hero__title-jp"><?php echo esc_html($hero_title_jp); ?></span>
                    </h2>
                </div>
            </div>
        </div>
    </div>
</section>