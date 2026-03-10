<?php

/**
 * Home: Access Section
 * [設計意図]
 * 1. 構造化: dt/ddによる定義リストを用いて、住所・交通・営業時間を論理的にマークアップ
 * 2. 視認性: 黄金律に基づき、ラベルを70%透過に設定し（SCSS）、情報の主従を明確化
 * 3. ユーザビリティ: 地図画像全体をリンク化し、外部マップアプリへの遷移を容易にする
 */
?>
<section id="access" class="p-access l-section">
    <div class="p-access__inner l-container">

        <div class="p-access__info">
            <div class="p-access__header c-heading">
                <span class="c-heading__sub">Access</span>
                <h2 class="c-heading__main">アクセス・店舗情報</h2>
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
                            <span class="p-access__text">東横線「新丸子駅」西口 徒歩<span class="p-access__time-number">2</span>分</span>
                        </div>
                        <div class="p-access__transport-item">
                            <span class="p-access__badge p-access__badge--jr">JR</span>
                            <span class="p-access__text">南武線・横須賀線「武蔵小杉駅」JR北口 徒歩<span class="p-access__time-number">5</span>分</span>
                        </div>
                    </dd>
                </div>

                <div class="p-access__row">
                    <dt class="p-access__label">Open</dt>
                    <dd class="p-access__detail">
                        <div class="p-access__time-item">
                            <p class="p-access__text">11:00 - 18:00（L.O. 17:30）</p>
                            <p class="p-access__note">※金・土のみ 21:00 にクローズ</p>
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
            <a href="https://maps.app.goo.gl/3A6r9vG3U2DkY7mHA" target="_blank" rel="noopener" class="p-access__map-link">
                <img src="<?php echo esc_url(get_theme_file_uri('/assets/images/map.png')); ?>"
                    alt="HanaCAFE nappa69 周辺地図"
                    width="810" height="673"
                    class="p-access__map-img"
                    loading="lazy">
                <div class="p-access__map-overlay">
                    <span class="p-access__map-btn">Google Maps で開く</span>
                </div>
            </a>
        </div>
    </div>
</section>