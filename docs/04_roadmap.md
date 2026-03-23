# HanaCAFE nappa69 リファクタリングロードマップ Phase 2

最終更新: 2026-03-23

## 目的

- コード品質・フォーマットの統一（自動化）
- デザインコンポーネントの共通化（SCSS削減）
- 運用マニュアルの整備（他者引き継ぎレベル）

---

## フォーマットルール（確定）

| 対象             | インデント | 括弧スタイル | ツール       |
| ---------------- | ---------- | ------------ | ------------ |
| PHP              | スペース2  | K&R（1TBS）  | Intelephense |
| JS               | スペース2  | 1TBS         | Prettier     |
| SCSS             | スペース2  | 1TBS         | Prettier     |
| HTML（PHP内）    | タブ       | —            | Intelephense |
| JSON / YAML / MD | スペース2  | —            | Prettier     |

---

## 🔵 STEP 7 — フォーマット統一・開発環境整備

目的: 全ファイルのフォーマットを確定ルールに統一し、
保存時に自動整形される状態を作る。

| #   | 優先度 | 対象                    | 内容                                                                     | 状態 |
| --- | ------ | ----------------------- | ------------------------------------------------------------------------ | ---- |
| 7-1 | 🔴 高  | `.prettierrc`           | `useTabs: false` / `tabWidth: 2` に変更・overrides削除                   | ✅   |
| 7-2 | 🔴 高  | `.vscode/settings.json` | `formatOnSave: true` 有効化・各言語のformatter明示・bracesをallmanに変更 | ✅   |
| 7-3 | 🔴 高  | JS / SCSS / JSON / MD   | `npx prettier --write` で一括フォーマット                                | ✅   |
| 7-4 | 🔴 高  | 全PHPファイル（14本）   | VSCode で1ファイルずつ `Shift+Alt+F` でフォーマット                      | ✅   |
| 7-5 | 🟡 中  | `.editorconfig`         | インデント・改行コード・文字コードを明示（新規作成）                     | ✅   |
| 7-6 | 🟢 低  | `eslint.config.js`      | `sourceType: "module"` への移行検討・設定見直し                          | ✅   |

### STEP 7 完了条件

- 保存時に自動フォーマットが走る
- JS / SCSS がスペース2・1TBS に統一されている
- PHP がタブ・Allman+1TBS に統一されている
- 専用コミット1本にまとめられている

### STEP 7 コミット履歴

| コミット | 内容                                                                                  |
| -------- | ------------------------------------------------------------------------------------- |
| c81cf97  | style: インデントをタブ→スペース2に統一・.editorconfig削除                            |
| —        | STEP 7-1〜7-6 全完了（フォーマット設定確認・Prettier dry-run 全ファイル準拠済み確認） |

---

## 🟤 STEP 8 — コンポーネント共通化・ファイル構成整理

始める前に他に改善案がないか全体を見渡してみる。
目的: 似たパーツを `c-card` として統合し SCSS を削減する。
フォント・カラー変数を整理し、デザインの一貫性を高める。

### 設計方針

```
c-card（共通ベース）
├── 画像エリア
├── バッジ（オプション）
├── 情報エリア（タイトル・サブタイトル・テキスト）
└── フッターエリア（価格・日付など）

modifier で差分のみ上書き
c-card--menu   → 価格表示あり
c-card--news   → 日付表示あり
c-card--seat   → ステータスバッジあり
```

### フォント設計

| 用途             | 英数字     | 日本語        |
| ---------------- | ---------- | ------------- |
| 見出し（h1〜h4） | Montserrat | Noto Sans JP  |
| 本文・説明文     | Montserrat | Noto Serif JP |

