<?php

/**
 * HanaCAFE Theme Functions
 * WordPress 6.9 / ACF / CPTUI
 */

// ============================================================
// 1. テーマセットアップ
// ============================================================
add_action("after_setup_theme", function () {
  add_theme_support("title-tag");
  add_theme_support("post-thumbnails");
  add_theme_support("html5", ["search-form", "comment-form", "comment-list", "gallery", "caption", "style", "script"]);
  register_nav_menus([
    "global-nav" => "グローバルナビゲーション",
    "drawer-nav" => "ドロワーナビゲーション",
  ]);
});

// タイトル区切り文字を「|」に変更
add_filter("document_title_separator", function ($sep) {
  return "|";
});


// ============================================================
// 2. アセット読み込み
// ============================================================

// Google Fonts preconnect タグ変換（グローバルで1回だけ登録）
add_filter(
  "style_loader_tag",
  function ($html, $handle) {
    $preconnects = ["hanacafe-fonts-preconnect-1", "hanacafe-fonts-preconnect-2"];
    return in_array($handle, $preconnects, true)
      ? str_replace("rel='stylesheet'", "rel='preconnect' crossorigin", $html)
      : $html;
  },
  10,
  2,
);

add_action("wp_enqueue_scripts", function () {
  $dir = get_template_directory();
  $uri = get_template_directory_uri();

  wp_enqueue_style("hanacafe-fonts-preconnect-1", "https://fonts.googleapis.com", [], null);
  wp_enqueue_style("hanacafe-fonts-preconnect-2", "https://fonts.gstatic.com", [], null);
  wp_enqueue_style(
    "hanacafe-fonts",
    "https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Noto+Sans+JP:wght@400;700&family=Noto+Serif+JP:wght@700&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap",
    [],
    null,
  );
  wp_enqueue_style(
    "hanacafe-app-style",
    $uri . "/assets/css/app.css",
    ["hanacafe-fonts"],
    file_exists($dir . "/assets/css/app.css") ? filemtime($dir . "/assets/css/app.css") : null,
  );
  wp_enqueue_script("hanacafe-main-js", $uri . "/assets/js/main.js", [], file_exists($dir . "/assets/js/main.js")  ? filemtime($dir . "/assets/js/main.js")  : null, [
    "strategy" => "defer",
    "in_footer" => true,
  ]);
});

// ============================================================
// 3. クエリ・テンプレート制御
// ============================================================
add_action("pre_get_posts", function ($query) {
  if (!is_admin() && $query->is_main_query() && $query->is_post_type_archive("menu")) {
    $query->set("posts_per_page", -1);
  }
});

add_filter("template_include", function ($template) {
  return is_home() && ($t = locate_template("archive-post.php")) ? $t : $template;
});

// ============================================================
// 4. ヘルパー関数
// ============================================================

// ── 4-1. 基盤ユーティリティ ──────────────────────────────────
// get_hanacafe_master_page_id / get_hanacafe_default_image_url
// get_hanacafe_news_page_url
// 他のヘルパーが内部依存するため、このグループを先頭に置く

/** menu_category の正規スラッグ一覧を返す（順序保証） */
function get_hanacafe_menu_categories()
{
  return ["food", "drink", "dessert"];
}

/** スラッグから固定ページIDを取得 */
function get_hanacafe_master_page_id($slug)
{
  $page = get_page_by_path($slug);
  return $page ? $page->ID : false;
}

/** ACF連動デフォルト画像URL（フォールバック付き） */
function get_hanacafe_default_image_url($slug = "common-info")
{
  $img_val = ($id = get_hanacafe_master_page_id($slug)) ? get_field("site_default_image", $id) : "";
  $url = is_array($img_val) ? $img_val["url"] ?? "" : (is_string($img_val) ? $img_val : "");
  return esc_url($url ?: get_theme_file_uri("/assets/images/coming-soon.jpg"));
}

/** ニュース一覧ページURL */
function get_hanacafe_news_page_url()
{
  $id = get_option("page_for_posts");
  return $id ? get_permalink($id) : home_url("/news/");
}

/** トップページ用メニュー投稿取得（menu.php から呼び出し） */
function get_hanacafe_top_menu_post($field_name, $term_slug)
{
  $post_obj = get_field($field_name, get_hanacafe_master_page_id("menu-info"));
  if ($post_obj) {
    return $post_obj;
  }

  $query = new WP_Query([
    "post_type" => "menu",
    "posts_per_page" => 1,
    "tax_query" => [
      [
        "taxonomy" => "menu_category",
        "field" => "slug",
        "terms" => $term_slug,
      ],
    ],
  ]);
  return $query->have_posts() ? $query->posts[0] : null;
}

// ── 4-2. トップページ用データ取得 ────────────────────────────
// get_hanacafe_top_menu_post
// front-page.php の menu セクションから呼び出される

