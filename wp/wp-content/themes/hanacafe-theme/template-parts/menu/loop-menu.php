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
<article <?php post_class("c-card c-card--menu"); ?>>
    <a href="<?php the_permalink(); ?>" class="c-card__link">
        <div class="c-card__media">
            <?php if ($menu["is_recommended"]): ?>
                <div class="c-card__badge">
                    <span class="c-badge-recommend">RECOMMEND</span>
                </div>
            <?php endif; ?>

            <img src="<?php echo $menu["image_url"]; ?>" alt="<?php echo $menu["image_alt"]; ?>" class="c-card__img">
        </div>

        <div class="c-card__body">
            <h3 class="c-card__title"><?php echo esc_html(get_the_title()); ?></h3>
            <?php if ($menu["sub_name"]): ?>
                <p class="c-card__meta"><?php echo $menu["sub_name"]; ?></p>
            <?php endif; ?>

            <div class="c-card__text">
                <?php the_excerpt(); ?>
            </div>

            <?php if ($menu["price_display"]): ?>
                <p class="c-card__price">
                    <span class="c-card__price-unit">¥</span>
                    <?php echo $menu["price_display"]; ?>
                </p>
            <?php endif; ?>
        </div>
    </a>
</article>