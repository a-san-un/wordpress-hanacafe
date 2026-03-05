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