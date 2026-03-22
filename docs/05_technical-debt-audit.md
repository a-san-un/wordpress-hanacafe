# HanaCAFE nappa69 技術的負債 調査記録

調査日: 2026-03-22
対象コミット: 89cacf6
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

### ❌ 修正必須（9件）

| No. | ファイル                       | 内容                                                                                     | 根拠                                                   |
| --- | ------------------------------ | ---------------------------------------------------------------------------------------- | ------------------------------------------------------ |
| 1   | app.scss                       | `// ★修正:` `// ★新規追加:` 等の作業ログコメント3件残存                                  | docs/02「物理削除の原則」                              |
| 2   | \_variables.scss / \_base.scss | `$f-heading`（Noto Sans JP）が body に、`$f-body`（Noto Serif JP）が h1〜h4 に逆転適用   | docs/02 §6②「見出し用: $f-heading / 本文用: $f-body」  |
| 3   | \_base.scss                    | `body { font-family: v.$f-heading; }` — 本文に見出し用変数を適用                         | docs/02 §6②違反（No.2と対）                            |
| 4   | \_base.scss                    | `h1〜h4 { font-family: v.$f-body; }` — 見出しに本文用変数を適用                          | docs/02 §6②違反（No.2と対）                            |
| 5   | \_c-heading.scss               | `// ★オレンジから深緑へ修正` 作業ログコメント残存                                        | docs/02「物理削除の原則」                              |
| 6   | \_l-header.scss                | コメント内のファイル名が旧名 `(_header.scss)` のまま                                     | docs/02「物理削除の原則」の精神に違反                  |
| 7   | \_p-news.scss                  | ページネーション境界線が `rgba(v.$c-text, 0.2)`（20%） — `$c-border`（0.1）と不一致      | docs/01「境界線には透過率 0.1 を適用する」             |
| 8   | \_p-menu.scss                  | `&::before` に `right: 50%` と `width: 100vw` が共存（`right` が無効なデッドプロパティ） | docs/02「物理削除の原則」                              |
| 9   | \_p-page.scss                  | `html body .p-page { }` — 親タグ名による詳細度の強制引き上げ                             | docs/01②「親要素のタグ名に依存したスタイリングを禁止」 |

### ✅ 意図的・仕様承認（14件）

| No. | ファイル                                           | 内容                                                                                 | 根拠                                                                       |
| --- | -------------------------------------------------- | ------------------------------------------------------------------------------------ | -------------------------------------------------------------------------- |
| 10  | 全7ファイル                                        | `opacity: 1;` の明示的記述が各セクションに散在                                       | docs/01⑦「表示保証: CSSで opacity:1 を担保する」                           |
| 11  | \_l-footer.scss / \_c-card.scss / \_p-menu.scss 他 | `opacity: 1;` の明示的記述                                                           | 同上                                                                       |
| 12  | \_c-card.scss                                      | `-webkit-line-clamp` 実装に非標準プロパティ3点セット                                 | クロスブラウザ対応として業界標準の実装                                     |
| 13  | \_c-card.scss                                      | `--c-card-ratio: 370 / 210` のピクセル比直書き                                       | aspect-ratio 値として適切な記法                                            |
| 14  | \_p-hero.scss                                      | `::before` と `::after` が同一 `z-index: 1` を共有                                   | docs/01「疑似要素2層構造」の実装として自然。重ね順は mix-blend-mode で制御 |
| 15  | \_p-hero.scss                                      | `transition-delay: 0.8s` / `1.2s` がハードコード                                     | アニメーション演出設計値。変数化の義務なし                                 |
| 16  | \_p-page.scss                                      | `&__subtitle { opacity: 0.7; }` — `v.$c-text-sub` 未使用でハードコード               | docs/01③「opacity: 0.7（または適切なカラーコード）」で両記法を許可         |
| 17  | \_p-single-menu.scss                               | `&__desc` / `&__specs` / `.p-menu-related__subtitle` の `opacity: 0.7` 直書き（3件） | 同上                                                                       |

### 🔵 技術的負債・先送り（20件）

