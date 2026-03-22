<?php

/**
 * Hero Section Template
 */

// ACF pic フィールドから画像取得（common-info 固定ページ）
$pic = get_field("pic", get_hanacafe_master_page_id("common-info"));
$hero_img_url = $pic ? $pic["url"] : get_template_directory_uri() . "/assets/images/coming-soon.jpg";
$hero_alt = $pic && !empty($pic["alt"]) ? $pic["alt"] : "HanaCAFE nappa69 メインビジュアル";
?>

<section class="p-hero u-alignfull">
    <div class="p-hero__inner">
        <div class="p-hero__img">
            <img
                src="<?php echo esc_url($hero_img_url); ?>"
                alt="<?php echo esc_attr($hero_alt); ?>"
                fetchpriority="high"
                loading="eager">
        </div>

        <div class="p-hero__content">
            <div class="l-container">
                <div class="p-hero__title-box">
                    <h2 class="p-hero__title">
                        <span class="p-hero__title-en">Slow Time,</span>
                        <span class="p-hero__title-en">Slow Life.</span>
                        <span class="p-hero__title-jp">木漏れ日と、手作りの温もり。</span>
                    </h2>
                </div>
            </div>
        </div>
    </div>
</section>