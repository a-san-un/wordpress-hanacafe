<?php

/**
 * About & Seats Section
 */

// 空席状況のACFフィールドは「現在のページ(Home)」にあるため、現在のIDを取得
$home_id = get_the_ID();
?>

<section class="p-about l-container">
    <div class="p-about__header">
        <span class="p-about__label">About & Seats</span>
        <h2 class="p-about__title">物語が動き出す、呼吸する空間。</h2>
        <div class="p-about__text">
            <p>築数十年の古民家をリノベーションしたHanaCAFE nappa69。都会の喧騒を忘れ、植物の息吹を感じる空間で、玄米や有機野菜を中心とした体に優しいお料理をご用意しております。シーンに合わせて選べる3つの空間で、心地よいひとときをお過ごしください。</p>
        </div>
    </div>

    <div class="p-about__grid u-grid">
        <?php
        // 座席データとACFフィールド名のマッピング（Homeに紐づくフィールドを指定）
        $seat_configs = [
            [
                'title'      => '一人の時間を愉しむ',
                'text'       => '読書や作業に最適な窓際席。自分だけの静かなリズムを。',
                'img'        => 'counter.jpg',
                'field_name' => 'status_counter', // 管理画面のACFフィールド名
                'is_pet'     => false
            ],
            [
                'title'      => '大切な人と寛ぐ',
                'text'       => 'ゆったりとしたソファ席。美味しいお料理を囲みながら。',
                'img'        => 'table.jpg',
                'field_name' => 'status_table',   // 管理画面のACFフィールド名
                'is_pet'     => false
            ],
            [
                'title'      => '自然の風を感じる',
                'text'       => '四季の移ろいを肌で感じる縁側席。ペットと一緒に。',
                'img'        => 'terrace.jpg',
                'field_name' => 'status_terrace', // 管理画面のACFフィールド名
                'is_pet'     => true
            ],
        ];

        foreach ($seat_configs as $config) :
            // HomeページのID($home_id)から値を取得
            $current_status = get_field($config['field_name'], $home_id) ?: 'ok';

            // デフォルト設定
            $badge_label    = '◯ 空席あり';
            $badge_modifier = 'is-success';
            $icon           = 'check_circle';

            // ステータスに応じた切り替え
            if ($current_status === 'few') {
                $badge_label    = '△ 残りわずか';
                $badge_modifier = 'is-alert';
                $icon           = 'warning';
            } elseif ($current_status === 'full') {
                $badge_label    = '✕ 満席';
                $badge_modifier = 'is-full';
                $icon           = 'block';
            }
        ?>
            <article class="p-seat-card">
                <figure class="p-seat-card__img-box">
                    <img src="<?php echo esc_url(get_theme_file_uri('/assets/images/' . $config['img'])); ?>" alt="<?php echo esc_attr($config['title']); ?>" class="p-seat-card__img">

                    <div class="c-badge-status <?php echo esc_attr($badge_modifier); ?>">
                        <span class="material-symbols-outlined"><?php echo esc_html($icon); ?></span>
                        <span class="c-badge-status__text"><?php echo esc_html($badge_label); ?></span>
                    </div>

                    <?php if ($config['is_pet']) : ?>
                        <div class="c-badge-feature">
                            <span class="material-symbols-outlined">pets</span>
                            <span class="c-badge-feature__text">Pet Friendly</span>
                        </div>
                    <?php endif; ?>
                </figure>
                <div class="p-seat-card__body">
                    <h3 class="p-seat-card__title"><?php echo esc_html($config['title']); ?></h3>
                    <p class="p-seat-card__text"><?php echo esc_html($config['text']); ?></p>
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