| No. | ファイル                                           | 内容                                                                                                    | 再調査タイミング                                                   |
| --- | -------------------------------------------------- | ------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------ |
| 18  | \_variables.scss                                   | `$c-sub: #eb4e34` が全SCSSで未使用（theme.json `sub` カラーとの対応を要確認）                           | theme.json 修正時に合わせて判断                                    |
| 19  | \_variables.scss / \_p-hero.scss / \_p-drawer.scss | z-index 管理が分散（`$z-header` のみ変数化・`$z-filter`/`$z-content`/`$z-drawer` がローカル or 算術式） | STEP 10以降                                                        |
| 20  | \_base.scss                                        | `h5`・`h6` のスタイル未定義（h4 で止まっている）                                                        | h5/h6 の使用箇所を確認してから判断                                 |
| 21  | \_base.scss / \_l-header.scss                      | `button` リセット3プロパティ（background/border/cursor）が2か所で重複定義                               | STEP 10以降                                                        |
| 22  | \_l-header.scss                                    | `height: 70px` / `90px` / `font-size: 20px` / `26px` がハードコード                                     | デザイン定数として変数化候補。STEP 10以降                          |
| 23  | \_l-footer.scss                                    | `&__info-item` 等のブロックが前半・後半で二重定義の可能性                                               | 実コード確認後に判断                                               |
| 24  | \_c-card.scss                                      | `will-change: transform` がアニメーションしない `c-card--news` にも一律適用                             | パフォーマンス最適化。STEP 10以降                                  |
| 25  | \_c-card.scss                                      | `&__badge` の位置指定が \_c-card.scss と \_c-badge.scss の2か所に分散                                   | 動作に問題なければ現状維持                                         |
| 26  | \_c-heading.scss                                   | `&__sub` と `&__main` が同じ `v.$c-main` で色の主従関係が不明瞭                                         | デザイン意図確認後に判断                                           |
| 27  | \_c-button.scss / \_p-access.scss                  | `transition` のプロパティ名指定なし（実質 `all` 相当）が2ファイルで混在                                 | STEP 10以降                                                        |
| 28  | \_p-news.scss                                      | `&__header { align-items: center; }` に `display: flex/grid` の定義がなく無効の可能性                   | 実ブラウザで確認後に判断                                           |
| 29  | \_p-hero.scss                                      | `font-size: 48px` / `80px` がハードコード（同ファイル内の他寸法は vw-clamp 使用）                       | clamp 化候補。STEP 10以降                                          |
| 30  | \_p-access.scss                                    | `@use "sass:color"` が `color.scale()` の1箇所のみのために使用                                          | `color.scale()` の代替実装と合わせて判断                           |
| 31  | \_p-access.scss                                    | `&__map-link` と `&__map-img` に `aspect-ratio` と `border-radius` が重複定義                           | セレクター統合で解決可能。優先度低                                 |
| 32  | \_p-drawer.scss                                    | is-active 残留時にモバイル幅へ戻るとドロワーが開いたまま表示される可能性                                | JS側と合わせて検討。STEP 10以降                                    |
| 33  | \_p-single-menu.scss                               | `p-single-menu` ファイル内で `p-menu-related` を別ブロック定義（責務の境界）                            | STEP 10以降                                                        |
| 34  | \_p-news.scss                                      | `p-news` ファイル内に `p-archive` 定義が同居                                                            | STEP 10以降                                                        |
| 35  | \_p-hero.scss                                      | gap と margin-top の併用でタイトル間隔が二重になっている可能性                                          | 実ブラウザで確認後に判断                                           |
| 36  | 横断共通                                           | `opacity: 0.7` 直書きと `v.$c-text-sub` 変数（文字色用）の混在                                          | docs/01③が両記法を許可しているが統一基準をdocsに追記することで解決 |
| 37  | 横断共通                                           | `transition: all` 相当の記述と `transition: color v.$t-duration` 等の明示記述が混在                     | STEP 10以降                                                        |

---

## PHP / JS / 設定ファイル 調査結果

### ❌ 修正必須（5件）

| No. | ファイル                     | 内容                                                                                                                                                                  | 根拠                                                               |
| --- | ---------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------ |
| 38  | index.php                    | 実体のない古いコメント「style属性を消し」が残存                                                                                                                       | docs/02「物理削除の原則」                                          |
| 39  | single-menu.php              | `[fix 1-4]` コメントが残存                                                                                                                                            | docs/02「物理削除の原則」                                          |
| 40  | template-parts/home/hero.php | フォールバック画像が `coming-soon.jpg` ではなく `hero.jpg`                                                                                                            | docs/01「未設定時はテーマ内 coming-soon.jpg にフォールバック」     |
| 41  | eslint.config.js             | `globals.jquery` が残存（jQuery撤去済み）                                                                                                                             | docs/02「物理削除の原則」                                          |
| 42  | theme.json                   | `slug: "sans"` / `slug: "serif"` のスラッグ名が `$f-heading`/`$f-body` の用途と非同期。`styles.typography` が `sans` を body 全体に適用しており本文フォント設計と矛盾 | docs/02 §6①「\_variables.scss と theme.json は常に同期させること」 |

