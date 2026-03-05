<section id="about" class="section-base reveal">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <span class="text-sm tracking-[0.3em] text-dark-green font-bold">ABOUT & SEATS</span>
            <h2 class="text-3xl font-serif mt-4">物語が動き出す、呼吸する空間</h2>
        </div>

        <div class="grid md:grid-cols-3 gap-8 mb-16">
            <?php
            $seat_types = [
                [
                    'id'    => 'counter',
                    'title' => 'COUNTER SEAT',
                    'desc'  => '一人の時間を愉しむ。<br>読書や作業に最適な窓際席。柔らかな光に包まれて、自分だけの静かなリズムを取り戻す場所に。',
                    'img'   => get_template_directory_uri() . '/images/counter.jpg',
                    'field' => 'status_counter',
                    'pet'   => false
                ],
                [
                    'id'    => 'table',
                    'title' => 'TABLE & SOFA',
                    'desc'  => '大切な人と寛ぐ。<br>ゆったりとしたソファ席。美味しいお料理を囲みながら、会話が弾む温かな時間をご提供します。',
                    'img'   => get_template_directory_uri() . '/images/table.jpg',
                    'field' => 'status_table',
                    'pet'   => false
                ],
                [
                    'id'    => 'terrace',
                    'title' => 'PORCH / TERRACE',
                    'desc'  => '自然の風を感じる。<br>四季の移ろいを肌で感じる縁側席。ペットと一緒に、開放的な空間でリフレッシュ。',
                    'img'   => get_template_directory_uri() . '/images/terrace.jpg',
                    'field' => 'status_terrace',
                    'pet'   => true
                ]
            ];

            foreach ($seat_types as $seat) {
                $current_status = get_field($seat['field']) ?: 'ok';
                $badge_label = '◯ 空席あり';
                $badge_class = 'badge-ok';
                $icon        = 'check_circle';

                if ($current_status === 'few') {
                    $badge_label = '△ 残りわずか';
                    $badge_class = 'badge-few';
                    $icon        = 'warning';
                } elseif ($current_status === 'full') {
                    $badge_label = '✕ 満席';
                    $badge_class = 'badge-full';
                    $icon        = 'block';
                }
            ?>
                <div class="card group">
                    <div class="card-image-wrap">
                        <img src="<?php echo esc_url($seat['img']); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="<?php echo esc_attr($seat['title']); ?>">

                        <div class="badge <?php echo $badge_class; ?>">
                            <span class="material-symbols-outlined" style="font-size: 14px;"><?php echo $icon; ?></span><?php echo $badge_label; ?>
                        </div>

                        <?php if ($seat['pet']) { ?>
                            <div class="absolute top-4 left-4 bg-white/90 text-dark-green text-xs px-3 py-1.5 rounded-full flex items-center gap-1 backdrop-blur-sm font-medium z-10">
                                <span class="material-symbols-outlined" style="font-size: 14px;">pets</span>Pet Friendly
                            </div>
                        <?php } ?>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title"><?php echo $seat['title']; ?></h3>
                        <p class="card-text"><?php echo $seat['desc']; ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="text-center">
            <a href="<?php echo esc_url(home_url('/concept/')); ?>" class="inline-block border-2 border-dark-green text-dark-green px-10 py-3 rounded-full hover:bg-dark-green hover:text-white transition-colors text-sm font-bold tracking-widest">
                空間について詳しく見る
            </a>
        </div>
    </div>
</section>