<?php

/**
 * Home: Access Section (完全CMS化版)
 * [設計意図]
 * 1. システム分離: 店舗情報は固定ページ 'access' で一括管理。
 * 2. UX最適化: URL未入力時でも画像は表示させ、レイアウト崩れを防ぐ。
 * 3. 柔軟な画像管理: オーナーが画像をアップすれば差し替わり、なければデフォルトを表示。
 */

$access_page = get_page_by_path('access');
$access_id = $access_page ? $access_page->ID : 0;
?>
<section id="access" class="p-access l-section">
  <div class="p-access__inner l-container">

    <div class="p-access__info">
      <div class="p-access__header c-heading">
        <span class="c-heading__sub">Access</span>
        <h2 class="c-heading__main">アクセス・店舗情報</h2>
      </div>

      <dl class="p-access__list">
        <?php // --- 住所 --- 
        ?>
        <?php if ($val = get_field('shop_address', $access_id)) : ?>
          <div class="p-access__row">
            <dt class="p-access__label">Address</dt>
            <dd class="p-access__detail">
              <p class="p-access__text"><?php echo esc_html($val); ?></p>
              <?php if ($note = get_field('shop_access_note', $access_id)) : ?>
                <p class="p-access__note"><?php echo esc_html($note); ?></p>
              <?php endif; ?>
            </dd>
          </div>
        <?php endif; ?>

        <?php // --- 交通アクセス --- 
        ?>
        <?php if ($train1 = get_field('shop_access_train_1', $access_id)) : ?>
          <div class="p-access__row">
            <dt class="p-access__label">Access</dt>
            <dd class="p-access__detail">
              <div class="p-access__transport-item">
                <span class="p-access__badge p-access__badge--tokyu">東急</span>
                <span class="p-access__text"><?php echo wp_kses_post($train1); ?></span>
              </div>
              <?php if ($train2 = get_field('shop_access_train_2', $access_id)) : ?>
                <div class="p-access__transport-item">
                  <span class="p-access__badge p-access__badge--jr">JR</span>
                  <span class="p-access__text"><?php echo wp_kses_post($train2); ?></span>
                </div>
              <?php endif; ?>
            </dd>
          </div>
        <?php endif; ?>

        <?php // --- 営業時間 --- 
        ?>
        <?php if ($hours = get_field('shop_open_hours', $access_id)) : ?>
          <div class="p-access__row">
            <dt class="p-access__label">Open</dt>
            <dd class="p-access__detail">
              <p class="p-access__text"><?php echo nl2br(esc_html($hours)); ?></p>
            </dd>
          </div>
        <?php endif; ?>

        <?php // --- 電話・定休日 --- 
        ?>
        <div class="p-access__row p-access__row--split">
          <?php if ($tel = get_field('shop_tel', $access_id)) : ?>
            <div class="p-access__col">
              <dt class="p-access__label">Tel</dt>
              <dd class="p-access__text p-access__text--large">
                <a href="tel:<?php echo esc_attr(str_replace('-', '', $tel)); ?>">
                  <?php echo esc_html($tel); ?>
                </a>
              </dd>
            </div>
          <?php endif; ?>

          <?php if ($closed = get_field('shop_closed', $access_id)) : ?>
            <div class="p-access__col">
              <dt class="p-access__label">Closed</dt>
              <dd class="p-access__text p-access__text--large">
                <?php echo esc_html($closed); ?>
              </dd>
            </div>
          <?php endif; ?>
        </div>
      </dl>

      <?php // --- お席の確認ボタン --- 
      ?>
      <?php if ($url = get_field('seat_check_url', $access_id)) : ?>
        <div class="p-access__action">
          <a href="<?php echo esc_url($url); ?>" class="p-access__btn" target="_blank" rel="noopener">
            <span class="material-symbols-outlined">calendar_month</span>
            お席の確認
          </a>
        </div>
      <?php endif; ?>
    </div>

    <?php // --- 地図エリア --- 
    ?>
    <div class="p-access__map">
      <?php
      // 1. 画像データの取得（堅牢なフォールバック）
      $map_image = get_field('shop_map_image', $access_id);
      $map_img_src = (is_array($map_image) && !empty($map_image['url'])) ? $map_image['url'] : get_theme_file_uri('/assets/images/map.png');
      $map_img_alt = (is_array($map_image) && !empty($map_image['alt'])) ? $map_image['alt'] : 'HanaCAFE nappa69 周辺地図';

      // 2. リンクURLとボタン文言の取得
      $map_url = get_field('shop_map_url', $access_id);
      $map_btn_text = get_field('shop_map_btn_text', $access_id) ?: 'Google Maps で開く';
      ?>

      <?php if ($map_url) : ?>
        <?php // URLがある場合：リンク化し、オーバーレイボタンを表示する 
        ?>
        <a href="<?php echo esc_url($map_url); ?>" target="_blank" rel="noopener" class="p-access__map-link">
          <img src="<?php echo esc_url($map_img_src); ?>"
            alt="<?php echo esc_attr($map_img_alt); ?>"
            width="810" height="673"
            class="p-access__map-img"
            loading="lazy">
          <div class="p-access__map-overlay">
            <span class="p-access__map-btn"><?php echo esc_html($map_btn_text); ?></span>
          </div>
        </a>
      <?php else : ?>
        <?php // URLがない場合：画像のみをシンプルに表示する（リンク・ボタンなし） 
        ?>
        <img src="<?php echo esc_url($map_img_src); ?>"
          alt="<?php echo esc_attr($map_img_alt); ?>"
          width="810" height="673"
          class="p-access__map-img"
          loading="lazy">
      <?php endif; ?>
    </div>

  </div>
</section>