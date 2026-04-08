# HanaCAFE nappa69 — WordPress テーマ開発リポジトリ

HanaCAFE のカスタム WordPress テーマ「hanacafe-theme」の開発・リファクタリング用リポジトリです。

---

## 目次

1. [プロジェクト概要](#1-プロジェクト概要)
2. [ディレクトリ構成](#2-ディレクトリ構成)
3. [環境構築手順](#3-環境構築手順)
4. [開発フロー](#4-開発フロー)
5. [ドキュメント一覧](#5-ドキュメント一覧)

---

## 1. プロジェクト概要

| 項目 | 内容 |
|---|---|
| サイト名 | HanaCAFE |
| テーマ名 | hanacafe-theme（nappa69） |
| WordPress バージョン | 6.9.x |
| ローカル環境 | MAMP |
| 使用プラグイン | Advanced Custom Fields (ACF) / Custom Post Type UI (CPT UI) / All-in-One WP Migration and Backup / WP Super Cache / Yoast SEO |
| パーマリンク形式 | 投稿名形式 |
| ローカル WordPress アドレス | http://hanacafe.local/wp |
| ローカル サイトアドレス | http://hanacafe.local |
| 本番 WordPress アドレス | https://intp.site/2999/WordPress/hanacafe/wp |
| 本番 サイトアドレス | https://intp.site/2999/WordPress/hanacafe |

### 使用プラグイン 用途一覧

| プラグイン | 用途 |
|---|---|
| Advanced Custom Fields (ACF) | カスタムフィールド管理 |
| Custom Post Type UI (CPT UI) | カスタム投稿タイプ・タクソノミー登録 |
| All-in-One WP Migration and Backup | ローカル→本番へのデータ移行（投稿・設定のエクスポート／インポート・URL置換） |
| WP Super Cache | キャッシュ管理・サイト高速化 |
| Yoast SEO | SEO設定・OGP画像・XMLサイトマップ・noindex管理 |

---

## 2. ディレクトリ構成

```
wordpress-hanacafe/
├── docs/                              # 設計・運用ドキュメント群
│   ├── HanaCAFE nappa69 プロジェクト仕様書.md  # ★ SSOT（v1.2.0）
│   ├── 01_architecture-and-design-rules.md    # 実装黄金律・詳細ルール
│   ├── 02_wordpress-coding-standards.md       # コーディング規約・環境定義
│   ├── 08_本番移行手順書.md
│   ├── 09_cms運用マニュアル.md
│   ├── 10_サイト品質チェックリスト.md
│   ├── acf-fields.json                # ACF フィールド定義（インポート用）
│   ├── cptui-post-types.json          # CPT UI 定義（インポート用）
│   ├── cptui-taxonomies.json          # CPT UI タクソノミー定義（インポート用）
│   └── archive/                       # 旧ドキュメント保管庫
└── wp/
    └── wp-content/
        └── themes/
            └── hanacafe-theme/        # テーマ本体
                ├── assets/            # CSS(コンパイル済み)・JS・画像
                ├── src/               # SCSS ソースファイル
                ├── template-parts/    # テンプレートパーツ
                ├── functions.php      # テーマ関数・ヘルパー
                ├── header.php
                ├── footer.php
                ├── front-page.php
                ├── style.css
                └── theme.json
```

---

## 3. 環境構築手順

### 前提条件

- MAMP がインストール済みであること
- VS Code に **Live Sass Compiler** 拡張機能がインストール済みであること

### 手順

#### 3-1. リポジトリのクローン

```bash
git clone https://github.com/a-san-un/wordpress-hanacafe.git
cd wordpress-hanacafe
```

#### 3-2. MAMP の設定

1. MAMP を起動し、「Preferences」→「Web Server」でドキュメントルートを確認
2. WordPress を `wp/` 以下に配置、または MAMP のルートに合わせてシンボリックリンクを設定
3. データベースを作成し、`wp-config.php` に接続情報を設定

#### 3-3. WordPress の初期設定

1. ブラウザで `http://hanacafe.local/wp` にアクセス
2. WordPress のインストール画面に従ってセットアップ
3. 管理画面「外観」→「テーマ」→「hanacafe-theme」を有効化
4. 必須プラグインをインストール・有効化
   - Advanced Custom Fields (ACF)
   - Custom Post Type UI (CPT UI)
   - All-in-One WP Migration and Backup
   - WP Super Cache
   - Yoast SEO
5. 設定 → パーマリンク → 「投稿名」を選択して保存

#### 3-4. ACF・CPT UI のインポート

`docs/` 以下の JSON ファイルを管理画面からインポートしてください。

| ファイル | インポート先 |
|---|---|
| `docs/acf-fields.json` | Advanced Custom Fields → ツール → フィールドグループをインポート |
| `docs/cptui-post-types.json` | CPT UI → ツール → インポート/エクスポート → 投稿タイプ |
| `docs/cptui-taxonomies.json` | CPT UI → ツール → インポート/エクスポート → タクソノミー |

#### 3-5. マスター固定ページの作成

以下の固定ページをスラッグ通りに作成してください。

| 固定ページ名 | スラッグ | 用途 |
|---|---|---|
| 共通情報 | `common-info` | ヒーロー画像・デフォルト画像 |
| アクセス・店舗情報 | `access-info` | 住所・電話・営業時間・SNS |
| メニュー設定 | `menu-info` | トップ表示メニューのピックアップ |
| 席情報 | `about-seats` | 席種・ステータス管理 |
| ニュース設定 | `news-info` | ニュース共通設定 |

#### 3-6. SCSS のコンパイル（開発時）

本プロジェクトは **VS Code の Live Sass Compiler** 拡張機能を使用しています。

1. VS Code でプロジェクトを開く
2. ステータスバーの「Watch Sass」をクリック
3. `src/scss/` 以下の `.scss` ファイルを編集すると、`assets/css/` に自動コンパイルされます

---

## 4. 開発フロー

1. `main` ブランチから作業ブランチを切る（例: `feature/step-9`）
2. タスク単位でコミット・プッシュ
3. コミットメッセージは Conventional Commits に準拠
   - `feat:` 新機能
   - `fix:` バグ修正
   - `refactor:` リファクタリング
   - `docs:` ドキュメント更新
4. 作業完了後、`main` にマージ

---

## 5. ドキュメント一覧

| ファイル | 内容 | バージョン |
|---|---|---|
| [HanaCAFE nappa69 プロジェクト仕様書.md](HanaCAFE%20nappa69%20%E3%83%97%E3%83%AD%E3%82%B8%E3%82%A7%E3%82%AF%E3%83%88%E4%BB%95%E6%A7%98%E6%9B%B8.md) | **★ SSOT** — テンプレート階層・データ構造・FLOCSS設計・主要ロジック仕様の全体像 | v1.2.0 |
| [01_architecture-and-design-rules.md](01_architecture-and-design-rules.md) | 開発者の作法・実装黄金律（透過率・z-index・Anti-Blackout 等の詳細ルール） | v8.3 |
| [02_wordpress-coding-standards.md](02_wordpress-coding-standards.md) | コーディング規約・環境定義（インデント・エスケープ・Git規約・theme.json同期） | v8.1 |
| [08_本番移行手順書.md](08_%E6%9C%AC%E7%95%AA%E7%A7%BB%E8%A1%8C%E6%89%8B%E9%A0%86%E6%9B%B8.md) | 本番移行手順（ランタイム前提・All-in-One移行手順・インポート後設定） | v1.0 |
| [09_cms運用マニュアル.md](09_cms%E9%81%8B%E7%94%A8%E3%83%9E%E3%83%8B%E3%83%A5%E3%82%A2%E3%83%AB.md) | CMS 運用マニュアル（メニュー追加・席情報更新・ニュース投稿の操作手順） | v1.4 |
| [10_サイト品質チェックリスト.md](10_%E3%82%B5%E3%82%A4%E3%83%88%E5%93%81%E8%B3%AA%E3%83%81%E3%82%A7%E3%83%83%E3%82%AF%E3%83%AA%E3%82%B9%E3%83%88.md) | 本番公開済みサイトの定期品質確認（管理画面・目視・DevToolsコマンド） | v3.2 |

---

_最終更新: 2026-04-08_
