# HanaCAFE 実行環境前提 監査チェックリスト

最終更新: 2026-03-21
対象: wp/wp-content/themes/hanacafe-theme
目的: 本番・検証環境で機能が欠落しないための前提確認

## 1. 必須ランタイム

### 1.1 PHP

- [ ] PHP 8.0以上（str_starts_with 使用のため）
- [ ] fileinfo, mbstring など一般的なWordPress必須拡張が有効

### 1.2 WordPress

- [ ] WordPress 6.3以上（wp_enqueue_script の strategy オプション利用）
- [ ] 推奨は 6.9系（プロジェクト文書の前提）
- [ ] パーマリンク設定が有効（投稿・CPTの遷移確認）

### 1.3 Node.js（開発時）

- [ ] Node.js 18以上を利用
- [ ] npm install が完了
- [ ] npm run lint が成功

## 2. 必須プラグイン・データモデル

### 2.1 ACF

- [ ] Advanced Custom Fields が有効
- [ ] 以下のマスター系ページが存在
  - [ ] common-info
  - [ ] access-info
  - [ ] menu-info
  - [ ] about-seats
- [ ] 主要フィールドグループが紐付いている
  - [ ] Hero用 pic
  - [ ] 共通 fallback 用 site_default_image
  - [ ] Access用 shop\_\* / seat_check_url / map系
  - [ ] Menu用 top*menu*\* と menu投稿用詳細フィールド

### 2.2 CPT / Taxonomy

- [ ] post_type menu が登録済み
- [ ] taxonomy menu_category が登録済み
- [ ] menu_category に slug food, drink, dessert が存在
  - スラッグ値は get_hanacafe_menu_categories()（functions.php）で一元管理。カテゴリー追加時は同関数のみ修正すればよい。
- [ ] menu投稿が最低1件以上存在（トップ・一覧の表示確認用）

## 3. テーマアセット依存

### 3.1 必須ファイル

- [ ] assets/css/app.css が存在
- [ ] assets/js/main.js が存在
- [ ] assets/images/coming-soon.jpg が存在
- [ ] assets/images/map.png が存在
- [ ] assets/images/hero.jpg が存在

### 3.2 外部ネットワーク

- [ ] fonts.googleapis.com への疎通
- [ ] fonts.gstatic.com への疎通
- [ ] CSPやFW設定でGoogle Fontsがブロックされていない

## 4. テーマ機能前提

### 4.1 ナビゲーション

- [ ] global-nav にメニュー割り当て済み
- [ ] drawer-nav にメニュー割り当て済み
- [ ] ハンバーガー開閉、Esc閉鎖、フォーカストラップが動作

### 4.2 画像フォールバック

- [ ] アイキャッチ未設定投稿でデフォルト画像表示
- [ ] alt未設定画像でタイトル補完が動作

### 4.3 テンプレート分岐

- [ ] home投稿一覧が archive-post.php に切り替わる
- [ ] menuアーカイブが全件表示（posts_per_page=-1）

## 5. セキュリティ・運用品質

### 5.1 出力エスケープ

- [ ] 主要テンプレートで esc_html / esc_attr / esc_url が適用
- [ ] Access交通情報の許可HTMLが想定通り（wp_kses_post）

### 5.2 デバッグ・ログ

- [ ] WP_DEBUG, WP_DEBUG_LOG の運用方針を環境別に定義
- [ ] PHP Warning/Notice がフロントに表示されない設定

## 6. 受け入れテスト（最小）

- [ ] トップページ
  - [ ] Hero表示（画像あり・なし両方）
  - [ ] Aboutカード3種の表示
  - [ ] Menu 3カテゴリの表示または準備中カード
  - [ ] Access情報と地図リンクの分岐
- [ ] メニュー一覧ページ
  - [ ] food/drink/dessert セクション表示
- [ ] メニュー詳細ページ
  - [ ] 価格/カロリー/アレルギー分岐表示
  - [ ] 関連メニュー3件表示
- [ ] フッター
  - [ ] 住所/電話/SNS/プライバシーポリシー導線

## 7. 監査で見つかった主な前提リスク

- [ ] about-seats の ID 解決は get_hanacafe_master_page_id() に統一済み（STEP 6-1 解消）。
- [ ] CPT登録コードがテーマ内に無いため、プラグイン側停止時に menu 一式が機能停止。
- [ ] Node系はlint定義のみで、SCSSビルド手順は別管理の可能性があるためリリース手順書と同期確認が必要。
