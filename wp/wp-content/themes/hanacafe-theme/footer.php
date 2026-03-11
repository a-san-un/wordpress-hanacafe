<?php

/**
 * Common: Footer
 * [設計意図]
 * 1. 役割: サイト全体のフッター構造とコピーライト管理
 * 2. 黄金律遵守: 背景が濃色のため、白（$c-white）の透過度（70%）を用いて情報の階層化を実現
 * 3. 非破壊の原則: 文言、SNSリンク、ポリシーリンクの構造、およびPHPによる動的年号出力を完全保持
 */
?>

<!-- =============================================
     サイトフッター
     l-footer: レイアウト層、p-footer: プロジェクト層（BEM区分）
============================================= -->
<footer class="l-footer">
    <div class="l-container">
        <div class="l-footer__main">

            <!-- ロゴエリア: クリックでトップページへ遷移 -->
            <div class="p-footer__logo-wrapper">
                <a href="<?php echo esc_url(home_url('/')); /* esc_url でXSS対策 */ ?>" class="l-footer__logo-text">
                    HanaCAFE<br>nappa69
                </a>
            </div>

            <!-- 店舗情報リスト: アイコン（Material Symbols）+ テキストの構成 -->
            <ul class="l-footer__info-list">
                <li class="l-footer__info-item">
                    <span class="material-symbols-outlined" aria-hidden="true">location_on</span>
                    <!-- aria-hidden="true": アイコン文字列をスクリーンリーダーから除外 -->
                    神奈川県川崎市中原区新丸子東1-983-1
                </li>
                <li class="l-footer__info-item">
                    <span class="material-symbols-outlined" aria-hidden="true">call</span>
                    <!-- aria-hidden="true": アイコン文字列をスクリーンリーダーから除外 -->
                    <a href="tel:0448729288">044-872-9288</a> <!-- tel: スキームでモバイルからワンタップ発信可能 -->
                </li>
            </ul>

            <!-- ナビゲーショングループ: SNSリンク + ポリシーリンクをまとめて管理 -->
            <div class="l-footer__nav-group">

                <!-- SNSリンク: target="_blank" + rel="noopener" でセキュリティ確保（タブナビング対策） -->
                <div class="l-footer__sns-links">
                    <a href="#" target="_blank" rel="noopener">INSTAGRAM</a>
                    <a href="#" target="_blank" rel="noopener">FACEBOOK</a>
                </div>

                <!-- ポリシーリンク: 法的必須ページへの導線 -->
                <div class="l-footer__policy-links">
                    <a href="#">プライバシーポリシー</a>
                    <a href="#">特定商取引法に基づく表記</a>
                </div>

            </div>
        </div>

        <!-- フッターボトム: キャッチコピー + コピーライト表記 -->
        <div class="l-footer__bottom">
            <p class="l-footer__tagline">NATURAL. PEACEFUL. HEARTFUL.</p>
            <p class="l-footer__copy">
                &copy; <?php echo date('Y'); /* 現在の西暦を動的出力。手動更新不要 */ ?> HanaCAFE nappa69
            </p>
        </div>

    </div>
</footer>

<?php wp_footer(); /* </body>直前のフック。JSの読み込み・GTM等のスクリプト挿入に使用 */ ?>
</body>

</html>