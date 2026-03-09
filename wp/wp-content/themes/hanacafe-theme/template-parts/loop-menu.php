<?php

/**
 * Menu Card Component
 * [設計意図]
 * 1. 順番厳守: 写真 -> タイトル -> サブタイトル -> 本文 -> 値段
 * 2. .p-menu__img-wrapper 内でバッジと画像を分離（画像のみ拡大）
 * 3. 価格の日本円整形 (number_format)
 */
?>

<article class="p-menu__item">
    <a href="<?php the_permalink(); ?>" class="p-menu__link">
        <div class="p-menu__img-wrapper">
            <?php if (get_field('is_recommended')): ?>
                <span class="c-badge-recommend">おすすめ</span>
            <?php endif; ?>

            <?php if (has_post_thumbnail()): ?>
                <?php the_post_thumbnail('large', ['class' => 'p-menu__img']); ?>
            <?php else: ?>
                <img src="<?php echo esc_url(get_theme_file_uri('/assets/images/common/no-image.jpg')); ?>" alt="" class="p-menu__img">
            <?php endif; ?>
        </div>

        <div class="p-menu__info">
            <h3 class="p-menu__name"><?php the_title(); ?></h3>

            <?php if ($sub_name = get_field('sub_name')): ?>
                <span class="p-menu__sub"><?php echo esc_html($sub_name); ?></span>
            <?php endif; ?>

            <div class="p-menu__desc">
                <?php
                $content = get_the_content();
                echo wp_trim_words(strip_shortcodes($content), 40, '...');
                ?>
            </div>

            <?php if ($price = get_field('price')): ?>
                <p class="p-menu__price">¥<?php echo number_format($price); ?></p>
            <?php endif; ?>
        </div>
    </a>
</article>