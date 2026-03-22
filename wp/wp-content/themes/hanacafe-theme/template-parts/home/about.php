<?php

/**
 * About & Seats Section (プランB：システム分離 × プランC：セマンティック版)
 * [設計意図]
 * 1. 管理分離: スラッグ 'about-seats' の専用ページで店舗情報を一括管理（プランB）。
 * 2. 非破壊: Repeaterを使わず、役割名（counter等）に基づいた個別フィールドをループ処理（プランC）。
 * 3. 表示保証: 席の「名称」が未入力のスロットは出力自体をスキップし、不完全なカードを表示させない。
 * 4. 黄金律: 補足テキスト（text_...）に透過 0.7 を適用。
 */

$about = get_hanacafe_about_data();
?>

<section id="about" class="p-about l-container l-section">
    <div class="p-about__header">
        <div class="p-about__heading c-heading">
            <span class="c-heading__sub">About & Seats</span>
            <h2 class="c-heading__main"><?php echo esc_html($about['section_title']); ?></h2>
        </div>
        <div class="p-about__text">
            <p><?php echo nl2br(esc_html($about['section_text'])); ?></p>
        </div>
    </div>

    <div class="p-about__grid">
        <?php
		foreach ($about['seats'] as $seat) :
			?>
            <article class="p-seat-card">
                <figure class="p-seat-card__img-box">
                    <img src="<?php echo esc_url($seat['image_url']); ?>"
                        alt="<?php echo esc_attr($seat['image_alt']); ?>"
                        class="p-seat-card__img"
                        loading="lazy">

                    <div class="c-badge-status <?php echo esc_attr($seat['badge_modifier']); ?>">
                        <span class="material-symbols-outlined"><?php echo esc_html($seat['icon']); ?></span>
                        <span class="c-badge-status__text"><?php echo esc_html($seat['badge_label']); ?></span>
                    </div>

                    <?php if ($seat['is_pet']) : ?>
                        <div class="c-badge-feature">
                            <span class="material-symbols-outlined">pets</span>
                            <span class="c-badge-feature__text">Pet Friendly</span>
                        </div>
                    <?php endif; ?>
                </figure>
                <div class="p-seat-card__body">
                    <h3 class="p-seat-card__title"><?php echo esc_html($seat['title']); ?></h3>
                    <p class="p-seat-card__text"><?php echo nl2br(esc_html($seat['text'])); ?></p>
                </div>
            </article>
        <?php endforeach; ?>
    </div>

    <div class="p-about__footer">
        <a href="<?php echo esc_url(home_url('/concept/')); ?>" class="c-btn-capsule">
            空間について詳しく見る
        </a>
    </div>
</section>