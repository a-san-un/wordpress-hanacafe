<?php

/**
 * Common: Footer
 * [設計意図]
 * 1. 役割: サイト全体のフッター構造とコピーライト管理
 * 2. 黄金律遵守: 背景が濃色のため、白（$c-white）の透過度（70%）を用いて情報の階層化を実現
 * 3. 非破壊の原則: 文言、SNSリンク、ポリシーリンクの構造、およびPHPによる動的年号出力を完全保持
 * 4. SSOTの徹底: 店舗情報ページ(access-info)をマスターとし、そこから住所・SNS情報を取得。DRY原則を遵守。
 * 5. ガードの役割: shop_address / shop_tel は ACF 未入力時に空文字を返すため、
 *    !empty() ガードで <li> 全体をスキップし空タグ・不完全 tel: リンクの出力を防ぐ。
 */

$access = get_hanacafe_access_data(); ?>

<!-- =============================================
     サイトフッター
     l-footer: レイアウト層、p-footer: プロジェクト層（BEM区分）
============================================= -->
<footer class="l-footer">
    <div class="l-container">
        <div class="l-footer__main">

            <!-- ロゴエリア: クリックでトップページへ遷移 -->
            <div class="l-footer__logo-wrapper">
                <a href="<?php echo esc_url(home_url("/"));
/* esc_url でXSS対策 */
?>" class="l-footer__logo-text">
                    HanaCAFE<br>nappa69
                </a>
            </div>

            <!-- 店舗情報リスト: アイコン（Material Symbols）+ テキストの構成 -->
            <ul class="l-footer__info-list">

                <?php if ( ! empty( $access['shop_address'] ) ) : ?>
                <li class="l-footer__info-item">
                    <span class="material-symbols-outlined" aria-hidden="true">location_on</span>
                    <!-- aria-hidden="true": アイコン文字列をスクリーンリーダーから除外 -->
                    <?php echo esc_html( $access['shop_address'] ); ?>
                </li>
                <?php endif; ?>

                <?php if ( ! empty( $access['shop_tel'] ) ) : ?>
                <li class="l-footer__info-item">
                    <span class="material-symbols-outlined" aria-hidden="true">call</span>
                    <!-- aria-hidden="true": アイコン文字列をスクリーンリーダーから除外 -->
                    <a href="<?php echo esc_url( 'tel:' . $access['shop_tel'] ); ?>">
                        <?php echo esc_html( $access['shop_tel'] ); ?>
                    </a>
                </li>
                <?php endif; ?>

            </ul>

            <!-- ナビゲーショングループ: SNSリンク + ポリシーリンクをまとめて管理 -->
            <div class="l-footer__nav-group">

                <!-- SNSリンク: target="_blank" + rel="noopener" でセキュリティ確保（タブナビング対策） -->
                <div class="l-footer__sns-links">
                    <a href="<?php echo esc_url(
                      $access["shop_sns_instagram"],
                    ); ?>" target="_blank" rel="noopener noreferrer">INSTAGRAM</a>
                    <a href="<?php echo esc_url(
                      $access["shop_sns_facebook"],
                    ); ?>" target="_blank" rel="noopener noreferrer">FACEBOOK</a>
                </div>

                <!-- ポリシーリンク: 法的必須ページへの導線 -->
                <div class="l-footer__policy-links">
                    <a href="<?php echo esc_url($access["privacy_url"]); ?>"> プライバシーポリシー</a>
                    <a href="#" aria-disabled="true" tabindex="-1">特定商取引法に基づく表記</a>
                </div>

            </div>
        </div>

        <!-- フッターボトム: キャッチコピー + コピーライト表記 -->
        <div class="l-footer__bottom">
            <p class="l-footer__tagline">NATURAL. PEACEFUL. HEARTFUL.</p>
            <p class="l-footer__copyright">
                &copy; <?php // [fix 1-2]

echo esc_html(wp_date("Y")); ?> HanaCAFE nappa69
            </p>
        </div>

    </div>
</footer>

<?php wp_footer();
/* </body>直前のフック。JSの読み込み・GTM等のスクリプト挿入に使用 */
?>
</body>

</html>
