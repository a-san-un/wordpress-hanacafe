<?php

/**
 * Common: Footer
 * [設計意図]
 * 1. 役割: サイト全体のフッター構造とコピーライト管理
 * 2. 黄金律遵守: 背景が濃色のため、白（$c-white）の透過度（70%）を用いて情報の階層化を実現
 * 3. 非破壊の原則: 文言、SNSリンク、ポリシーリンクの構造、およびPHPによる動的年号出力を完全保持
 */
?>
<footer class="l-footer">
    <div class="l-container">
        <div class="l-footer__main">
            <div class="l-footer__logo">
                <h2 class="l-footer__logo-text">HanaCAFE<br>nappa69</h2>
            </div>

            <ul class="l-footer__info-list">
                <li class="l-footer__info-item">
                    <span class="material-symbols-outlined" aria-hidden="true">location_on</span>
                    神奈川県川崎市中原区新丸子東1-983-1
                </li>
                <li class="l-footer__info-item">
                    <span class="material-symbols-outlined" aria-hidden="true">call</span>
                    <a href="tel:0448729288">044-872-9288</a>
                </li>
            </ul>

            <div class="l-footer__nav-group">
                <div class="l-footer__sns-links">
                    <a href="#" target="_blank" rel="noopener">INSTAGRAM</a>
                    <a href="#" target="_blank" rel="noopener">FACEBOOK</a>
                </div>
                <div class="l-footer__policy-links">
                    <a href="#">プライバシーポリシー</a>
                    <a href="#">特定商取引法に基づく表記</a>
                </div>
            </div>
        </div>

        <div class="l-footer__bottom">
            <p class="l-footer__tagline">NATURAL. PEACEFUL. HEARTFUL.</p>
            <p class="l-footer__copy">&copy; <?php echo date('Y'); ?> HanaCAFE nappa69</p>
        </div>
    </div>
</footer>