| #    | 優先度 | 対象                            | 内容                                                                  | 状態 |
| ---- | ------ | ------------------------------- | --------------------------------------------------------------------- | ---- |
| 8-1  | 🔴 高  | `_variables.scss`               | フォント変数を見出し用・本文用に整理                                  | ✅   |
| 8-2  | 🔴 高  | `_c-card.scss`（新規）          | 共通カードコンポーネント作成                                          | ✅   |
| 8-3  | 🔴 高  | `loop-menu.php`                 | `template-parts/menu/` に移動・呼び出し元を更新                       | ✅   |
| 8-4  | 🟡 中  | `_p-menu.scss`                  | `c-card--menu` modifier に移行・旧ルール削除                          | ✅   |
| 8-5  | 🟡 中  | `_p-news.scss`                  | `c-card--news` modifier に移行・旧ルール削除                          | ✅   |
| 8-6  | 🟡 中  | `_p-about.scss`                 | `c-card--seat` modifier に移行・旧ルール削除                          | ✅   |
| 8-7  | 🟡 中  | `_c-heading.scss`               | 見出しフォント変数を適用・レベル別スタイル整理                        | ✅   |
| 8-8  | 🟢 低  | `taxonomy-menu_category.php`    | 中身確認・不要なら削除                                                | ✅（削除せず最小修正で存続） |
| 8-9  | 🟢 低  | `docs/`                         | 連番整理（07→05・08→06 に改番）                                       | ✅   |
| 8-10 | 🔴 高  | `archive-menu.php`              | 不正文字（`ï`）バグ修正                                               | ✅   |
| 8-11 | 🔴 高  | `_header.scss`                  | `.p-drawer` スタイルを `_p-drawer.scss` として分離                    | ✅   |
| 8-12 | 🟡 中  | `_header.scss` / `_footer.scss` | `_l-header.scss` / `_l-footer.scss` にリネーム・`app.scss` import更新 | ✅   |
| 8-13 | 🟡 中  | 各SCSSファイル                  | 未定義クラス4件追加（`.p-archive__pagination` 等）                    | ✅   |

### STEP 8 完了条件

- カード系UIが `c-card` + modifier で統一されている
- フォントが見出し・本文で正しく切り替わっている
- `loop-menu.php` が `template-parts/menu/` に移動している
- SCSSファイル総数が現状（15本）より削減されている
- `archive-menu.php` の不正文字が除去されている
- `.p-drawer` が独立ファイルに分離されている
- layoutファイルに `l-` プレフィックスが統一されている
- PHPテンプレートで使用されている全CSSクラスにスタイルが定義されている

### STEP 8 コミット履歴

| コミット | 内容 |
|---|---|
| 02f3fe2 | fix: 未定義クラス4件追加（8-10〜8-13） |
| e7eb05e | refactor: フォント変数を用途ベース（$f-heading/$f-body）に移行（8-1） |
| 211c5b9 | feat: _c-card.scss を新規作成（共通カードコンポーネント）（8-2） |
| 94b03ce | refactor: loop-menu.php を template-parts/menu/ に移動（8-3） |
| 3189fc3 | refactor: メニューカードを c-card--menu に移行（8-4） |
| 28aaf52 | refactor: ニュースカードを c-card--news に移行（8-5） |
| bc91171 | refactor: 席カードを c-card--seat に移行（8-6） |
| 3006bee | feat: h1〜h4 の font-size 階層を明示（8-7） |
| 6563d60 | fix: taxonomy-menu_category.php の空表示に p-archive__empty を適用（8-8） |
| 8ab316d | docs: ロードマップを 04_roadmap.md にリネーム・.DS_Store 削除（8-9） |
| 89a3746 | docs: 01_architecture-and-design-rulesにフォント使い分けルールを追記しv8.1へ更新 |

---

## 🔴 STEP 8.5 — 技術的負債 修正（STEP 9 着手前クリーニング）

目的: STEP 7〜8 完了時点のコードベースを全ファイルフラット調査し、
規約違反・残骸コメント・仕様ズレを修正する。
詳細調査記録: [docs/05_technical-debt-audit.md](./05_technical-debt-audit.md)

| #      | 優先度 | 対象 | 内容 | 状態 |
| ------ | ------ | ---- | ---- | ---- |
| 8.5-A1 | 🔴 高 | `_variables.scss` / `_base.scss` / `theme.json` | フォント変数逆転修正（`$f-heading`/`$f-body` + theme.json スラッグ同期） | ✅ |
| 8.5-B1 | 🟡 中 | `app.scss` | 作業ログコメント3件を物理削除 | ✅ |
| 8.5-B2 | 🟡 中 | `_c-heading.scss` | 作業ログコメントを物理削除 | ✅ |
| 8.5-B3 | 🟡 中 | `_l-header.scss` | コメント内旧ファイル名を修正 | ✅ |
| 8.5-B4 | 🟡 中 | `index.php` | 残骸コメントを物理削除 | ✅ |
| 8.5-B5 | 🟡 中 | `single-menu.php` | `[fix 1-4]` コメントを物理削除 | ✅ |
| 8.5-B6 | 🟡 中 | `eslint.config.js` | `globals.jquery` を物理削除 | ✅ |
| 8.5-C1 | 🔴 高 | `template-parts/home/hero.php` | フォールバック画像を `coming-soon.jpg` に修正 | ✅ |
| 8.5-C2 | 🔴 高 | `_p-news.scss` | 境界線透過率を `$c-border`（0.1）に修正 | ✅ |
| 8.5-D1 | 🟡 中 | `_p-menu.scss` | デッドプロパティ `right: 50%` を物理削除 | ✅ |
| 8.5-D2 | 🟡 中 | `_p-page.scss` | `html body` による詳細度引き上げを削除 | ✅ |

