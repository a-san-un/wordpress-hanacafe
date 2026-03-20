# HanaCAFE ACFフィールド依存マップ

最終更新: 2026-03-21
対象: wp/wp-content/themes/hanacafe-theme

## 1. 依存マップの見方

- マスター: どの固定ページまたは投稿文脈から値を取得するか
- フィールド: ACFフィールド名
- 参照箇所: テーマ内の主な利用ファイル
- フォールバック: 未設定時の挙動
- 影響: 欠損時に崩れる画面・機能

## 2. マスター別フィールド一覧

### A. common-info マスター

- マスター解決: get_hanacafe_master_page_id('common-info')
- フィールド: pic
- 参照箇所: template-parts/home/hero.php
- フォールバック: assets/images/hero.jpg, altは固定文言
- 影響: トップヒーロー画像とalt

- フィールド: site_default_image
- 参照箇所: functions.php (get_hanacafe_default_image_url)
- フォールバック: assets/images/coming-soon.jpg
- 影響: アイキャッチ未設定時の全体フォールバック画像

### B. access-info マスター

- マスター解決: get_hanacafe_master_page_id('access-info')
- フィールド: shop_address
- 参照箇所: template-parts/home/access.php, footer.php
- フォールバック: footer.phpでは固定住所文字列
- 影響: Accessセクション、フッター住所

- フィールド: shop_access_note
- 参照箇所: template-parts/home/access.php
- フォールバック: 非表示
- 影響: Access補足文

- フィールド: shop_access_train_1
- 参照箇所: template-parts/home/access.php
- フォールバック: 非表示
- 影響: 交通アクセス行（東急）

- フィールド: shop_access_train_2
- 参照箇所: template-parts/home/access.php
- フォールバック: 非表示
- 影響: 交通アクセス行（JR）

- フィールド: shop_open_hours
- 参照箇所: template-parts/home/access.php
- フォールバック: 非表示
- 影響: 営業時間表示

- フィールド: shop_tel
- 参照箇所: template-parts/home/access.php, footer.php
- フォールバック: footer.phpでは固定電話番号文字列
- 影響: Telリンク生成、フッター電話

- フィールド: shop_closed
- 参照箇所: template-parts/home/access.php
- フォールバック: 非表示
- 影響: 定休日表示

- フィールド: seat_check_url
- 参照箇所: template-parts/home/access.php
- フォールバック: ボタン非表示
- 影響: お席確認ボタン

- フィールド: shop_map_image
- 参照箇所: template-parts/home/access.php
- フォールバック: assets/images/map.png
- 影響: 地図画像表示

- フィールド: shop_map_url
- 参照箇所: template-parts/home/access.php
- フォールバック: 画像のみ表示（リンク化しない）
- 影響: 外部Map遷移

- フィールド: shop_map_btn_text
- 参照箇所: template-parts/home/access.php
- フォールバック: Google Maps で開く
- 影響: 地図オーバーレイ文言

- フィールド: shop_sns_instagram
- 参照箇所: footer.php
- フォールバック: #
- 影響: フッターSNSリンク

- フィールド: shop_sns_facebook
- 参照箇所: footer.php
- フォールバック: #
- 影響: フッターSNSリンク

### C. menu-info マスター

- マスター解決: get_hanacafe_master_page_id('menu-info')
- フィールド: top_menu_food
- 参照箇所: template-parts/home/menu.php -> functions.php(get_hanacafe_top_menu_post)
- フォールバック: taxonomy menu_category=food の最新1件
- 影響: トップMenuのFoodカード

- フィールド: top_menu_drink
- 参照箇所: template-parts/home/menu.php -> functions.php(get_hanacafe_top_menu_post)
- フォールバック: taxonomy menu_category=drink の最新1件
- 影響: トップMenuのDrinkカード

- フィールド: top_menu_dessert
- 参照箇所: template-parts/home/menu.php -> functions.php(get_hanacafe_top_menu_post)
- フォールバック: taxonomy menu_category=dessert の最新1件
- 影響: トップMenuのDessertカード

### D. about-seats マスター

- マスター解決: get_page_by_path('about-seats')
- フィールド: about_section_title
- 参照箇所: template-parts/home/about.php
- フォールバック: 固定文言
- 影響: About見出し

- フィールド: about_section_text
- 参照箇所: template-parts/home/about.php
- フォールバック: 固定文言
- 影響: About本文

- 動的フィールド群（slots = counter, table, terrace）
- フィールド: title_counter, title_table, title_terrace
- フィールド: status_counter, status_table, status_terrace
- フィールド: text_counter, text_table, text_terrace
- フィールド: img_counter, img_table, img_terrace
- フィールド: is_pet_counter, is_pet_table, is_pet_terrace
- 参照箇所: template-parts/home/about.php
- フォールバック: title未設定はカード出力スキップ。img未設定は assets/images/{slug}.jpg
- 影響: 席種カード表示、満空バッジ、Pet Friendlyバッジ

### E. menu 投稿（post_type=menu）

- マスター解決: 個別menu投稿文脈
- フィールド: is_recommended
- 参照箇所: template-parts/loop-menu.php, single-menu.php
- フォールバック: バッジ非表示
- 影響: RECOMMEND表示

- フィールド: menu_sub_img
- 参照箇所: single-menu.php
- フォールバック: アイキャッチ -> 共通デフォルト画像
- 影響: 詳細ページ画像

- フィールド: sub_name
- 参照箇所: template-parts/loop-menu.php, single-menu.php
- フォールバック: 非表示
- 影響: サブタイトル

- フィールド: price
- 参照箇所: template-parts/loop-menu.php, single-menu.php
- フォールバック: 非表示
- 影響: 価格表示

- フィールド: calorie
- 参照箇所: single-menu.php
- フォールバック: 非表示
- 影響: スペック表示

- フィールド: allergies
- 参照箇所: single-menu.php
- フォールバック: 非表示
- 影響: スペック表示

## 3. 運用上の要注意ポイント

- access-info と common-info は欠損時フォールバックがあるが、リンク系は # になるため公開前確認が必要。
- about-seats は get_page_by_path('about-seats') 依存で、ページ未作成時はセクション文言の一部だけ表示される可能性がある。
- menu-info 未設定でも taxonomy フォールバックが効くが、menu_category の slug（food, drink, dessert）が前提。
- menu投稿の ACF 入力不足は非表示化で吸収されるが、情報量が減るため運用チェックが必要。