/**
 * About セクション用データ取得
 * @param string $slug マスターページスラッグ（デフォルト: 'about-seats'）
 * @return array{
 *   section_title: string,
 *   section_text: string,
 *   seats: array<int, array{
 *     slug: string,
 *     title: string,
 *     text: string,
 *     status: string,
 *     badge_label: string,
 *     badge_modifier: string,
 *     icon: string,
 *     image_url: string,
 *     image_alt: string,
 *     is_pet: bool,
 *   }>
 * }
 */
function get_hanacafe_about_data($slug = "about-seats")
{
  // スラッグ名から専用固定ページのIDを特定（環境に依存しない動的解決）
  $about_id = get_hanacafe_master_page_id($slug) ?: 0;

  $section_title = get_field("about_section_title", $about_id) ?: "物語が動き出す、呼吸する空間。";
  $section_text =
    get_field("about_section_text", $about_id) ?:
    "築数十年の古民家をリノベーションしたHanaCAFE nappa69。都会の喧騒を忘れ、植物の息吹を感じる空間で、心地よいひとときをお過ごしください。";

  /**
   * 席種ごとのスロット定義（ACFフィールド名の接尾辞と対応）
   */
  $slots = ["counter", "table", "terrace", "private"];
  $seats = [];

  foreach ($slots as $slot_slug) {
    // 各種データの取得（役割名に基づいた動的解決）
    $title = get_field("title_{$slot_slug}", $about_id);

    // 【表示保証】名称がないスロットは出力スキップ（Blackout防止）
    if (!$title) {
      continue;
    }

    $status_field = get_field("status_{$slot_slug}", $about_id);
    $status = in_array($status_field, ["ok", "few", "full"], true) ? $status_field : "ok";
    $text = get_field("text_{$slot_slug}", $about_id) ?: "";
    $image = get_field("img_{$slot_slug}", $about_id);

    // 特定の席（テラス等）に紐付く個別フラグの取得
    $is_pet = (bool) get_field("is_pet_{$slot_slug}", $about_id);

    /**
     * バッジの状態判定ロジック
     */
    $badge_label = "空席あり";
    $badge_modifier = "is-ok";
    $icon = "check_circle";

    if ($status === "few") {
      $badge_label = "残りわずか";
      $badge_modifier = "is-few";
      $icon = "error";
    } elseif ($status === "full") {
      $badge_label = "満席";
      $badge_modifier = "is-full";
      $icon = "cancel";
    }

    /**
     * 画像の取得とフォールバック
     * largeサイズを優先し、なければテーマ内デフォルト画像を表示
     */
    $image_url =
      is_array($image) && !empty($image["sizes"]["large"])
        ? $image["sizes"]["large"]
        : get_theme_file_uri("/assets/images/{$slot_slug}.jpg");

    $seats[] = [
      "slug" => $slot_slug,
      "title" => $title,
      "text" => $text,
      "status" => $status,
      "badge_label" => $badge_label,
      "badge_modifier" => $badge_modifier,
      "icon" => $icon,
      "image_url" => $image_url,
      "image_alt" => $title,
      "is_pet" => $is_pet,
    ];
  }

  return [
    "section_title" => $section_title,
    "section_text" => $section_text,
    "seats" => $seats,
  ];
}

// ── 4-3. セクションデータ取得（バックエンドロジック分離層）────
// get_hanacafe_about_data / get_hanacafe_access_data
// get_hanacafe_menu_data
// STEP 6 で分離したテンプレートデータ取得の責務を担う

/**
 * Access セクション用データ取得
 * @param string $slug マスターページスラッグ（デフォルト: 'access-info'）
 * @return array
 */
function get_hanacafe_access_data(string $slug = "access-info"): array
{
  $access_id = get_hanacafe_master_page_id($slug) ?: 0;

  $map_image = get_field("shop_map_image", $access_id);
  $map_image_url = is_array($map_image) ? $map_image["url"] ?? "" : (is_string($map_image) ? $map_image : "");
  $map_image_alt = is_array($map_image) ? $map_image["alt"] ?? "" : "";

  return [
    "shop_address" => get_field("shop_address", $access_id) ?: "神奈川県川崎市中原区新丸子東1-983-1",
    "shop_tel" => get_field("shop_tel", $access_id) ?: "044-872-9288",
    "shop_access_note" => get_field("shop_access_note", $access_id) ?: "",
    "shop_access_train_1" => get_field("shop_access_train_1", $access_id) ?: "",
    "shop_access_train_2" => get_field("shop_access_train_2", $access_id) ?: "",
    "shop_open_hours" => get_field("shop_open_hours", $access_id) ?: "",
    "shop_closed" => get_field("shop_closed", $access_id) ?: "",
    "seat_check_url" => get_field("seat_check_url", $access_id) ?: "",
    "shop_map_image_url" => $map_image_url ?: get_theme_file_uri("/assets/images/map.png"),
    "shop_map_image_alt" => $map_image_alt ?: "店舗地図",
    "shop_map_url" => get_field("shop_map_url", $access_id) ?: "",
    "shop_map_btn_text" => get_field("shop_map_btn_text", $access_id) ?: "Google Maps で開く",
    "shop_sns_instagram" => get_field("shop_sns_instagram", $access_id) ?: "#",
    "shop_sns_facebook" => get_field("shop_sns_facebook", $access_id) ?: "#",
    "privacy_url" => get_privacy_policy_url() ?: "#",
  ];
}

