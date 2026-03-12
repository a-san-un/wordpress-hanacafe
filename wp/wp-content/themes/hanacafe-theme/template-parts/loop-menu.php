<?php

/**
 * Menu Card Component
 * [設計意図]
 * 1. 順番厳守: 写真 -> タイトル -> サブタイトル -> 本文 -> 値段 の視覚構造を固定。
 * 2. 画像表示保証: has_post_thumbnail() による条件分岐と、no-image.jpg へのフォールバック。
 * 3. ACF連携: おすすめバッジ(is_recommended)およびサブタイトル(sub_name)の動的出力。
 */
?>

<article class="p-menu__item">
    <a href="<?php the_permalink(); /* 投稿の個別ページURLを出力 */ ?>" class="p-menu__link">

        <!-- 画像エリア: バッジ（絶対配置）と画像を分離して管理 -->
        <div class="p-menu__img-wrapper">

            <?php if (get_field('is_recommended')): ?>
                <!-- ACF: is_recommended が true の場合のみおすすめバッジを表示 -->
                <span class="c-badge-recommend">おすすめ</span>
            <?php endif; ?>

            <?php if (has_post_thumbnail()): ?>
                <!-- アイキャッチ画像が設定されている場合: large サイズで出力 -->
                <?php the_post_thumbnail('large', ['class' => 'p-menu__img']); ?>
            <?php else: ?>
                <!-- アイキャッチ未設定の場合: テーマ内の no-image にフォールバック（表示保証） -->
                <img src="<?php echo esc_url(get_theme_file_uri('/assets/images/common/no-image.jpg')); ?>" alt="" class="p-menu__img">
            <?php endif; ?>

        </div>

        <!-- テキスト情報エリア: 順番厳守（タイトル → サブ → 本文 → 価格） -->
        <div class="p-menu__info">

            <h3 class="p-menu__name"><?php the_title(); /* 投稿タイトルを出力 */ ?></h3>

            <?php if ($sub_name = get_field('sub_name')): ?>
                <!-- ACF: sub_name が設定されている場合のみサブタイトルを出力 -->
                <span class="p-menu__sub"><?php echo esc_html($sub_name); /* esc_html でXSS対策 */ ?></span>
            <?php endif; ?>

            <div class="p-menu__desc">
                <?php
                $content = get_the_content();
                // ショートコードを除去してから40語に切り詰め、末尾に「...」を付与
                echo wp_trim_words(strip_shortcodes($content), 40, '...');
                ?>
            </div>

            <p class="p-menu__price">
                <span class="p-menu__price-unit">¥</span>
                <?php
                $price = get_field('price'); // ACF: 価格フィールドを取得
                echo $price ? number_format((int)$price) : '---'; // int キャストで数値を保証し、3桁区切り整形。未設定は「---」を表示
                ?>
            </p>

        </div>
    </a>
</article>