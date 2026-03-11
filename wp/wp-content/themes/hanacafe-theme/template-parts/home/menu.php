<?php

/**
 * Home: Menu Section
 * [修正内容]
 * 構造をシンプルにし、l-container の直下に直接 header と list を配置。
 */

// -----------------------------------------------------------
// メニュースロット定義
// DRY原則: food / drink / dessert の3枠を連想配列で一元管理
// get_hanacafe_top_menu_post() でカスタムフィールドから投稿オブジェクトを取得
// 投稿が未設定の場合は null が返り、else 節で「準備中」表示にフォールバック
// -----------------------------------------------------------
$menu_slots = [
    'food'    => get_hanacafe_top_menu_post('top_menu_food',    'food'),    // フードメニュー枠
    'drink'   => get_hanacafe_top_menu_post('top_menu_drink',   'drink'),   // ドリンクメニュー枠
    'dessert' => get_hanacafe_top_menu_post('top_menu_dessert', 'dessert'), // デザートメニュー枠
];
?>

<section class="l-section p-menu" id="menu"><!-- id="menu": ヘッダーナビのアンカーリンク（/#menu）の対象 -->
    <div class="l-container">

        <!-- セクションヘッダー: 見出し + 「VIEW ALL MENU」リンク -->
        <div class="p-menu__header">
            <div class="p-menu__heading c-heading">
                <span class="c-heading__sub">Menu</span> <!-- 英語サブ見出し -->
                <h2 class="c-heading__main">身体が喜ぶ、旬の味覚</h2><!-- メイン見出し -->
            </div>
            <!-- esc_url でXSS対策。get_post_type_archive_link() でカスタム投稿タイプのアーカイブURLを動的取得 -->
            <a href="<?php echo esc_url(get_post_type_archive_link('menu')); ?>" class="p-menu__view-all">
                VIEW ALL MENU
                <span class="material-symbols-outlined">arrow_forward</span><!-- 矢印アイコン（装飾） -->
            </a>
        </div>

        <!-- メニューカードリスト: $menu_slots の3枠をループ出力 -->
        <div class="p-menu__list">
            <?php foreach ($menu_slots as $type => $post_obj) : ?>

                <?php if ($post_obj) : ?>
                    <?php
                    // 投稿が存在する場合: WordPress のグローバル $post を上書きしてループを擬似的に再現
                    $post = $post_obj;
                    setup_postdata($post); // get_the_title() 等のテンプレートタグを使えるようにする
                    get_template_part('template-parts/loop', 'menu'); // loop-menu.php を読み込んでカードを出力
                    ?>

                <?php else : ?>
                    <!-- 投稿が未設定の場合: プレースホルダーカードを表示（COMING SOON オーバーレイ付き） -->
                    <article class="p-menu__item is-preparing">
                        <div class="p-menu__img-wrapper">
                            <!-- COMING SOON オーバーレイ: _p-menu.scss の __preparing-overlay と連動 -->
                            <div class="p-menu__preparing-overlay">COMING SOON</div>
                            <!-- placehold.co によるプレースホルダー画像（実装前の視覚確認用） -->
                            <img src="https://placehold.co/600x750/E5E5E5/A8A29E?text=Photo+Preparing" alt="準備中" class="p-menu__img">
                        </div>
                        <div class="p-menu__info">
                            <!-- strtoupper() でスロットキー（food等）を大文字化して表示 -->
                            <h3 class="p-menu__name"><?php echo esc_html(strtoupper($type)); ?> 準備中</h3>
                            <p class="p-menu__desc">ただいま新しいメニューを準備しております。公開まで今しばらくお待ちください。</p>
                        </div>
                    </article>
                <?php endif; ?>

            <?php endforeach;
            // setup_postdata() で上書きしたグローバル $post を元の状態に戻す（後続処理への影響を防ぐ）
            wp_reset_postdata(); ?>
        </div>

    </div>
</section>