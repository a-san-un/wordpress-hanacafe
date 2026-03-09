# 🏛️ HanaCAFE nappa69 アーキテクチャ設計・実装ガイドライン

本ドキュメントは、HanaCAFEプロジェクトにおける「ファイル構造」と「具体的な実装・リファクタリングルール」を定義する実務用ガイドです。
AIメンターおよび開発者は、コードを記述・修正する際、必ずこのガイドライン（5つの黄金律と構造図）に従うこと。

---

## 🌟 実装・リファクタリング「5つの黄金律」

### ① 究極のモバイルファースト設計（プランA）
* **CSS設計**: デフォルト（メディアクエリ外）には必ず「スマホ用（SP）」のスタイルを記述する。
* **PC用の上書き**: `_mixins.scss` に定義した **引数なしの `@include m.mq { ... }`** （min-width: 768px）のみを使用して上書きする。引数（md, pc, sp等）は使用しない。

### ② マジックナンバーの完全排除（SSOT変数化）
* **カラー**: `rgb(0,0,0)` や `#FFFFFF` 等の直書きは厳禁。すべて `v.$c-black`, `v.$c-white` 等の変数を使用する。
* **UI共通値**: トランジション時間（`v.$t-duration`）や角丸（`v.$radius-m`）も `_variables.scss` で一元管理する。

### ③ FLOCSSとDRY原則の徹底（カプセル化）
* **ComponentとProjectの分離**: 2箇所以上で使い回す要素（ボタン、バッジ等）は `object/component/` へ隔離する。
* **`!important` の禁止**: スタイルの上書きは適切な詳細度（クラスのネスト等）で解決し、`!important` は使用しない。
* **PHPのDRY**: ナビゲーションやカードのリスト等、同じHTML構造の繰り返しは配列と `foreach` を使ってループ化する。

### ④ アクセシビリティ（A11Y）とモダンJSの必須化
* **キーボード操作**: インタラクティブ要素（ボタン・リンク）には必ず `:focus-visible` を設定する。
* **WAI-ARIA**: ドロワーメニュー等の開閉時、JSを用いて `aria-expanded` と `aria-hidden` の状態（true/false）を視覚的な動きと完全に連動させる。

### ⑤ WordPress 最新標準への準拠
* **アセット読み込み**: `functions.php` の `wp_enqueue_script` では、WordPress 6.9+ の配列引数（`'strategy' => 'defer'`）を使用し、レンダリングブロックを回避する。
* **エスケープ処理**: `esc_url()`, `esc_html()`, `esc_attr()` を出力直前で必ず使用する。

---

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