### STEP 8.5 完了条件

- フォント変数と theme.json のスラッグが同期している
- 残骸コメント・デッドコードが全件物理削除されている
- hero.php のフォールバック画像が `coming-soon.jpg` になっている
- 境界線透過率が `$c-border` 変数と一致している

### STEP 8.5 コミット履歴

| コミット | 内容 |
| -------- | ---- |
| c009548  | fix: STEP 8.5 技術的負債クリーニング（11件） |
| d5dc20a  | docs: 技術的負債調査記録を追加 |

---

## 🟠 STEP 9 — 運用マニュアル整備

目的: WordPressを触ったことがある人が
初日から一人で更新できる状態にする。

| #   | 対象 | 内容 | 状態 |
| --- | --- | --- | --- |
| 9-1 | docs/09_cms-operation-manual.md（新規） | メニュー追加・席情報更新・ニュース投稿の手順 | ✅ |
| 9-2 | docs/09_cms-operation-manual.md | ACFフィールド説明一覧・画像サイズ・命名規則 | ✅ |
| 9-3 | docs/10_deploy-checklist.md（新規） | 本番公開チェックリスト | ✅ |
| 9-4 | README.md（新規） | プロジェクト概要・環境構築手順 | ✅ |

### STEP 9 完了条件

- STEP 9 完了（2026-03-22）
  - 9-1: docs/09_cms-operation-manual.md 新規作成（commit: 032f5b8）
  - 9-2: docs/09_cms-operation-manual.md v1.1 — ACFフィールド説明一覧・画像規則追記（commit: 5aea65e）
  - 9-3: docs/10_deploy-checklist.md 新規作成（commit: 12427d3）
  - 9-4: README.md 新規作成（commit: 93c1b30）

### STEP 9 コミット履歴

| コミット | 内容 |
| -------- | ---- |
| 032f5b8  | docs: HanaCAFE CMSマニュアル新規作成 |
| 5aea65e  | docs: バージョン1.1への更新とACFフィールド説明一覧を追加 |
| 12427d3  | docs: HanaCAFE本番公開チェックリストを新規作成 |
| 93c1b30  | docs: README.mdを新規作成し、プロジェクト概要や環境構築手順を追加 |
| 63471c6  | docs: STEP 9 運用マニュアル整備の進捗を更新し、完了条件を明記 |
| d59cac1  | fix: .gitignoreに.geminiを追加 |

---

## 🔵 STEP 9.5 — CSS設計・品質補強（2026-03-22実施）

| #     | 優先度 | 対象                   | 内容                                          | 状態 |
| ----- | ------ | ---------------------- | --------------------------------------------- | ---- |
| 9.5-1 | 🔴 高  | `_variables.scss` 他   | z-index をグローバル変数に一元管理            | ✅   |
| 9.5-2 | 🔴 高  | `_p-hero.scss`         | `__title-jp` に `font-family: $f-body` を明示 | ✅   |
| 9.5-3 | 🔴 高  | `theme.json`           | serif スラッグに Montserrat を追加・同期      | ✅   |
| 9.5-4 | 🟡 中  | `01_architecture...md` | ⑨ z-index 一元管理ルールを追記・v8.2へ更新   | ✅   |
| 9.5-5 | 🟡 中  | `03_ai-mentor...md`    | z-index チェック項目追加・参照ファイル名統一  | ✅   |

### STEP 9.5 コミット履歴

