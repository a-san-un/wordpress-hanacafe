<?php

/**
 * Common: Footer
 * [設計意図]
 * 1. 役割: サイト全体のフッター構造とコピーライト管理
 * 2. 黄金律遵守: 背景が濃色のため、白（$c-white）の透過度（70%）を用いて情報の階層化を実現
 * 3. 非破壊の原則: 文言、SNSリンク、ポリシーリンクの構造、およびPHPによる動的年号出力を完全保持
 * 4. SSOTの徹底: 店舗情報ページ(access-info)をマスターとし、そこから住所・SNS情報を取得。DRY原則を遵守。
 */

// [fix 2-1]
$access_id = get_hanacafe_master_page_id('access-info') ?: 0;

// 住所・電話番号の取得 (Accessセクションと共通のフィールドを使用)
$shop_address = get_field('shop_address', $access_id) ?: '神奈川県川崎市中原区新丸子東1-983-1';
$shop_tel     = get_field('shop_tel', $access_id) ?: '044-872-9288';

// SNSリンクの取得 (ACF: shop_sns_instagram / shop_sns_facebook)
// 未設定時は '#' をフォールバックとして設定し、レイアウト崩れ（Blackout）を防ぐ
$insta_url = get_field('shop_sns_instagram', $access_id) ?: '#';
$fb_url    = get_field('shop_sns_facebook', $access_id) ?: '#';

// プライバシーポリシーURLの取得（WP標準設定）
$privacy_url = get_privacy_policy_url() ?: '#';
?>

<!-- =============================================
     サイトフッター
     l-footer: レイアウト層、p-footer: プロジェクト層（BEM区分）
============================================= -->
<footer class="l-footer">
    <div class="l-container">
        <div class="l-footer__main">

            <!-- ロゴエリア: クリックでトップページへ遷移 -->
            <div class="l-footer__logo-wrapper">
                <a href="<?php echo esc_url(home_url('/')); /* esc_url でXSS対策 */ ?>" class="l-footer__logo-text">
                    HanaCAFE<br>nappa69
                </a>
            </div>

            <!-- 店舗情報リスト: アイコン（Material Symbols）+ テキストの構成 -->
            <ul class="l-footer__info-list">
                <li class="l-footer__info-item">
                    <span class="material-symbols-outlined" aria-hidden="true">location_on</span>
                    <!-- aria-hidden="true": アイコン文字列をスクリーンリーダーから除外 -->
                    <?php echo esc_html($shop_address); ?>
                </li>
                <li class="l-footer__info-item">
                    <span class="material-symbols-outlined" aria-hidden="true">call</span>
                    <!-- aria-hidden="true": アイコン文字列をスクリーンリーダーから除外 -->
                    <a href="tel:<?php echo esc_attr(str_replace('-', '', $shop_tel)); ?>"><?php echo esc_html($shop_tel); ?></a>
                </li>
            </ul>

            <!-- ナビゲーショングループ: SNSリンク + ポリシーリンクをまとめて管理 -->
            <div class="l-footer__nav-group">

                <!-- SNSリンク: target="_blank" + rel="noopener" でセキュリティ確保（タブナビング対策） -->
                <div class="l-footer__sns-links">
                    <a href="<?php echo esc_url($insta_url); ?>" target="_blank" rel="noopener">INSTAGRAM</a>
                    <a href="<?php echo esc_url($fb_url); ?>" target="_blank" rel="noopener">FACEBOOK</a>
                </div>

                <!-- ポリシーリンク: 法的必須ページへの導線 -->
                <div class="l-footer__policy-links">
                    <a href="<?php echo esc_url($privacy_url); ?>">プライバシーポリシー</a>
                    <a href="#">特定商取引法に基づく表記</a>
                </div>

            </div>
        </div>

        <!-- フッターボトム: キャッチコピー + コピーライト表記 -->
        <div class="l-footer__bottom">
            <p class="l-footer__tagline">NATURAL. PEACEFUL. HEARTFUL.</p>
            <p class="l-footer__copyright">
                &copy; <?php // [fix 1-2]
                        echo esc_html(wp_date('Y')); ?> HanaCAFE nappa69
            </p>
        </div>

    </div>
</footer>

<?php wp_footer(); /* </body>直前のフック。JSの読み込み・GTM等のスクリプト挿入に使用 */ ?>
</body>

</html>