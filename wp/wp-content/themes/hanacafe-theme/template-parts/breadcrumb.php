<?php

/**
 * パンくずリスト表示パーツ（共通）
 * Yoast SEO の yoast_breadcrumb() を使用
 * 呼び出し: get_template_part('template-parts/breadcrumb')
 */
if (function_exists('yoast_breadcrumb')) :
    yoast_breadcrumb(
        '<nav class="p-page__breadcrumb" aria-label="パンくずナビゲーション">',
        '</nav>'
    );
endif;
