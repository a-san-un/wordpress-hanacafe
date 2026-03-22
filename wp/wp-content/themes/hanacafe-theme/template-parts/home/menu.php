<?php
/**
 * Project: HanaCAFE nappa69 - Home Menu Section
 * [制作意図]
 * トップページにおける主要3カテゴリ（Food/Drink/Dessert）のダイジェスト表示。
 * 運用者がACF等で選択した特定の投稿を、Gridレイアウトで美しく整列させる。
 * [実装ルール]
 * 1. 表示保証: データが空、または取得失敗時も「準備中」カードを表示し、レイアウト崩れを防ぐ。
 * 2. 非破壊の原則: 既存の get_template_part 構造およびクラス命名を維持する。
 * 3. セキュリティ: 出力時は esc_html / esc_url を徹底し、XSSを防止する。
 */
?>

<?php
/* * メニュースロットの定義
 * 各カテゴリの投稿オブジェクトを配列化し、ループ処理を簡素化。
 * get_hanacafe_top_menu_post は管理画面で選択された投稿を取得する独自関数。
 */
[$food_slug, $drink_slug, $dessert_slug] = get_hanacafe_menu_categories();
$menu_slots = [
  "food" => get_hanacafe_top_menu_post("top_menu_food", $food_slug),
  "drink" => get_hanacafe_top_menu_post("top_menu_drink", $drink_slug),
  "dessert" => get_hanacafe_top_menu_post("top_menu_dessert", $dessert_slug),
];
?>

<section class="l-section p-menu" id="menu">
    <div class="l-container">
        <div class="p-menu__header">
            <div class="p-menu__heading c-heading">
                <span class="c-heading__sub">Menu</span>
                <h2 class="c-heading__main">身体が喜ぶ、旬の味覚</h2>
            </div>
            <a href="<?php echo esc_url(get_post_type_archive_link("menu")); ?>" class="p-menu__view-all">
                VIEW ALL MENU
                <span class="material-symbols-outlined">arrow_forward</span>
            </a>
        </div>

        <div class="p-menu__list">
            <?php foreach ($menu_slots as $type => $post_obj): ?>
                <?php if ($post_obj): ?>
                    <?php
                    /*
                     * グローバル変数 $post を一時的に上書きし、setup_postdata を実行。
                     * これにより loop-menu.php 内で get_the_title() 等の標準関数が利用可能になる。
                     */
                    $post = $post_obj;
                    setup_postdata($post);
                    get_template_part("template-parts/loop", "menu");
                    ?>
                <?php else: ?>
                    <article class="p-menu__item is-preparing">
                        <div class="p-menu__img-wrapper">
                            <img src="<?php echo get_hanacafe_default_image_url(
                              "menu-info",
                            ); ?>" alt="準備中" class="p-menu__img">
                        </div>
                        <div class="p-menu__info">
                            <h3 class="p-menu__name"><?php echo esc_html(strtoupper($type)); ?> 準備中</h3>
                            <p class="p-menu__desc">現在メニューを更新しております。公開までお待ちください。</p>
                        </div>
                    </article>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php /* setup_postdata で変更されたグローバルな $post 状態をリセットし、後続のクエリへの影響を防ぐ */
            wp_reset_postdata(); ?>
        </div>
    </div>
</section>