<?php

/**
 * Home: Menu Section (Refactored v2.0)
 */

$menu_slots = [
    'food'    => get_hanacafe_top_menu_post('top_menu_food', 'food'),
    'drink'   => get_hanacafe_top_menu_post('top_menu_drink', 'drink'),
    'dessert' => get_hanacafe_top_menu_post('top_menu_dessert', 'dessert'),
];
?>

<section class="l-section p-menu" id="menu">
    <div class="l-container">
        <div class="p-menu__inner">

            <div class="p-menu__header">
                <div class="p-menu__heading c-heading">
                    <span class="c-heading__sub">Menu</span>
                    <h2 class="c-heading__main">身体が喜ぶ、旬の味覚</h2>
                </div>
                <a href="<?php echo esc_url(get_post_type_archive_link('menu')); ?>" class="p-menu__view-all">
                    VIEW ALL MENU
                    <span class="material-symbols-outlined">arrow_forward</span>
                </a>
            </div>

            <div class="p-menu__list">
                <?php foreach ($menu_slots as $type => $post_obj) : ?>
                    <?php if ($post_obj) : ?>
                        <?php
                        $post = $post_obj;
                        setup_postdata($post);
                        get_template_part('template-parts/loop', 'menu');
                        ?>
                    <?php else : ?>
                        <article class="p-menu__item is-preparing">
                            <div class="p-menu__img-wrapper">
                                <div class="p-menu__preparing-overlay">COMING SOON</div>
                                <img src="https://placehold.co/600x750/E5E5E5/A8A29E?text=Photo+Preparing" alt="準備中" class="p-menu__img">
                            </div>
                            <div class="p-menu__info">
                                <h3 class="p-menu__name"><?php echo esc_html(strtoupper($type)); ?> 準備中</h3>
                                <p class="p-menu__desc">ただいま新しいメニューを準備しております。公開まで今しばらくお待ちください。</p>
                            </div>
                        </article>
                    <?php endif; ?>
                <?php endforeach;
                wp_reset_postdata(); ?>
            </div>

        </div>
    </div>
</section>