| コミット | 内容 |
| -------- | ---- |
| a5b7eba  | refactor: z-index一元管理 + fix: p-hero__title-jp フォント明示 |
| bf596f7  | fix: theme.json serifフォントにMontserrat追加し_variables.scssと同期 |
| 89a3746  | docs: 01_architectureフォント使い分けルール追記・v8.1 |

---

## 進捗サマリー

| STEP                            | 件数 | 状態      |
| ------------------------------- | ---- | --------- |
| STEP 7 フォーマット統一         | 6件  | ✅ 完了   |
| STEP 8 コンポーネント共通化     | 13件 | ✅ 完了   |
| STEP 8.5 技術的負債クリーニング | 11件 | ✅ 完了   |
| STEP 9 運用マニュアル           | 4件  | ✅ 完了   |
| STEP 9.5 CSS設計・品質補強      | 5件  | ✅ 完了   |
| STEP 10 リファクタリング・品質改善 | 7件 | ✅ 完了 |
| STEP 10 リファクタリング・品質改善 | 14件 | ✅ 完了 |

---

## 🔵 STEP 10 — リファクタリング・品質改善（docs/05 先送り負債）

目的: STEP 8.5 で先送りした技術的負債47件を精査し、
「今やる / 現状維持 / クローズ」に仕分けして対応する。

### グループ① — 安全・即効（コード変更なし or 1ファイル単独）

| #    | 優先度 | 対象 | 内容 | 状態 |
| ---- | ------ | ---- | ---- | ---- |
| 10-① | 🟡 中 | `_variables.scss` | `$c-sub` 未使用変数の削除 | ✅ |
| 10-① | 🟡 中 | `package.json` | `main` フィールド削除 | ✅ |

### グループ② — 動作リスクあり（要Serena確認）

| #    | 優先度 | 対象 | 内容 | 状態 |
| ---- | ------ | ---- | ---- | ---- |
| 10-② | 🔴 高 | `_variables.scss` + 各ファイル | z-index 一元管理 | ✅ |
| 10-② | 🟡 中 | SCSS横断 | `transition: all` 相当の記述を明示化 | ✅ |

### グループ③ — JS関連（動作確認必須）

| #    | 優先度 | 対象 | 内容 | 状態 |
| ---- | ------ | ---- | ---- | ---- |
| 10-③ | 🔴 高 | `_p-drawer.scss` / `main.js` | ドロワー `is-active` 残留バグ修正 | ✅ |
| 10-③ | 🟡 中 | `main.js` | `scroll` イベント内 `rAF` 多重実行対策 | ✅ |
| 10-③ | 🟡 中 | `main.js` | フォーカストラップのアクセシビリティ改善 | ✅ |

### グループ④ — docs/05 残存負債クリーンアップ（2026-03-23実施）

| #    | 優先度 | 対象 | 内容 | 状態 |
| ---- | ------ | ---- | ---- | ---- |
| 10-④ | 🟡 中 | `_l-header.scss` | `&__hamburger` の button リセット重複3プロパティを削除 | ✅ |
| 10-④ | 🟡 中 | `_base.scss` | `a` タグの `transition` に `ease` を明示 | ✅ |
| 10-④ | 🟡 中 | `_p-news.scss` | `&__header` の無効プロパティ `align-items: center` を削除 | ✅ |
| 10-④ | 🟢 低 | `main.js` | 旧変更ログコメント（日付付き履歴行）を物理削除 | ✅ |
| 10-④ | 🟡 中 | `_p-hero.scss` | hero `font-size` を `vw-clamp(48, 80)` に変更（No.29） | ✅ |
| 10-④ | 🟡 中 | `functions.php` | `filemtime()` に `file_exists()` ガード追加（No.53） | ✅ |
| 10-④ | 🟢 低 | `_p-access.scss` | `__map-img` の `aspect-ratio` / `border-radius` 重複削除（No.31） | ✅ |

#### コミット履歴:

| 831404f | refactor: transition省略形を明示化（_variables/$t-base追加・3箇所修正） |
| 0ce27ed | fix: グループ③ JSバグ修正（is-active残留/rAF passive/フォーカストラップ）+ transition ease明示（5件） |
| d06aa19 | refactor: docs/05残存負債クリーンアップ（4ファイル・5件） |

### STEP 10 完了条件

- グループ①②③の全タスクについて「対応 / 現状維持 / クローズ」の判断が完了している
- 対応したものはコミット済みで `docs/05` に記録されている
