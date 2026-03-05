<section id="seat" class="pb-24 bg-[#F5F2E8] reveal">
    <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-3 gap-8">
            <?php
            // 席種情報を配列にまとめる
            $seat_types = [
                [
                    'id'    => 'counter',
                    'title' => 'COUNTER SEAT',
                    'desc'  => '自分だけの静かなリズムを取り戻す場所に。',
                    'img'   => get_template_directory_uri() . '/images/counter.jpg',
                    'field' => 'status_counter' // ACFのフィールド名
                ],
                [
                    'id'    => 'table',
                    'title' => 'TABLE & SOFA',
                    'desc'  => '会話が弾む温かな時間をご提供します。',
                    'img'   => get_template_directory_uri() . '/images/table.jpg',
                    'field' => 'status_table'
                ],
                [
                    'id'    => 'terrace',
                    'title' => 'PORCH / TERRACE',
                    'desc'  => '四季を感じる開放的な空間でリフレッシュ。',
                    'img'   => get_template_directory_uri() . '/images/terrace.jpg',
                    'field' => 'status_terrace'
                ]
            ];

            foreach ($seat_types as $seat) {
                // ACFメタボックスから値を取得（未設定時は ok をデフォルトに）
                $current_status = get_field($seat['field']) ?: 'ok';

                // ステータスに応じた見た目の切り替え
                $badge_label = '◯ 空席あり';
                $badge_color = 'bg-dark-green';
                $icon        = 'check_circle';

                if ($current_status === 'few') {
                    $badge_label = '△ 残りわずか';
                    $badge_color = 'bg-nappa-orange';
                    $icon        = 'warning';
                } elseif ($current_status === 'full') {
                    $badge_label = '✕ 満席';
                    $badge_color = 'bg-stone-500';
                    $icon        = 'block';
                }
            ?>
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    <div class="relative h-64 overflow-hidden">
                        <img src="<?php echo esc_url($seat['img']); ?>" class="w-full h-full object-cover" alt="<?php echo esc_attr($seat['title']); ?>">
                        <div class="absolute top-4 right-4 <?php echo $badge_color; ?> text-white text-[11px] px-3 py-1 rounded-full flex items-center gap-1 shadow-md">
                            <span class="material-symbols-outlined text-[14px]"><?php echo $icon; ?></span><?php echo $badge_label; ?>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-serif mb-2"><?php echo $seat['title']; ?></h3>
                        <p class="text-sm text-stone-500 leading-relaxed"><?php echo $seat['desc']; ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>