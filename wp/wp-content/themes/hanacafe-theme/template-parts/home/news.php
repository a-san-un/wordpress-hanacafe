<section id="news" class="p-news l-section">
    <div class="l-container">
        <div class="p-news__header c-heading">
            <span class="c-heading__sub">News</span>
            <h2 class="c-heading__main">大切なお知らせ</h2>
        </div>

        <div class="p-news__list">
            <?php
            $args = [
                "post_type" => "post",
                "posts_per_page" => 3,
            ];
            $news_query = new WP_Query($args);

            if ($news_query->have_posts()):
                while ($news_query->have_posts()):
                    $news_query->the_post(); ?>
                    <article class="c-card c-card--news">
                        <a href="<?php the_permalink(); ?>" class="c-card__link">
                            <div class="c-card__media">
                                <?php if (has_post_thumbnail()): ?>
                                    <?php the_post_thumbnail("medium", ["class" => "c-card__img"]); ?>
                                <?php else: ?>
                                    <img src="<?php echo get_hanacafe_default_image_url(
                                                    "news-info",
                                                ); ?>" alt="<?php echo esc_attr(
                                                    get_the_title() . " の代替画像",
                                                ); ?>" class="c-card__img">
                                <?php endif; ?>
                            </div>

                            <div class="c-card__body">
                                <time class="c-card__meta" datetime="<?php echo get_the_date("c"); ?>">
                                    <?php echo get_the_date("Y.m.d"); ?>
                                </time>
                                <h3 class="c-card__title">
                                    <?php echo esc_html(get_the_title()); ?>
                                </h3>
                            </div>
                        </a>
                    </article>
                <?php
                endwhile;
                wp_reset_postdata();
            else:
                ?>
                <p class="p-news__empty">現在、新しいお知らせはありません。</p>
            <?php
            endif;
            ?>
        </div>

        <div class="p-news__footer">
            <a href="<?php echo esc_url(get_hanacafe_news_page_url()); ?>" class="c-btn-capsule">
                READ MORE NEWS
            </a>
        </div>
    </div>
</section>