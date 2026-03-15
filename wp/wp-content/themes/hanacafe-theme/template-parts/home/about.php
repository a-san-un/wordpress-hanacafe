<?php

/**
 * About & Seats Section (プランB：システム分離 × プランC：セマンティック版)
 * [設計意図]
 * 1. 管理分離: スラッグ 'about-seats' の専用ページで店舗情報を一括管理（プランB）。
 * 2. 非破壊: Repeaterを使わず、役割名（counter等）に基づいた個別フィールドをループ処理（プランC）。
 * 3. 表示保証: 席の「名称」が未入力のスロットは出力自体をスキップし、不完全なカードを表示させない。
 * 4. 黄金律: 補足テキスト（text_...）に透過 0.7 を適用。
 */

// スラッグ名から専用固定ページのIDを特定（環境に依存しない動的解決）
$about_page = get_page_by_path('about-seats');
$about_id = $about_page ? $about_page->ID : 0;
?>

<section id="about" class="p-about l-container l-section">
    <div class="p-about__header">
        <div class="p-about__heading c-heading">
            <span class="c-heading__sub">About & Seats</span>
            <h2 class="c-heading__main"><?php echo esc_html(get_field('about_section_title', $about_id) ?: '物語が動き出す、呼吸する空間。'); ?></h2>
        </div>
        <div class="p-about__text">
            <p><?php echo nl2br(esc_html(get_field('about_section_text', $about_id) ?: '築数十年の古民家をリノベーションしたHanaCAFE nappa69。都会の喧騒を忘れ、植物の息吹を感じる空間で、心地よいひとときをお過ごしください。')); ?></p>
        </div>
    </div>

    <div class="p-about__grid">
        <?php
        /**
         * 席種ごとのスロット定義（ACFフィールド名の接尾辞と対応）
         */
        $slots = ['counter', 'table', 'terrace'];

        foreach ($slots as $slug) :
            // 各種データの取得（役割名に基づいた動的解決）
            $title  = get_field("title_{$slug}", $about_id);

            // 【表示保証】名称がないスロットは出力スキップ（Blackout防止）
            if (!$title) continue;

            $status = get_field("status_{$slug}", $about_id) ?: 'ok';
            $text   = get_field("text_{$slug}", $about_id);
            $image  = get_field("img_{$slug}", $about_id);

            // 特定の席（テラス等）に紐付く個別フラグの取得
            $is_pet = get_field("is_pet_{$slug}", $about_id);

            /**
             * バッジの状態判定ロジック
             */
            $badge_label = '◯ 空席あり';
            $badge_modifier = 'is-success';
            $icon = 'check_circle';

            if ($status === 'few') {
                $badge_label = '△ 残りわずか';
                $badge_modifier = 'is-alert';
                $icon = 'warning';
            } elseif ($status === 'full') {
                $badge_label = '✕ 満席';
                $badge_modifier = 'is-full';
                $icon = 'block';
            }

            /**
             * 画像の取得とフォールバック
             * largeサイズを優先し、なければテーマ内デフォルト画像を表示
             */
            $img_src = (is_array($image) && !empty($image['sizes']['large'])) ? $image['sizes']['large'] : get_theme_file_uri("/assets/images/{$slug}.jpg");
        ?>
            <article class="p-seat-card">
                <figure class="p-seat-card__img-box">
                    <img src="<?php echo esc_url($img_src); ?>"
                        alt="<?php echo esc_attr($title); ?>"
                        class="p-seat-card__img"
                        loading="lazy">

                    <div class="c-badge-status <?php echo esc_attr($badge_modifier); ?>">
                        <span class="material-symbols-outlined"><?php echo esc_html($icon); ?></span>
                        <span class="c-badge-status__text"><?php echo esc_html($badge_label); ?></span>
                    </div>

                    <?php if ($is_pet) : ?>
                        <div class="c-badge-feature">
                            <span class="material-symbols-outlined">pets</span>
                            <span class="c-badge-feature__text">Pet Friendly</span>
                        </div>
                    <?php endif; ?>
                </figure>
                <div class="p-seat-card__body">
                    <h3 class="p-seat-card__title"><?php echo esc_html($title); ?></h3>
                    <p class="p-seat-card__text"><?php echo nl2br(esc_html($text)); ?></p>
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