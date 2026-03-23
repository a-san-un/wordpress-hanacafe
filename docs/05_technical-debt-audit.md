# HanaCAFE nappa69 技術的負債 調査記録

調査日: 2026-03-22
最終更新: 2026-03-23
対象コミット: 89cacf6
修正完了コミット: c009548（STEP 8.5 全14件修正済み）
調査者: AIメンター（CTO役）+ VSCode Serena MCP

---

## 調査の目的

STEP 9（運用マニュアル整備）着手前に、Phase 2 STEP 7〜8 完了時点のコードベース全体を
「ルールなし・フラットな目線」で読み直し、技術的負債を棚卸しする。

---

## 調査フロー

| 投      | 内容                                                                          |
| ------- | ----------------------------------------------------------------------------- |
| 第1投   | VSCode Serena で全SCSSファイルを読み込み・気になる点を全件報告                |
| 第2投   | docs/01・02 と照合し「意図的 / 規約違反 / 判断不能」に分類                    |
| 第3投   | VSCode Serena で全PHP・JS・設定ファイルを読み込み・気になる点を全件報告       |
| 第4投   | docs/01・02 と照合し「意図的 / 規約違反 / 判断不能」に分類                    |
| CTO裁定 | 判断不能30件（SCSS）・31件（PHP/JS）をCTOが意図的・規約違反・先送りに振り分け |

---

## SCSS 調査結果

### ✅ 修正必須 → 全件完了（9件）

| No. | ファイル | 内容 | 対応コミット |
| --- | -------- | ---- | ------------ |
| 1   | app.scss | 作業ログコメント3件削除 | c009548 |
| 2   | _variables.scss / _base.scss | フォント変数逆転修正 | c009548 |
| 3   | _base.scss | body に $f-heading 適用修正 | c009548 |
| 4   | _base.scss | h1〜h4 に $f-body 適用修正 | c009548 |
| 5   | _c-heading.scss | 作業ログコメント削除 | c009548 |
| 6   | _l-header.scss | コメント内旧ファイル名修正 | c009548 |
| 7   | _p-news.scss | 境界線透過率を $c-border（0.1）に修正 | c009548 |
| 8   | _p-menu.scss | デッドプロパティ `right: 50%` 削除 | c009548 |
| 9   | _p-page.scss | `html body` 詳細度引き上げ削除 | c009548 |

### ✅ 意図的・仕様承認（14件）

| No. | ファイル | 内容 | 根拠 |
| --- | -------- | ---- | ---- |
| 10  | 全7ファイル | `opacity: 1;` の明示的記述が各セクションに散在 | docs/01⑦「表示保証: CSSで opacity:1 を担保する」 |
| 11  | _l-footer.scss / _c-card.scss / _p-menu.scss 他 | `opacity: 1;` の明示的記述 | 同上 |
| 12  | _c-card.scss | `-webkit-line-clamp` 実装に非標準プロパティ3点セット | クロスブラウザ対応として業界標準の実装 |
| 13  | _c-card.scss | `--c-card-ratio: 370 / 210` のピクセル比直書き | aspect-ratio 値として適切な記法 |
| 14  | _p-hero.scss | `::before` と `::after` が同一 `z-index: 1` を共有 | docs/01「疑似要素2層構造」の実装として自然 |
| 15  | _p-hero.scss | `transition-delay: 0.8s` / `1.2s` がハードコード | アニメーション演出設計値。変数化の義務なし |
| 16  | _p-page.scss | `&__subtitle { opacity: 0.7; }` — `v.$c-text-sub` 未使用でハードコード | docs/01③「opacity: 0.7 または適切なカラーコード」で両記法を許可 |
| 17  | _p-single-menu.scss | `&__desc` / `&__specs` / `.p-menu-related__subtitle` の `opacity: 0.7` 直書き（3件） | 同上 |

### 🔵 先送り負債（現状維持・クローズ済み）

#### STEP 10以降タスク（任意・将来対応）

