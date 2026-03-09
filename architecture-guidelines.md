# 🏛️ HanaCAFE nappa69 アーキテクチャ設計・実装ガイドライン

本ドキュメントは、HanaCAFEプロジェクトにおける「ファイル構造」と「具体的な実装・リファクタリングルール」を定義する実務用ガイドです。
AIメンターおよび開発者は、コードを記述・修正する際、必ずこのガイドライン（6つの黄金律、共通デザイン要件、構造図）に従うこと。

---

## 🌟 実装・リファクタリング「6つの黄金律」

### ① 究極のモバイルファースト設計（プランA）
* **CSS設計**: デフォルト（メディアクエリ外）には必ず「スマホ用（SP）」のスタイルを記述する。
* **PC用の上書き**: `_mixins.scss` に定義した **引数なしの `@include m.mq { ... }`** （min-width: 768px）のみを使用して上書きする。引数（md, pc, sp等）は使用しない。

### ② マジックナンバーの完全排除（SSOT変数化）
* **カラー**: `rgb(0,0,0)` や `#FFFFFF` 等の直書きは厳禁。すべて `v.$c-black`, `v.$c-white` 等の変数を使用する。
* **UI共通値**: トランジション時間（`v.$t-duration`）や角丸（`v.$radius-m`）も `_variables.scss` で一元管理する。

### ③ FLOCSSとDRY原則の徹底（カプセル化）
* **ComponentとProjectの分離**: 2箇所以上で使い回す要素（ボタン、バッジ、見出し等）は `object/component/` へ隔離する。

### ④ パフォーマンス最適化（レンダリングブロック回避）
* **JSの読み込み**: `wp_enqueue_script` 等での配列引数（`'strategy' => 'defer'`）を使用し、レンダリングブロックを回避する。

### ⑤ セキュリティの徹底（エスケープ処理）
* **出力の無害化**: `esc_url()`, `esc_html()`, `esc_attr()` などを出力直前で必ず使用する。

### ⑥ 既存機能とコンテンツの保持（非破壊の原則）🚨最重要
* **機能の削除厳禁**: リファクタリング時、既存コードの機能（ループ、ホバー演出、条件分岐等）は絶対に削らない。
* **文言の変更厳禁**: HTML（PHP）に出力されるテキストや文言は、指示がない限り勝手に変更・省略しない。

---

## 🎨 共通デザイン要件定義（2026-03-09 策定）

### 1. 全体カラー＆セクション背景ルール
* **メインカラー (`$c-main`)**: `#2E4D07` (深緑)
* **アクセントカラー (`$c-accent`)**: `#F29159` (オレンジ)
* **基本テキスト色 (`$c-text`)**: `#57534E` (濃いグレー)
* **セクション交互配置**: 視認性を高めるため、背景色は「白」と「生成色」を交互に配置する。
  * About: 生成色 (`$c-base`)
  * Menu: 白 (`$c-white`)
  * Access: 生成色 (`$c-base`)
  * News: 白 (`$c-white`)

### 2. 境界線（Border）とプレースホルダー（仮背景）のルール
* **禁止事項**: 旧 `$c-border` 等のマジックナンバーグレーは使用禁止。
* **境界線（区切り線）**: 基本テキスト色の10%透過を使用。
  * `border: 1px solid rgba(v.$c-text, 0.1);`
* **画像プレースホルダー**: 基本テキスト色の5%透過を使用。
  * `background-color: rgba(v.$c-text, 0.05);`

### 3. セクション見出しの共通コンポーネント (`c-heading`)
サイト全体のセクション見出しは、以下の構造に完全統一する。
* **英語サブタイトル (`c-heading__sub`)**:
  * 色: `$c-main` / フォント: `$f-en` / サイズ: 14px / `letter-spacing: 0.1em;`
* **日本語メインタイトル (`c-heading__main`)**:
  * 色: `$c-main` / フォント: `$f-serif` / サイズ: VWクランプによる可変

### 4. トランジション（アニメーション）の統一ルール
* **ホバー時の画像拡大**:
  * `transform: scale(1.05);` / `transition: transform 0.6s ease-out;`
* **テキスト・色の変化**:
  * `transition: color 0.3s ease;` (または `opacity 0.3s ease;`)

---

## 📂 プロジェクト構造図

## 📂 プロジェクト構造図（ファイル連携マップ）

### 🐘 PHP・WordPressコア層
```text
hanacafe-theme/
├── functions.php       （WP設定、CSS/JSの遅延読み込み、ACF準備）
├── theme.json          （WPブロックエディタ設定）
│
├── header.php          （共通頭部：ロゴ、ナビ配列、ドロワー構造）
├── footer.php          （共通足元：フッターナビ、コピーライト）
│
├── index.php           （フォールバック用）
├── front-page.php      （TOPページ土台）
│   └── template-parts/home/
│       ├── hero.php    （全幅表示、乗算フィルタ画像）
│       ├── about.php   （ACF空席状況バッジ、ID付与済み）
│       ├── menu.php    （※未実装: お料理メニュー）
│       ├── access.php  （※未実装: アクセス・地図）
│       └── news.php    （※未実装: お知らせ）
│
└── page-concept.php    （固定ページ専用テンプレート）

```

### 🎨 SCSS層（FLOCSS モバイルファースト準拠）

```text
src/scss/
├── app.scss            （大元締め：全ファイルを @use で統合）
│
├── global/             （コンパイルされない裏方設定）
│   ├── _variables.scss （SSOT変数：色、Z-index、アニメ時間、角丸）
│   └── _mixins.scss    （引数なしの @mixin mq 定義）
│
├── foundation/         
│   └── _base.scss      （リセット、ベーススタイル）
│
├── layout/             （画面の大きな骨格）
│   ├── _header.scss    （SPデフォルト、PCナビ表示の切り替え）
│   └── _l-container.scss （.l-containerの余白、.u-alignfull制御）
│
└── object/             
    ├── component/      （使い回す小さな部品）
    │   ├── _button.scss  （カプセル型ボタン等）
    │   └── _c-badge.scss （空席・ペットバッジ等）
    │
    └── project/        （セクション専用スタイル）
        ├── _p-hero.scss  （Hero用：ブレンドモード等）
        ├── _p-about.scss （About用：Gridレイアウト等）
        └── _p-page.scss  （下層ページ用：ヘッダー分の余白確保）

