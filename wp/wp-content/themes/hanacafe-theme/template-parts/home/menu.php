<?php

/**
 * Template part for displaying the menu section.
 * * @package HanaCAFE_Theme
 */
?>
<section id="menu" class="p-menu l-section">
    <div class="p-menu__inner l-container">

        <div class="p-menu__header">
            <div class="p-menu__heading">
                <span class="p-menu__subtitle">Menu</span>
                <h2 class="p-menu__title">身体が喜ぶ、旬の味覚。</h2>
            </div>

            <a href="<?php echo esc_url(home_url('/menu/')); ?>" class="p-menu__link c-link-arrow">
                VIEW ALL MENU
                <span class="material-symbols-outlined">arrow_forward</span>
            </a>
        </div>

        <ul class="p-menu__list">

            <li class="p-menu__item">
                <div class="p-menu__img-wrapper">
                    <img src="<?php echo esc_url(get_theme_file_uri('/assets/images/nappa_plate.jpg')); ?>" alt="nappaごはんプレート" class="p-menu__img" loading="lazy">
                </div>
                <div class="p-menu__info">
                    <h3 class="p-menu__name">nappaごはんプレート</h3>
                    <div class="p-menu__desc-top">
                        <span class="p-menu__tag">玄米と有機野菜</span>を中心とした、日替わりのおかずプレート。
                    </div>
                    <p class="p-menu__desc">契約農家直送の旬野菜をたっぷり使用。素材の味を活かした、心身ともに満たされる看板メニューです。</p>
                    <span class="p-menu__price">&yen;1,480</span>
                </div>
            </li>

            <li class="p-menu__item">
                <div class="p-menu__img-wrapper">
                    <img src="<?php echo esc_url(get_theme_file_uri('/assets/images/cheesecake.jpg')); ?>" alt="季節ごとのチーズケーキ" class="p-menu__img" loading="lazy">
                </div>
                <div class="p-menu__info">
                    <h3 class="p-menu__name">季節ごとのチーズケーキ</h3>
                    <div class="p-menu__desc-top">
                        濃厚ながらも甘さ控えめ。旬のフルーツを添えた自家製スイーツ。
                    </div>
                    <p class="p-menu__desc">厳選したチーズを使用し、しっとり焼き上げました。季節によって変化するフレーバーをお楽しみください。</p>
                    <span class="p-menu__price">&yen;700 〜</span>
                </div>
            </li>

            <li class="p-menu__item">
                <div class="p-menu__img-wrapper">
                    <img src="<?php echo esc_url(get_theme_file_uri('/assets/images/coffee.jpg')); ?>" alt="ハンドドリップコーヒー" class="p-menu__img" loading="lazy">
                </div>
                <div class="p-menu__info">
                    <h3 class="p-menu__name">ハンドドリップコーヒー</h3>
                    <div class="p-menu__desc-top">
                        一杯ずつ丁寧に。香り高い、至福のひとときを。
                    </div>
                    <p class="p-menu__desc">豆の個性を最大限に引き出すため、注文を受けてから挽き、丁寧にハンドドリップで淹れています。</p>
                    <span class="p-menu__price">&yen;600 〜</span>
                </div>
            </li>

        </ul>
    </div>
</section>