### ✅ 意図的・仕様承認（8件）

| No. | ファイル                     | 内容                                                         | 根拠                                                                     |
| --- | ---------------------------- | ------------------------------------------------------------ | ------------------------------------------------------------------------ |
| 43  | header.php                   | `<script>` タグが `<html>` と `<head>` の間に配置            | docs/01「`<html>` タグに `js-enabled` を付与する」ための必須実装         |
| 44  | page-concept.php             | PHPブロック内コメントが残存                                  | docs/02「PHP/HTMLの隠蔽コメント」として明示的に推奨                      |
| 45  | functions.php                | `get_field()` + エルビス演算子でフォールバック設定           | docs/02 §4②「?:（エルビス演算子）によるフォールバックを設定すること」    |
| 46  | functions.php                | 画像取得が `menu_sub_img → アイキャッチ → デフォルト` の分岐 | docs/01⑦「フォールバック連鎖」の実装                                     |
| 47  | template-parts/home/hero.php | `get_field("pic", ...)` による ACF 必須依存                  | docs/01「画像ソース: ACF pic フィールドで管理」で義務付け                |
| 48  | template-parts/home/menu.php | `setup_postdata()` + `wp_reset_postdata()` の手動呼び出し    | WP標準のサブループ実装。docs/02 §3②と整合                                |
| 49  | theme.json                   | フォントファミリーが2系統のみ定義                            | docs/01⑧「見出し用（Noto Sans JP）+ 本文用（Noto Serif JP）」の2系統設計 |
| 50  | main.js                      | コメント「jQuery -> Vanilla JS 全面書き換え完了」が残存      | 完了記録として許容。ただし将来的に物理削除候補                           |

### 🔵 技術的負債・先送り（27件）

