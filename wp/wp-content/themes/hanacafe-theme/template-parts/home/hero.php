<?php

/**
 * Hero Section Template
 */
$args = [
    'post_type'      => 'main-visual',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
];
$the_query = new WP_Query($args);
?>

<section class="p-hero">
    <?php if ($the_query->have_posts()) : ?>
        <?php while ($the_query->have_posts()) : $the_query->the_post();
            $pic = get_field('pic');
            $image_url = !empty($pic) ? $pic['url'] : get_theme_file_uri('/assets/images/hero.jpg');
        ?>
            <div class="p-hero__item">
                <div class="p-hero__img-wrapper">
                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php the_title_attribute(); ?>" class="p-hero__img">
                </div>
                <div class="p-hero__overlay-multiply"></div>
                <div class="p-hero__overlay-gradient"></div>
                <div class="p-hero__content">
                    <h2 class="p-hero__title">日常に緑を、<br class="u-hidden-md">心に安らぎを。</h2>
                    <p class="p-hero__subtitle">体に優しい心が嬉しいお料理</p>
                    <div class="p-hero__line"></div>
                </div>
            </div>
        <?php endwhile;
        wp_reset_postdata(); ?>
    <?php else : ?>
        <div class="p-hero__item">
            <div class="p-hero__img-wrapper">
                <img src="<?php echo esc_url(get_theme_file_uri('/assets/images/hero.jpg')); ?>" alt="HanaCAFE nappa69" class="p-hero__img">
            </div>
            <div class="p-hero__overlay-multiply"></div>
            <div class="p-hero__overlay-gradient"></div>
            <div class="p-hero__content">
                <h2 class="p-hero__title">日常に緑を、<br class="u-hidden-md">心に安らぎを。</h2>
                <p class="p-hero__subtitle">体に優しい心が嬉しいお料理</p>
                <div class="p-hero__line"></div>
            </div>
        </div>
    <?php endif; ?>
</section>