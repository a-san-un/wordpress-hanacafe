<?php

/**
 * About & Seats Section
 * * [修正ポイント]
 * 1. 以前動いていた get_field() ロジックを、新しいBEM構造へ再統合。
 * 2. $seat_data 配列の 'field_name' を、実際のACFフィールド名に合わせてください。
 */

// 固定ページのIDを取得（front-page.php等で使用している場合、aboutページのIDを指定すると確実です）
$about_page = get_page_by_path('about');
$post_id = $about_page ? $about_page->ID : get_the_ID();
?>

<section class="p-about l-container">
    <div class="p-about__header">
        <span class="p-about__label">About & Seats</span>
        <h2 class="p-about__title"><?php echo esc_html(get_the_title($post_id)); ?></h2>
        <div class="p-about__text">
            <?php
            $content = get_post_field('post_content', $post_id);
            echo wp_kses_post(wpautop($content));
            ?>
        </div>
    </div>

    <div class="p-about__grid u-grid">
        <?php
        // 座席データの定義（'field_name' はACFのフィールド名に合わせて要確認）
        $seat_configs = [
            [
                'title' => '一人の時間を愉しむ',
                'text'  => '読書や作業に最適な窓際席。自分だけの静かなリズムを。',
                'img'   => 'counter.jpg',
                'field_name' => 'seat1_status', // ★ここを実際のACFフィールド名に！
                'is_pet' => false
            ],
            [
                'title' => '大切な人と寛ぐ',
                'text'  => 'ゆったりとしたソファ席。美味しいお料理を囲みながら。',
                'img'   => 'sofa.jpg',
                'field_name' => 'seat2_status', // ★ここを実際のACFフィールド名に！
                'is_pet' => false
            ],
            [
                'title' => '自然の風を感じる',
                'text'  => '四季の移ろいを肌で感じる縁側席。ペットと一緒に。',
                'img'   => 'terrace.jpg',
                'field_name' => 'seat3_status', // ★ここを実際のACFフィールド名に！
                'is_pet' => true
            ],
        ];

        foreach ($seat_configs as $config) :
            // 以前のロジック：ACFから値を取得
            $current_status = get_field($config['field_name'], $post_id) ?: 'ok';

            // 表示の切り替え判定
            $badge_label = '◯ 空席あり';
            $badge_modifier = 'is-success';
            $icon = 'check_circle';

            if ($current_status === 'few') {
                $badge_label = '△ 残りわずか';
                $badge_modifier = 'is-alert';
                $icon = 'warning';
            } elseif ($current_status === 'full') {
                $badge_label = '✕ 満席';
                $badge_modifier = 'is-full';
                $icon = 'block';
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
        <a href="<?php echo esc_url(home_url('/about/')); ?>" class="c-btn-capsule">
            空間について詳しく見る
        </a>
    </div>
</section>