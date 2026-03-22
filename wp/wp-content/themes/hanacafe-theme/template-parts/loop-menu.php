<?php

/**
 * Template Part: Menu Card (loop-menu.php)
 * [制作意図]
 * 1. 規約遵守: 画面へのコメント露出を PHP タグで防止（規約02）。
 * 2. クリンネス: NLMの指示に従い、インラインスタイルを排除。
 * 3. 黄金律: サブタイトルは 1.0、価格は分離構造を継承。
 */
?>
<?php $menu = get_hanacafe_menu_data(); ?>
<article <?php post_class('p-menu__item'); ?>>
    <a href="<?php the_permalink(); ?>" class="p-menu__link">
        <div class="p-menu__img-wrapper">
            <?php // [実装] おすすめバッジの動的表示（表示保証：SCSS側の relative に依存）
			?>
            <?php if ($menu['is_recommended']) : ?>
                <span class="c-badge-recommend">RECOMMEND</span>
            <?php endif; ?>

            <img src="<?php echo $menu['image_url']; ?>" alt="<?php echo $menu['image_alt']; ?>" class="p-menu__img">
        </div>

        <div class="p-menu__info">
            <div class="p-menu__titles">
                <h3 class="p-menu__name"><?php // [fix 1-4]
											echo esc_html(get_the_title()); ?></h3>
                <?php if ($menu['sub_name']) : ?>
                    <p class="p-menu__sub"><?php echo $menu['sub_name']; ?></p>
                <?php endif; ?>
            </div>

            <div class="p-menu__desc">
                <?php the_excerpt(); ?>
            </div>

            <?php if ($menu['price_display']) : ?>
                <p class="p-menu__price">
                    <span class="p-menu__price-unit">¥</span>
                    <?php echo $menu['price_display']; ?>
                </p>
            <?php endif; ?>
        </div>
    </a>
</article>