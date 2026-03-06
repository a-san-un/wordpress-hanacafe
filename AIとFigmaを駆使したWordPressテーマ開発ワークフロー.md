# AIとFigmaを駆使したWordPressテーマ開発ワークフロー
### Phase 1: StitchでのUIプロトタイプ生成（最新GUI対応）

現在のStitchは、単なるコード生成ツールではなく、AIと対話しながらデザインを組み上げる**「AIキャンバス」**へと進化しています。

1. **AIプロンプトで生成**:
* 「カフェのAboutセクション。左に画像、右にテキスト。ナチュラルな雰囲気で」といったプロンプトをチャット欄に入力。


2. **インライン編集（最新GUI）**:
* プレビュー画面上の要素を直接クリックし、テキストの書き換えや画像の置換、余白の微調整をGUI上で行います。


3. **Figmaへのエクスポート**:
* 右上の **[Export]** ボタンから **[Copy to Figma]**（またはURLをコピー）を選択します。
* **※重要**: Stitchが出力するTailwindコードをそのまま使おうとせず、「デザインの種」としてFigmaへ持っていくのが「やり直し」を防ぐコツです。



---

### Phase 2: Figmaでのデザイン・変数マッピング

ここで、Stitchで作った「仮の色」を、あなたのプロジェクトの「正式な変数」に紐付けます。

1. **インポート**:
* プラグイン **[html.to.design]** でStitchのURLを読み込みます。


2. **Selection Colors で一括置換**:
* フレームを選択し、右サイドバーの **[Selection colors]** を確認。
* Stitchが生成したランダムなカラーコードを、プロジェクトのブランドカラー（例：`$c-main` に相当する `#2E4D07`）へ一括で打ち変えます。


3. **BEM命名（Layer names）**:
* 各レイヤーに `p-about__title` や `c-button` と名前を付けます。


4. **Auto Layout の最終確認**:
* `Shift + A` でオートレイアウトを適用。不自然な `position: absolute`（絶対配置）がない状態に整えます。これが後のSCSSの品質を決定します。



---

### Phase 3: [Figma to Code] による「高品質な材料」の抽出

プラグインの設定を固定し、AIが最も理解しやすい形式でコードを取り出します。

1. **プラグイン設定（Styling Options）**:
* **Layer names**: **ON**（クラス名を自動生成するため）
* **Color Variables**: **ON**（色を変数として抽出するため）
* **Embed Images/Vectors**: **OFF**（コードの肥大化を防ぐため）


2. **抽出**:
* セクション単位（About等）で選択し、**[HTML] タブ** のコードをコピーします。



---

### Phase 4: AI（Gemini/Cursor）によるFLOCSS翻訳

取り出した「生のコード」を、フードサイエンス流の設計図へリファクタリングさせます。

**【最強の翻訳プロンプト・テンプレート】**

> 以下のHTML/CSSを、私の雛形（FLOCSS/SCSS）に合わせて変換してください。
> 1. **HTML:** `style` 属性をすべて削除し、`Layer names` から抽出されたクラス名（BEM）を使用してください。
> 2. **SCSS:** `var(--color-...)` を、私の `_variable.scss` の変数（`$c-main` 等）にマッピングしてください。
> 3. **レスポンシブ:** 固定幅（`1440px`）や `absolute` を排除し、`flex` や `grid` を用いた設計にリファクタリングして、`_p-about.scss` 用に出力してください。
> 4. **WordPress:** 後でループ化しやすい構造にしてください。
> 
> 

---

### Phase 5: VS Codeでの実装と自動コンパイル

1. **フォルダ配置**:
* 抽出されたSCSSを `assets/scss/object/project/_p-about.scss` に保存。


2. **自動コンパイル**:
* 設定済みの `.vscode/settings.json` により、保存した瞬間に `assets/css/app.css` が更新されます。


```json
// 再掲：最強の相対パス設定
"liveSassCompile.settings.formats": [{
  "format": "expanded",
  "extensionName": ".css",
  "savePath": "/../css"
}]

```


3. **WordPressテンプレート化**:
* HTMLを `template-parts/content-about.php` に分割し、動的な箇所（ACFなど）をPHPに書き換えます。



---

### このワークフローのメリット

* **Stitch** で「デザインのアイデア」を爆速で作り、
* **Figma** で「変数と命名」という論理構造を固め、
* **AI** に「面倒なSCSSコーディング」を任せ、
* **自分** は「WordPressのロジック」に集中できる。

これが、2026年における最もミスの少ない、かつ最速のテーマ開発フローです。次回の作業からは、この Phase 1 から順に当てはめていくだけで、プロ品質のサイトが完成します。