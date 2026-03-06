# AIとFigmaを駆使したWordPressテーマ開発ワークフロー

### 🚩 開発の憲法：プロ仕様リファクタリング「5つの黄金律」

全工程において、以下の5つのルールを設計の起点とします。

1. **FLOCSSレイヤー設計**: 役割に応じて `p-`（プロジェクト固有）、`c-`（再利用パーツ）の接頭辞を使い分ける。
2. **SSOT（単一の真実）**: カラーやフォントは必ずプロジェクト共通の変数（`$c-main` 等）へ紐付ける。`theme.json` のカラーパレット名とSCSS変数を同期させる。
3. **流体（Fluid）UI**: 固定幅（px）を捨て、`flex` / `grid` / `Fill` を活用したレスポンシブ構造にする。
4. **WPセマンティック & 動的設計**:
* `div` の羅列を避け、`section` / `figure` / `figcaption` 等、WP標準ブロックと互換性のあるタグを使う。
* `the_title()` や ACF の `get_field()` でループ・置換しやすい構造にする。


5. **コンテナ余白の死守**: 左右の余白は共通の `l-container`（PC 80px/SP 24px等）を常に基準とする。

---

### Phase 1: StitchでのUIプロトタイプ生成 ＆ AIによる事前洗浄

StitchのTailwindコードをそのまま使わず、AIで「黄金律」に沿ったクリーンなHTMLに変換してからFigmaへ渡します。

1. **Stitchでプロトタイプ生成**:
* AIプロンプトでセクションの「種」を作る。


2. **AIによる事前リファクタリング（★最重要）**:
* Stitchの **[Export] → [Copy Code]** でHTML/CSSを取得。
* AI（Gemini/Cursor）に以下の指示を出し、構造を洗浄する。


> 「このStitchのコードを**5つの黄金律**に基づきリファクタリングして。style属性を全削除し、BEMクラス名（p-等）を付与。タグはWP標準ブロック互換（figure等）に変更したクリーンなHTMLのみ出力して」


3. **ローカルプレビュー**:
* 変換されたコードを `.html` ファイルとして保存し、ブラウザで意図した構造か確認。



---

### Phase 2: Figmaへのインポートと「黄金律」の定着

AIで洗浄した「正しい論理構造」をFigmaに読み込み、デザインを完成させます。

1. **html.to.design による読み込み**:
* プラグインを開き、以下の **4つのオプションを必ずON** に設定。
* [x] **Use Autolayout**（流体UIの土台）
* [x] **Create styles & variables**（SSOTの管理）
* [x] **Add hyperlinks**
* [x] **HTML layer names**（AIが洗浄したBEMクラス名を維持）
* **Viewports**: `Desktop (1440)` & `Mobile (390)` を指定。


2. **Selection Colors での変数同期（黄金律2：SSOT）**:
* 右サイドバーの **[Selection colors]** から、AIが仮で当てた色をプロジェクトの正式な変数色（`$c-main` 等）へ一括置換。


3. **Auto Layout の最終調整（黄金律3：流体UI）**:
* インポートされた要素の幅を `Fixed` から `Fill container` へ変更。絶対配置（`absolute`）を排除。



---

### Phase 3: [Figma to Code] による「高品質な材料」の抽出

Figmaで整えた「設計図」から、AIが最も理解しやすい形式でコードを取り出します。

1. **プラグイン設定（Styling Options）**:
* **Layer names**: **ON**（BEMクラス名を維持するため）
* **Color Variables**: **ON**
* **Embed Images/Vectors**: **OFF**


2. **抽出**:
* セクション単位で選択し、**[HTML] タブ** のコードをコピー。これが最終翻訳の「材料」となる。



---

### Phase 4: AI（Gemini/Cursor）によるFLOCSS翻訳

Figmaから抽出したコードを、**「5つの黄金律」** に基づいて最終的なSCSS/PHPへと翻訳させます。

**【決定版】最強の翻訳プロンプト・テンプレート（v2）**

```markdown
以下のFigma抽出データを、冒頭の「5つの黄金律」に基づき、実実装用のコードへ最終翻訳してください。

■ 制約事項：
1. 【HTML】 style属性を全削除。クラス名はレイヤー名のBEMを維持し、WP標準ブロック互換（section, figure等）のセマンティックな構造に整理。
2. 【SCSS】 生のカラーコードを弊社の _variables.scss の変数（$c-main, $f-en 等）へ強制マッピング。
3. 【レスポンシブ】 absolute と固定幅を排除。flexbox/grid を用い、l-container（PC 80px/SP 24px等）の余白設計を継承。
4. 【動的対応】 コンテンツ部分は the_title() や ACF の get_field() で置換・ループ化しやすいタグ構造で出力。

■ Figma生データ：
[ここにFigma to Codeの出力をペースト]

```

---

### Phase 5: VS Codeでの実装と自動コンパイル

1. **フォルダ配置**:
* `src/scss/object/project/_p-***.scss` 等に保存。


2. **自動コンパイル**: Live Sass Compiler を使用。
* 設定済みの `.vscode/settings.json` により、保存時に `assets/css/app.css` が更新される。



```json
{
  "intelephense.format.braces": "k&r",
  "liveSassCompile.settings.includeItems": [
    "**/src/scss/**/*.scss"
  ],
  "liveSassCompile.settings.formats": [
    {
      "format": "expanded",
      "extensionName": ".css",
      "savePath": "/assets/css"
    }
  ],
  "liveSassCompile.settings.excludeList": [
    "/**/node_modules/**",
    "/.vscode/**",
    "/wp-admin/**",
    "/wp-includes/**"
  ]
}

```

3. **WordPressテンプレート化**:
* HTMLを `template-parts/` に分割し、動的箇所をPHP化。



---

### このワークフローのメリット

* **Stitch** でデザインの「感性」を素早く形にする。
* **AI事前洗浄** で、Figmaに読み込む前から「論理構造」を正す。
* **Figma** で「SSOT（色・文字）」と「流体UI」を確定させる。
* **AI最終翻訳** で、一切の妥協がない「プロ仕様のコード」を手に入れる。
