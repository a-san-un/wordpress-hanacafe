<?php

/**
 * Template part for displaying the access section.
 * * 修正内容: 
 * - Google Maps リンクの更新
 * - マップ画像の比率(810:673)維持設定
 * - 数字の強調スタイル調整
 *
 * @package HanaCAFE_Theme
 */
?>
<section id="access" class="p-access">
    <div class="p-access__inner l-container">

        <div class="p-access__info">
            <div class="p-access__header">
                <span class="p-access__subtitle">Access</span>
                <h2 class="p-access__title">アクセス・店舗情報</h2>
            </div>

            <dl class="p-access__list">
                <div class="p-access__row">
                    <dt class="p-access__label">Address</dt>
                    <dd class="p-access__detail">
                        <p class="p-access__text">神奈川県川崎市中原区新丸子東1-983-1</p>
                        <p class="p-access__note">※新丸子駅西口より商店街を抜けてすぐ</p>
                    </dd>
                </div>

                <div class="p-access__row">
                    <dt class="p-access__label">Access</dt>
                    <dd class="p-access__detail">
                        <div class="p-access__transport-item">
                            <span class="p-access__badge p-access__badge--tokyu">東急</span>
                            <p class="p-access__text">東横線「新丸子駅」西口 徒歩<span class="p-access__num">2</span>分</p>
                        </div>
                        <div class="p-access__transport-item">
                            <span class="p-access__badge p-access__badge--jr">JR</span>
                            <p class="p-access__text">南武線・横須賀線「武蔵小杉駅」JR北口 徒歩<span class="p-access__num">5</span>分</p>
                        </div>
                    </dd>
                </div>

                <div class="p-access__row">
                    <dt class="p-access__label">Hours</dt>
                    <dd class="p-access__detail">
                        <p class="p-access__text">11:00 - 23:00 <span class="p-access__small">(L.O. 22:30)</span></p>
                        <div class="p-access__note">
                            <p>Lunch: 11:30-16:00 / Cafe: 15:00-18:00 / Dinner: 18:00-23:00</p>
                            <p class="p-access__alert">※木曜日のみ 17:00 クローズ</p>
                        </div>
                    </dd>
                </div>

                <div class="p-access__row p-access__row--split">
                    <div class="p-access__col">
                        <dt class="p-access__label">Tel</dt>
                        <dd class="p-access__text p-access__text--large">
                            <a href="tel:0448729288">044-872-9288</a>
                        </dd>
                    </div>
                    <div class="p-access__col">
                        <dt class="p-access__label">Closed</dt>
                        <dd class="p-access__text p-access__text--large">不定休</dd>
                    </div>
                </div>
            </dl>

            <div class="p-access__action">
                <a href="<?php echo esc_url(home_url('/reservation/')); ?>" class="p-access__btn">
                    <span class="material-symbols-outlined">calendar_month</span>
                    お席の確認
                </a>
            </div>
        </div>

        <div class="p-access__map">
            <a href="https://maps.app.goo.gl/7kTkwWaozcjH1z6f9" target="_blank" rel="noopener" class="p-access__map-link">
                <img src="<?php echo esc_url(get_theme_file_uri('/assets/images/map.png')); ?>" alt="HanaCAFE nappa69 周辺地図" class="p-access__map-img">
                <span class="p-access__map-overlay">Google Maps で見る</span>
            </a>
        </div>

    </div>
</section>