| No. | ファイル | 内容 | 状態 |
| --- | -------- | ---- | ---- |
| 20  | _base.scss | `h5`・`h6` のスタイル未定義 | 使用箇所なし → **現状維持** |
| 22  | _l-header.scss | `height: 70px` / `90px` 等がハードコード | デザイン定数 → **現状維持** |
| 23  | _l-footer.scss | `&__info-item` 等のブロックが前半・後半で二重定義の可能性 | 実コード問題なし → **現状維持** |
| 26  | _c-heading.scss | `&__sub` と `&__main` が同じ `v.$c-main` で色の主従関係が不明瞭 | デザイン意図確認後に判断 → **現状維持** |
| 29  | _p-hero.scss | ~~`font-size: 48px` / `80px` がハードコード~~ | ✅ **vw-clamp化済み**（2026-03-23） |
| 30  | _p-access.scss | `@use "sass:color"` が1箇所のみのために使用 | `color.scale()` 代替まで → **現状維持** |
| 31  | _p-access.scss | `&__map-link` と `&__map-img` に `aspect-ratio` / `border-radius` が重複 | ✅ `__map-img` から2プロパティ削除済み（2026-03-23） |
| 33  | _p-single-menu.scss | `p-single-menu` ファイル内で `p-menu-related` を別ブロック定義 | コメントで意図明記済み → **現状維持** |
| 34  | _p-news.scss | `p-news` ファイル内に `p-archive` 定義が同居 | 同上 → **現状維持** |
| 36  | 横断共通 | `opacity: 0.7` 直書きと `v.$c-text-sub` 変数の混在 | docs/01③が両記法を許可 → **現状維持** |

#### 調査済み・クローズ（2026-03-23）

| No. | 内容 | 判断 |
| --- | ---- | ---- |
| 18  | `$c-sub` 未使用変数 | ✅ 削除済み |
| 19  | z-index 管理分散 | ✅ 一元管理済み |
| 21  | `button` リセット重複 | ✅ 削除済み |
| 24  | `will-change: transform` 一律適用 | ✅ 調査済み・動作問題なしでクローズ |
| 25  | `__badge` 2ファイル分散 | 🟢 役割分離として正しい設計。クローズ |
| 27  | `transition` 明示化 | ✅ 対応済み |
| 28  | `_p-news.scss` `__header` 無効プロパティ | ✅ 削除済み |
| 32  | ドロワー is-active 残留 | ✅ JS修正済み |
| 35  | gap + margin-top 二重設定 | 🟢 意図的な設計。クローズ |
| 37  | `transition` 記述混在 | ✅ 統一済み |

---

## PHP / JS / 設定ファイル 調査結果

### ✅ 修正必須 → 全件完了（5件）

| No. | ファイル | 内容 | 対応コミット |
| --- | -------- | ---- | ------------ |
| 38  | index.php | 残骸コメント削除 | c009548 |
| 39  | single-menu.php | `[fix 1-4]` コメント削除 | c009548 |
| 40  | template-parts/home/hero.php | フォールバック画像を `coming-soon.jpg` に修正 | c009548 |
| 41  | eslint.config.js | `globals.jquery` 削除 | c009548 |
| 42  | theme.json | スラッグ名・styles 適用を同期修正 | bf596f7 |

### ✅ 意図的・仕様承認（10件）

| No. | ファイル | 内容 | 根拠 |
| --- | -------- | ---- | ---- |
| 43  | header.php | `<script>` タグが `<html>` と `<head>` の間に配置 | docs/01「`<html>` タグに `js-enabled` を付与する」ための必須実装 |
| 44  | page-concept.php | PHPブロック内コメントが残存 | docs/02「PHP/HTMLの隠蔽コメント」として明示的に推奨 |
| 45  | functions.php | `get_field()` + エルビス演算子でフォールバック設定 | docs/02 §4②「?:（エルビス演算子）によるフォールバックを設定すること」 |
| 46  | functions.php | 画像取得が `menu_sub_img → アイキャッチ → デフォルト` の分岐 | docs/01⑦「フォールバック連鎖」の実装 |
| 47  | template-parts/home/hero.php | `get_field("pic", ...)` による ACF 必須依存 | docs/01「画像ソース: ACF pic フィールドで管理」で義務付け |
| 48  | template-parts/home/menu.php | `setup_postdata()` + `wp_reset_postdata()` の手動呼び出し | WP標準のサブループ実装。docs/02 §3②と整合 |
| 49  | theme.json | フォントファミリーが2系統のみ定義 | docs/01⑧「見出し用（Noto Sans JP）+ 本文用（Noto Serif JP）」の2系統設計 |
| 50  | main.js | ~~コメント「jQuery -> Vanilla JS 全面書き換え完了」が残存~~ | ✅ 削除済み（2026-03-23） |
| 65  | template-parts/home/about.php | `nl2br(esc_html(...))` の順序 | 🟢 正しい順序と確認済み（esc_html → nl2br）。クローズ |
| 74  | eslint.config.js | `sourceType: "script"` | 🟢 `import/export` 未使用・DOMContentLoaded完結型のため `"script"` が正しい。クローズ |

