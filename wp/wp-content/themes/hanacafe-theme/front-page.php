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
    <section id="menu" class="py-20 bg-white">
        <div class="container mx-auto px-4 max-w-5xl">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-serif tracking-widest text-[#2E4D07] mb-2">MENU</h2>
                <p class="text-stone-400 text-sm tracking-widest uppercase">Healthy & Delicious</p>
            </div>

            <div class="grid md:grid-cols-3 gap-12">
                <div class="group">
                    <div class="overflow-hidden rounded-lg mb-4 aspect-square shadow-sm">
                        <img src="http://googleusercontent.com/placeholder-salad"
                            alt="nappa特製 15品目のサラダプレート"
                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="flex justify-between items-baseline mb-2">
                        <h3 class="font-bold text-lg text-stone-800">15品目のサラダプレート</h3>
                        <span class="text-[#F29159] font-serif">¥1,480</span>
                    </div>
                    <p class="text-stone-500 text-sm leading-relaxed">
                        契約農家から届く有機野菜をたっぷりと。自家製ドレッシングで素材の味を。
                    </p>
                </div>

                <div class="group">
                    <div class="overflow-hidden rounded-lg mb-4 aspect-square shadow-sm">
                        <img src="http://googleusercontent.com/placeholder-dessert"
                            alt="季節のテリーヌショコラ"
                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="flex justify-between items-baseline mb-2">
                        <h3 class="font-bold text-lg text-stone-800">季節のテリーヌショコラ</h3>
                        <span class="text-[#F29159] font-serif">¥800</span>
                    </div>
                    <p class="text-stone-500 text-sm leading-relaxed">
                        濃厚ながらも後味は軽やか。旬のフルーツを添えた、心ほどける一皿。
                    </p>
                </div>

                <div class="group">
                    <div class="overflow-hidden rounded-lg mb-4 aspect-square shadow-sm">
                        <img src="http://googleusercontent.com/placeholder-drink"
                            alt="自家製ハーブレモネード"
                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="flex justify-between items-baseline mb-2">
                        <h3 class="font-bold text-lg text-stone-800">自家製レモネード</h3>
                        <span class="text-[#F29159] font-serif">¥750</span>
                    </div>
                    <p class="text-stone-500 text-sm leading-relaxed">
                        数種のハーブを漬け込んだ、爽やかな香りと優しい甘みが特徴。
                    </p>
                </div>
            </div>

            <div class="mt-16 text-center">
                <a href="#" class="capsule-btn">VIEW ALL MENU</a>
            </div>
        </div>
    </section>
    <section id="access" class="py-20 bg-[#F5F2E8]">
        <div class="container mx-auto px-4 max-w-5xl">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-serif tracking-widest text-[#2E4D07] mb-2">ACCESS</h2>
                <p class="text-stone-400 text-sm tracking-widest uppercase">Map & Information</p>
            </div>

            <div class="grid md:grid-cols-2 gap-12 items-start">
                <div class="w-full h-[400px] rounded-xl overflow-hidden shadow-md bg-stone-100">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3244.6033327663223!2d139.65882697624646!3d35.58814573539062!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60185f83984d416b%3A0x6a0c56784013470!2sHanaCAFE%20nappa69!5e0!3m2!1sja!2sjp!4v1710000000000!5m2!1sja!2sjp"
                        width="100%"
                        height="100%"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

                <div class="flex flex-col gap-6 text-stone-700">
                    <div>
                        <h3 class="font-bold text-[#2E4D07] mb-2">住所</h3>
                        <p class="text-sm leading-relaxed">
                            〒211-0004<br>
                            神奈川県川崎市中原区新丸子町963-1
                        </p>
                    </div>
                    <div>
                        <h3 class="font-bold text-[#2E4D07] mb-2">アクセス</h3>
                        <p class="text-sm leading-relaxed">
                            東急東横線「新丸子駅」西口より徒歩2分<br>
                            JR南武線・横須賀線「武蔵小杉駅」北口より徒歩7分
                        </p>
                    </div>
                    <div>
                        <h3 class="font-bold text-[#2E4D07] mb-2">営業時間 / 定休日</h3>
                        <p class="text-sm leading-relaxed">
                            11:00 - 23:00 (L.O. 22:30)<br>
                            定休日：不定休
                        </p>
                    </div>
                    <div class="mt-4">
                        <a href="tel:0448729286" class="capsule-btn text-center w-full md:w-auto">
                            お電話でお問い合わせ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="news" class="py-20 bg-white">
        <div class="container mx-auto px-4 max-w-5xl">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-4">
                <div>
                    <h2 class="text-3xl font-serif tracking-widest text-[#2E4D07] mb-2">NEWS</h2>
                    <p class="text-stone-400 text-sm tracking-widest uppercase">Latest Updates</p>
                </div>
                <a href="<?php echo esc_url(get_post_type_archive_link('post')); ?>" class="text-stone-500 hover:text-[#2E4D07] transition-colors text-sm tracking-widest flex items-center gap-2 group">
                    VIEW ALL
                    <span class="transform group-hover:translate-x-1 transition-transform">→</span>
                </a>
            </div>

            <div class="grid gap-8">
                <?php
                $args = array(
                    'post_type'      => 'post',
                    'posts_per_page' => 3,
                );
                $news_query = new WP_Query($args);

                if ($news_query->have_posts()) :
                    while ($news_query->have_posts()) : $news_query->the_post();
                ?>
                        <article class="group border-b border-stone-100 pb-8 last:border-0">
                            <a href="<?php the_permalink(); ?>" class="flex flex-col md:flex-row gap-4 md:items-center">
                                <time class="text-stone-400 font-medium text-sm w-32" datetime="<?php echo get_the_date('c'); ?>">
                                    <?php echo get_the_date('Y . m . d'); ?>
                                </time>
                                <div class="flex-1">
                                    <h3 class="text-lg text-stone-800 group-hover:text-[#2E4D07] transition-colors duration-300">
                                        <?php the_title(); ?>
                                    </h3>
                                </div>
                                <div class="text-[#F29159] opacity-0 group-hover:opacity-100 transition-opacity">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </a>
                        </article>
                    <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    ?>
                    <p class="text-stone-500">現在、新しいお知らせはありません。</p>
                <?php endif; ?>
            </div>
        </div>
    </section>





</main>

<?php get_footer(); ?>