| No. | ファイル                       | 内容                                                                                       | 再調査タイミング                             |
| --- | ------------------------------ | ------------------------------------------------------------------------------------------ | -------------------------------------------- |
| 51  | functions.php                  | Google Fonts の preconnect を複数フィルター呼び出しで実装                                  | 動作問題なければ現状維持                     |
| 52  | functions.php                  | `wp_enqueue_style` を個別に複数登録                                                        | パフォーマンス最適化候補。STEP 10以降        |
| 53  | functions.php                  | `filemtime()` に存在確認がない                                                             | 防御的実装として記録。本番環境での影響は軽微 |
| 54  | functions.php                  | 三項演算子の入れ子が深い（可読性）                                                         | STEP 10以降                                  |
| 55  | functions.php                  | `get_field()` にキャッシングがない                                                         | パフォーマンス最適化。体感問題なければ先送り |
| 56  | functions.php                  | デフォルト画像スラッグの管理方法（関数化状況を確認）                                       | ラッパー関数経由なら仕様。実装確認後に判断   |
| 57  | header.php                     | `wp_nav_menu()` の `depth` が 1 固定                                                       | 2階層ナビ不要なら仕様。現状維持              |
| 58  | footer.php                     | `esc_url(home_url("/"))` を複数回呼び出し                                                  | 変数化で整理可能。動作に影響なし             |
| 59  | footer.php                     | 電話番号整形で `str_replace("-", "", ...)` を使用                                          | フォーマット固定なら許容範囲                 |
| 60  | archive-menu.php               | `meta_query` で `relation: OR` と `recommend_clause` を混在                                | 動作確認済みなら仕様                         |
| 61  | single-menu.php                | `$menu` と `$terms` を別々に取得（冗長の可能性）                                           | 意図的な設計の可能性。確認後に判断           |
| 62  | single-post.php                | `get_the_date("c")` を datetime 属性に使用                                                 | `<time datetime="">` 用のISO 8601。標準実装  |
| 63  | template-parts/home/menu.php   | PHP 7.1+ のリスト分割代入を使用                                                            | WP 6.9+ 環境で問題なし                       |
| 64  | template-parts/home/news.php   | `wp_reset_postdata()` が else 分岐外に配置                                                 | 常時実行で安全側。むしろ正しい実装の可能性   |
| 65  | template-parts/home/about.php  | `nl2br(esc_html(...))` の順序（改行→エスケープ）                                           | 改行後にエスケープが正しい順序。要実挙動確認 |
| 66  | template-parts/home/access.php | `wp_kses_post()` の許可タグ範囲がコード上から見えない                                      | 動作問題なければ現状維持                     |
| 67  | template-parts/home/access.php | 同じコメント「URLがない場合」が複数箇所に重複                                              | 優先度低                                     |
| 68  | template-parts/home/access.php | 条件分岐パターンが繰り返されている                                                         | リファクタリング候補。STEP 10以降            |
| 69  | main.js                        | scroll イベント内の `requestAnimationFrame` 多重実行懸念                                   | パフォーマンス最適化。STEP 10以降            |
| 70  | main.js                        | フォーカストラップで `display !== "none"` のみチェック（`visibility`・`opacity` 未考慮）   | アクセシビリティ改善候補。STEP 10以降        |
| 71  | theme.json                     | ダークモード対応なし                                                                       | 設計スコープ外                               |
| 72  | package.json                   | `"main": "index.js"` に対応ファイルが存在しない                                            | ビルドへの影響確認が必要。優先度低           |
| 73  | package.json                   | lint スクリプトが JavaScript のみ対象（PHP は Intelephense が担当）                        | 分担として成立。現状維持                     |
| 74  | eslint.config.js               | `sourceType: "script"` （STEP 7-6 で検討済みの既知課題）                                   | 現状維持                                     |
| 75  | 横断共通                       | `wp_kses_post()` と `esc_html()` の使い分けが混在                                          | 動作問題なければ現状維持                     |
| 76  | 横断共通                       | `get_hanacafe_master_page_id()` の呼び出しが functions.php に集中（hero.php でも呼び出し） | 動作確認済みなら仕様                         |
| 77  | 横断共通                       | コメント「jQuery -> Vanilla JS」系の完了記録が残存                                         | 将来的に物理削除候補                         |

---

## 合計サマリー

| 対象            | 修正必須 | 意図的・承認 | 先送り   |
| --------------- | -------- | ------------ | -------- |
| SCSS            | 9件      | 14件         | 20件     |
| PHP / JS / 設定 | 5件      | 8件          | 27件     |
| **合計**        | **14件** | **22件**     | **47件** |

---

## 修正必須14件の実施順（優先度順）

### グループA：フォント逆転（SCSS + theme.json 3ファイルセット）

1. `_variables.scss` — 変数名の用途コメントを正す
2. `_base.scss` — `$f-heading` / `$f-body` の適用先を入れ替える
3. `theme.json` — `slug: "sans"` / `slug: "serif"` の名称・styles 適用を修正

### グループB：コメント残骸（4ファイル）

4. `app.scss` — 作業ログコメント3件を物理削除
5. `_c-heading.scss` — 作業ログコメントを物理削除
6. `_l-header.scss` — コメント内旧ファイル名を修正
7. `index.php` — 残骸コメントを物理削除
8. `single-menu.php` — `[fix 1-4]` コメントを物理削除
9. `eslint.config.js` — `globals.jquery` を物理削除

### グループC：ロジック・仕様修正（2ファイル）

10. `template-parts/home/hero.php` — フォールバック画像を `coming-soon.jpg` に修正
11. `_p-news.scss` — 境界線透過率を `$c-border`（0.1）に修正

### グループD：デッドコード削除（2ファイル）

12. `_p-menu.scss` — デッドプロパティ `right: 50%` を削除
13. `_p-page.scss` — `html body` による詳細度引き上げを削除

---

## 先送り負債の再調査推奨タイミング

| タイミング        | 対象                                                      |
| ----------------- | --------------------------------------------------------- |
| theme.json 修正時 | `$c-sub` と theme.json `sub` カラーの対応確認             |
| STEP 10 着手前    | z-index 一元管理・transition 記述統一・will-change 最適化 |
| 本番公開前        | `nl2br(esc_html(...))` の挙動確認・フォーカストラップ改善 |
| 機能拡張時        | ドロワー is-active 残留問題・`wp_nav_menu()` depth 拡張   |
