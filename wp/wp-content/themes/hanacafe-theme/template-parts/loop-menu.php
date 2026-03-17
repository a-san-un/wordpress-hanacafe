<?php

/**
 * Template Part: Menu Card (loop-menu.php)
 * [制作意図]
 * 1. 規約遵守: 画面へのコメント露出を PHP タグで防止（規約02）。
 * 2. クリンネス: NLMの指示に従い、インラインスタイルを排除。
 * 3. 黄金律: サブタイトルは 1.0、価格は分離構造を継承。
 */
?>
<article <?php post_class('p-menu__item'); ?>>
    <a href="<?php the_permalink(); ?>" class="p-menu__link">
        <div class="p-menu__img-wrapper">
            <?php // [実装] おすすめバッジの動的表示（表示保証：SCSS側の relative に依存） 
            ?>
            <?php if (get_field('is_recommended')) : ?>
                <span class="c-badge-recommend">RECOMMEND</span>
            <?php endif; ?>

            			<?php if (has_post_thumbnail()) : ?>
            				<?php the_post_thumbnail('large', ['class' => 'p-menu__img']); ?>
            			<?php else : ?>
            				<img src="<?php echo get_hanacafe_default_image_url('menu-info'); ?>" alt="<?php the_title_attribute(); ?> の代替画像" class="p-menu__img">
            			<?php endif; ?>        </div>

        <div class="p-menu__info">
            <div class="p-menu__titles">
                <h3 class="p-menu__name"><?php the_title(); ?></h3>
                <?php if ($sub_name = get_field('sub_name')) : ?>
                    <p class="p-menu__sub"><?php echo esc_html($sub_name); ?></p>
                <?php endif; ?>
            </div>

            <div class="p-menu__desc">
                <?php
                $content = get_the_content();
                echo wp_trim_words(strip_shortcodes($content), 40, '...');
                ?>
            </div>

            <p class="p-menu__price">
                <span class="p-menu__price-unit">¥</span>
                <?php
                $price = get_field('price');
                echo $price ? number_format((int)$price) : '---';
                ?>
            </p>
        </div>
    </a>
</article>