/**
 * menu 投稿の ACF 整形済みデータを返す。
 * single-menu.php / loop-menu.php の共通データ取得層。
 * 画像優先順位: menu_sub_img > アイキャッチ > デフォルト画像（menu-info）
 *
 * @param  int $post_id 対象投稿 ID。0 の場合はカレント投稿を使用。
 * @return array{
 *   image_url:      string,   // esc_url 済み
 *   image_alt:      string,   // esc_attr 済み（alt 空時はタイトルで補完）
 *   is_recommended: bool,
 *   sub_name:       string,   // esc_html 済み。未設定時は空文字
 *   price_raw:      int|null, // 整形前の生値。未設定時は null
 *   price_display:  string,   // number_format 済み。未設定時は空文字
 * }
 */
function get_hanacafe_menu_data(int $post_id = 0): array
{
  if (0 === $post_id) {
    $post_id = get_the_ID();
  }

  // ── 画像解決（menu_sub_img > アイキャッチ > デフォルト） ──
  $sub_img = get_field("menu_sub_img", $post_id);
  if ($sub_img && is_array($sub_img)) {
    $image_url = isset($sub_img["sizes"]["large"]) ? $sub_img["sizes"]["large"] : $sub_img["url"];
    $image_alt = !empty($sub_img["alt"]) ? $sub_img["alt"] : get_the_title($post_id);
  } elseif (has_post_thumbnail($post_id)) {
    $thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), "large");
    $image_url = $thumb ? $thumb[0] : get_hanacafe_default_image_url("menu-info");
    $image_alt = get_the_title($post_id);
  } else {
    $image_url = get_hanacafe_default_image_url("menu-info");
    $image_alt = get_the_title($post_id);
  }

  // ── 価格整形（空なら null / 空文字で統一） ──
  $price_raw = get_field("price", $post_id);
  $price_raw = $price_raw ? (int) $price_raw : null;
  $price_display = $price_raw !== null ? number_format($price_raw) : "";

  return [
    "image_url" => esc_url($image_url),
    "image_alt" => esc_attr($image_alt),
    "is_recommended" => (bool) get_field("is_recommended", $post_id),
    "sub_name" => esc_html((string) get_field("sub_name", $post_id)),
    "price_raw" => $price_raw,
    "price_display" => esc_html($price_display),
  ];
}

// ============================================================
// 5. 画像フォールバック & Alt補完
// ============================================================

/** アイキャッチ未設定時にデフォルト画像を表示（優先度10・引数5個必須） */
function hanacafe_fallback_thumbnail_html($html, $post_id, $post_thumbnail_id, $size, $attr)
{
  if (!empty($html) || is_admin()) {
    return $html;
  }
  $class = esc_attr((isset($attr["class"]) ? $attr["class"] : "wp-post-image") . " p-common-placeholder");
  return sprintf(
    '<img src="%s" alt="%s" class="%s" />',
    get_hanacafe_default_image_url(),
    esc_attr(get_the_title($post_id) . " の代替画像"),
    $class,
  );
}
add_filter("post_thumbnail_html", "hanacafe_fallback_thumbnail_html", 10, 5);

/** Alt属性が空の場合に記事タイトルで補完（優先度20） */
add_filter(
  "post_thumbnail_html",
  function ($html, $post_id) {
    return preg_match('/alt=(["\'])\1/', $html)
      ? preg_replace('/alt=(["\'])\1/', 'alt="' . esc_attr(get_the_title($post_id)) . '"', $html, 1)
      : $html;
  },
  20,
  2,
);

// ============================================================
// 6. ナビゲーション BEM クラス / リンク属性
// ============================================================
add_filter(
  "nav_menu_css_class",
  function ($classes, $item, $args) {
    if ($args->theme_location === "global-nav") {
      $classes[] = "l-header__nav-item";
    } elseif ($args->theme_location === "drawer-nav") {
      $classes[] = "p-drawer__item";
    }
    return $classes;
  },
  10,
  3,
);

add_filter(
  "nav_menu_link_attributes",
  function ($atts, $item, $args) {
    if ($args->theme_location === "global-nav") {
      $atts["class"] = "l-header__nav-link";
    } elseif ($args->theme_location === "drawer-nav") {
      $atts["class"] = "p-drawer__link";
    }
    if (isset($atts["href"]) && str_starts_with($atts["href"], "/#")) {
      $atts["href"] = home_url($atts["href"]);
    }
    return $atts;
  },
  10,
  3,
);

// ============================================================
// 7. セキュリティ最適化
// ============================================================
remove_action("wp_head", "wp_generator");
