<?php get_header(); ?>

<main>
    <section class="relative h-screen flex items-center justify-center overflow-hidden">
        <img class="absolute inset-0 w-full h-full object-cover object-[50%_35%] scale-105" src="<?php echo esc_url(get_template_directory_uri() . '/images/hero.jpg'); ?>" alt="HanaCAFE nappa69">

        <div class="absolute inset-0 bg-dark-green/20 z-0 mix-blend-multiply"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-transparent via-dark-green/20 to-transparent z-0"></div>

        <div class="text-center text-white z-10">
            <h2 class="text-4xl md:text-6xl font-serif mb-6 leading-tight drop-shadow-lg">日常に緑を、心に安らぎを。</h2>
            <p class="text-lg md:text-xl opacity-90 drop-shadow-md">体に優しい 心が嬉しい お料理</p>
        </div>
    </section>

    <section id="about" class="py-24 bg-[#F5F2E8] reveal">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <span class="text-sm tracking-[0.3em] text-dark-green font-bold">ABOUT & SEAT</span>
                <h2 class="text-3xl font-serif mt-4">物語が動き出す、呼吸する空間</h2>
            </div>

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

                foreach ($seat_types as $seat) :
                    // ACFメタボックスから値を取得（未設定時は ok をデフォルトに）
                    $current_status = get_field($seat['field']) ?: 'ok';
                    // ↓↓ この1行を追加して、画面に文字を出してみる ↓↓
                    // echo '<p style="color:red; font-weight:bold;">[' . $seat['field'] . ' の今の値は: ' . $current_status . ']</p>';
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
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>