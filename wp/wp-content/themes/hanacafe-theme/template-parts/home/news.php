<section id="news" class="p-news l-section">
    <div class="l-container">
        <div class="p-news__header c-heading">
            <span class="c-heading__sub">News</span>
            <h2 class="c-heading__main">大切なお知らせ</h2>
        </div>

        <div class="p-news__list">
            <?php
            $args = array(
                'post_type'      => 'post',
                'posts_per_page' => 3,
            );
            $news_query = new WP_Query($args);

            if ($news_query->have_posts()) :
                while ($news_query->have_posts()) : $news_query->the_post();
            ?>
                    <article class="p-news-card">
                        <a href="<?php the_permalink(); ?>" class="p-news-card__link">
                            <div class="p-news-card__img-box">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium', array('class' => 'p-news-card__img')); ?>
                                <?php else : ?>
                                    <img src="<?php echo get_hanacafe_default_image_url('news-info'); ?>" alt="<?php echo esc_attr(get_the_title() . ' の代替画像'); ?>" class="p-news-card__img">
                                <?php endif; ?>
                            </div>

                            <div class="p-news-card__body">
                                <time class="p-news-card__date" datetime="<?php echo get_the_date('c'); ?>">
                                    <?php echo get_the_date('Y.m.d'); ?>
                                </time>
                                <h3 class="p-news-card__title">
                                    <?php // [fix 1-4]
                                    echo esc_html(get_the_title()); ?>
                                </h3>
                            </div>
                        </a>
                    </article>
                <?php
                endwhile;
                wp_reset_postdata();
            else :
                ?>
                <p class="p-news__empty">現在、新しいお知らせはありません。</p>
            <?php endif; ?>
        </div>

        <div class="p-news__footer">
            <a href="<?php echo esc_url(get_post_type_archive_link('post')); ?>" class="c-btn-capsule">
                READ MORE NEWS
            </a>
        </div>
    </div>
</section>