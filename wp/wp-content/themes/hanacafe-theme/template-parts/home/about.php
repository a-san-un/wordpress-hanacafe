<?php

/**
 * About & Seats Section
 * [設計意図]
 * 1. ACFスラッグ(ok/few/full)への完全対応
 * 2. 状態に応じたバッジの「クラス名・アイコン・ラベル」の動的生成
 * 3. セキュリティ強化（出力時のエスケープ処理徹底）
 */

// フロントページ以外の表示も考慮し、現在のページIDを取得
$home_id = get_the_ID();

/**
 * 席種の設定データ
 * メンテナンス性を高めるため、ループ外で配列として定義
 */
$seat_configs = [
    [
        'title'      => '一人の時間を愉しむ',
        'text'       => '読書や作業に最適な窓際席。自分だけの静かなリズムを。',
        'img'        => 'counter.jpg',
        'field_name' => 'status_counter', // ACFフィールド名
        'is_pet'     => false
    ],
    [
        'title'      => '大切な人と寛ぐ',
        'text'       => 'ゆったりとしたソファ席。美味しいお料理を囲みながら。',
        'img'        => 'table.jpg',
        'field_name' => 'status_table',   // ACFフィールド名
        'is_pet'     => false
    ],
    [
        'title'      => '自然の風を感じる',
        'text'       => '四季を肌で感じる縁側席。ペットと一緒にリフレッシュ。',
        'img'        => 'terrace.jpg',
        'field_name' => 'status_terrace', // ACFフィールド名
        'is_pet'     => true
    ],
];
?>

<section id="about" class="p-about l-container l-section">
    <div class="p-about__header">
        <div class="p-about__heading c-heading">
            <span class="c-heading__sub">About & Seats</span>
            <h2 class="c-heading__main">物語が動き出す、呼吸する空間。</h2>
        </div>
        <div class="p-about__text">
            <p>築数十年の古民家をリノベーションしたHanaCAFE nappa69。都会の喧騒を忘れ、植物の息吹を感じる空間で、玄米や有機野菜を中心とした体に優しいお料理をご用意しております。シーンに合わせて選べる3つの空間で、心地よいひとときをお過ごしください。</p>
        </div>
    </div>

    <div class="p-about__grid">
        <?php foreach ($seat_configs as $config) : ?>
            <?php
            /**
             * バッジの状態判定ロジック
             * ACFの戻り値（スラッグ）を基準に、表示内容を分岐させる
             */
            $status = get_field($config['field_name'], $home_id) ?: 'ok';

            // デフォルト設定：◯ 空席あり
            $badge_label = '◯ 空席あり';
            $badge_modifier = 'is-success'; // _c-badge.scss で定義した緑色
            $icon = 'check_circle';

            if ($status === 'few') {
                // △ 残りわずか
                $badge_label = '△ 残りわずか';
                $badge_modifier = 'is-alert';   // _c-badge.scss で定義したオレンジ色
                $icon = 'warning';
            } elseif ($status === 'full') {
                // ✕ 満席
                $badge_label = '✕ 満席';
                $badge_modifier = 'is-full';    // 満席用のクラス
                $icon = 'block';
            }
            ?>
            <article class="p-seat-card">
                <figure class="p-seat-card__img-box">
                    <img src="<?php echo esc_url(get_theme_file_uri('/assets/images/' . $config['img'])); ?>"
                        alt="<?php echo esc_attr($config['title']); ?>"
                        class="p-seat-card__img">

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