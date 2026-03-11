<?php

/**
 * Template Name: Menu Single Template (個別メニューページ)
 *
 * 制作意図:
 * TOPページ「Menuセクション」のコンポーネントを継承し、サイト全体のブランド体験を統一。
 * 固定文字を排除し、タクソノミー（menu_category）から「Food/Drink/Dessert」を
 * 動的に取得することで、運用負荷を軽減しつつ情報の正確性を担保する。
 *
 * 実装ルール:
 * - 非破壊の原則: TOPページの c-heading / p-menu__header 構造を完全同期。
 * - 表示保証: get_the_terms によるフォールバック（未設定時の 'Menu' 表示）を実装。
 * - 透過黄金律: 1.0 (識別情報: カテゴリー/料理名) / 0.7 (補足: 説明文) を徹底。
 */

get_header(); // header.php を読み込み（<html>〜<body>冒頭までを出力）
?>

<main class="l-main">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <!-- 投稿ID・投稿タイプに応じたクラスを自動付与（post_class） -->
            <article id="post-<?php the_ID(); ?>" <?php post_class('p-single-menu'); ?>>
                <div class="l-container">

                    <?php
                    /**
                     * カテゴリー情報の取得
                     * get_the_terms で menu_category の配列を取得し、
                     * 最初の1件の 'name' プロパティを表示用にセット。
                     * タクソノミー未設定・エラー時は 'Menu' をフォールバックとして使用（表示保証）
                     */
                    $terms = get_the_terms(get_the_ID(), 'menu_category');
                    $category_display = ($terms && !is_wp_error($terms)) ? $terms[0]->name : 'Menu';
                    ?>

                    <!-- セクションヘッダー: TOPページの p-menu__header 構造と完全同期（非破壊の原則） -->
                    <header class="p-single-menu__header p-menu__header">
                        <div class="p-menu__heading c-heading">
                            <!-- カテゴリー名を動的出力（esc_html でXSS対策） -->
                            <span class="c-heading__sub"><?php echo esc_html($category_display); ?></span>
                            <h1 class="c-heading__main"><?php the_title(); /* 投稿タイトルを出力 */ ?></h1>
                        </div>
                        <!-- アーカイブページへの戻りリンク（esc_url でXSS対策） -->
                        <a href="<?php echo esc_url(get_post_type_archive_link('menu')); ?>" class="p-menu__view-all">
                            VIEW ALL MENU
                            <span class="material-symbols-outlined">arrow_forward</span><!-- 矢印アイコン（装飾） -->
                        </a>
                    </header>

                    <div class="p-single-menu__inner">

                        <!-- 画像エリア: サブ画像 → アイキャッチ → プレースホルダーの優先順でフォールバック -->
                        <div class="p-single-menu__img-wrapper">
                            <?php
                            $sub_img_array = get_field('menu_sub_img'); // ACF: 画像フィールド（Image Array形式）を取得
                            if ($sub_img_array && is_array($sub_img_array)) :
                                // large サイズがあれば優先、なければフルサイズを使用（帯域最適化）
                                $img_url = isset($sub_img_array['sizes']['large']) ? $sub_img_array['sizes']['large'] : $sub_img_array['url'];
                                $img_alt = !empty($sub_img_array['alt']) ? $sub_img_array['alt'] : get_the_title(); // alt 未設定時は投稿タイトルで代替（A11Y）
                                echo '<img src="' . esc_url($img_url) . '" class="p-single-menu__img" alt="' . esc_attr($img_alt) . '">';
                            elseif (has_post_thumbnail()) :
                                // サブ画像未設定の場合: アイキャッチ画像を表示（表示保証）
                                the_post_thumbnail('large', array('class' => 'p-single-menu__img'));
                            else :
                                // 画像が全て未設定の場合: 背景色のみのプレースホルダーを表示（レイアウト崩れ防止）
                                echo '<div class="p-single-menu__no-img"></div>';
                            endif;
                            ?>
                        </div>

                        <!-- テキストコンテンツエリア: サブ名 → 本文 → 価格の順で出力 -->
                        <div class="p-single-menu__content">

                            <?php if ($sub_name = get_field('sub_name')) : ?>
                                <!-- ACF: sub_name が設定されている場合のみサブタイトルを出力 -->
                                <p class="p-single-menu__sub"><?php echo esc_html($sub_name); /* esc_html でXSS対策 */ ?></p>
                            <?php endif; ?>

                            <div class="p-single-menu__body">
                                <div class="p-single-menu__desc">
                                    <?php the_content(); /* 投稿本文をそのまま出力（ブロックエディター対応） */ ?>
                                </div>

                                <?php if ($price = get_field('price')) : ?>
                                    <!-- ACF: price が設定されている場合のみ価格を出力 -->
                                    <p class="p-single-menu__price">
                                        <span class="p-single-menu__price-unit">¥</span>
                                        <?php echo esc_html(number_format($price)); /* number_format で3桁区切り整形 */ ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>

                </div>
            </article>

    <?php endwhile;
    endif; ?>
</main>

<?php get_footer(); // footer.php を読み込み（</body></html>までを出力） 
?>