### 🔵 先送り負債（現状維持・クローズ済み）

#### 現状維持（動作問題なし）

| No. | ファイル | 内容 | 状態 |
| --- | -------- | ---- | ---- |
| 51  | functions.php | Google Fonts preconnect 複数フィルター実装 | **現状維持** |
| 52  | functions.php | `wp_enqueue_style` を個別に複数登録 | パフォーマンス最適化候補 → **現状維持** |
| 54  | functions.php | 三項演算子の入れ子が深い | **現状維持** |
| 55  | functions.php | `get_field()` にキャッシングがない | 体感問題なし → **現状維持** |
| 57  | header.php | `wp_nav_menu()` の `depth` が 1 固定 | 2階層ナビ不要 → **現状維持** |
| 58  | footer.php | `esc_url(home_url("/"))` を複数回呼び出し | 動作影響なし → **現状維持** |
| 59  | footer.php | 電話番号整形で `str_replace` を使用 | フォーマット固定 → **現状維持** |
| 60  | archive-menu.php | `meta_query` で `relation: OR` と `recommend_clause` を混在 | 動作確認済み → **現状維持** |
| 61  | single-menu.php | `$menu` と `$terms` を別々に取得 | 意図的設計の可能性 → **現状維持** |
| 62  | single-post.php | `get_the_date("c")` を datetime 属性に使用 | ISO 8601 標準実装 → **現状維持** |
| 63  | template-parts/home/menu.php | PHP 7.1+ のリスト分割代入を使用 | WP 6.9+ 環境で問題なし → **現状維持** |
| 64  | template-parts/home/news.php | `wp_reset_postdata()` が else 分岐外に配置 | 常時実行で安全側 → **現状維持** |
| 66  | template-parts/home/access.php | `wp_kses_post()` の許可タグ範囲がコード上から見えない | 動作問題なし → **現状維持** |
| 67  | template-parts/home/access.php | 同じコメント「URLがない場合」が複数箇所に重複 | **優先度低** |
| 68  | template-parts/home/access.php | 条件分岐パターンが繰り返されている | リファクタリング候補 → **現状維持** |

#### 調査済み・クローズ（2026-03-23）

| No. | 内容 | 判断 |
| --- | ---- | ---- |
| 53  | `filemtime()` に存在確認がない | ✅ `file_exists()` ガード追加済み |
| 56  | デフォルト画像スラッグの管理方法 | 🟢 ラッパー関数経由で実装確認済み。クローズ |
| 69  | scroll イベント内 rAF 多重実行 | ✅ 修正済み |
| 70  | フォーカストラップの visibility/opacity 未考慮 | ✅ 改善済み |
| 71  | ダークモード対応なし | 🟢 設計スコープ外。クローズ |
| 72  | `package.json` `"main": "index.js"` 対応ファイルなし | 🟢 ビルドへの影響なし確認済み。クローズ |
| 73  | lint スクリプトが JS のみ | 🟢 PHP は Intelephense 担当として分担成立。クローズ |
| 75  | `wp_kses_post()` と `esc_html()` の混在 | 🟢 用途が異なるため混在は正当。クローズ |
| 76  | `get_hanacafe_master_page_id()` 呼び出しが集中 | 🟢 動作確認済み。クローズ |
| 77  | 「jQuery -> Vanilla JS」完了記録コメント残存 | ✅ 削除済み |

---

## 合計サマリー（2026-03-23 最終）

| 対象            | 修正必須 → 完了 | 意図的・承認 | 先送り現状維持 | クローズ |
| --------------- | --------------- | ------------ | -------------- | -------- |
| SCSS            | 9件 ✅          | 14件         | 10件           | 10件     |
| PHP / JS / 設定 | 5件 ✅          | 10件         | 15件           | 10件     |
| **合計**        | **14件**        | **24件**     | **25件**       | **20件** |

---

## 残存タスク（本番公開前）

| 優先度 | No. | 内容 | タイミング |
| ------ | --- | ---- | ---------- |
| 🔴     | —   | 本番デプロイチェックリスト（docs/10）実施 | 公開前必須 |
| 🟡     | 29  | ~~hero font-size vw-clamp化~~ | ✅ 完了 |
| 🟡     | 53  | ~~filemtime file_exists ガード~~ | ✅ 完了 |
| 🟢     | 31  | ~~`_p-access.scss` セレクター統合~~ | ✅ 完了 |
