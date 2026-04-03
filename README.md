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
├── docs/                          # 設計・運用ドキュメント群
│   ├── 01_architecture-and-design-rules.md
│   ├── 02_wordpress-coding-standards.md
│   ├── 03_ai-mentor-instructions.md
│   ├── 04_roadmap.md
│   ├── 07_acf-field-reference.md
│   ├── 08_本番移行手順書.md
│   ├── 09_cms運用マニュアル.md
│   ├── 10_サイト品質チェックリスト.md
│   └── archive/                   # 旧ドキュメント保管庫
└── wp/
    └── wp-content/
        └── themes/
            └── hanacafe-theme/    # テーマ本体
                ├── assets/        # CSS(コンパイル済み)・JS・画像
                ├── src/           # SCSS ソースファイル
                ├── template-parts/# テンプレートパーツ
                ├── functions.php  # テーマ関数・ヘルパー
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

管理画面から ACF フィールドグループと CPT 定義をインポートしてください。
（インポートファイルは別途プロジェクトメンバーから入手してください）

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
| [01_architecture-and-design-rules.md](docs/01_architecture-and-design-rules.md) | 設計ルール・黄金律（SSOT） | v8.3 |
| [02_wordpress-coding-standards.md](docs/02_wordpress-coding-standards.md) | コーディング規約（SSOT） | v8.1 |
| [03_ai-mentor-instructions.md](docs/03_ai-mentor-instructions.md) | AI メンター行動マニュアル | v9.0 |
| [04_roadmap.md](docs/04_roadmap.md) | Phase 2 進捗管理・変更履歴 | v2.5 |
| [07_acf-field-reference.md](docs/07_acf-field-reference.md) | ACF フィールド一覧 | — |
| [08_本番移行手順書.md](docs/08_本番移行手順書.md) | 本番移行手順 | v1.0 |
| [09_cms運用マニュアル.md](docs/09_cms運用マニュアル.md) | CMS 運用マニュアル | — |
| [10_サイト品質チェックリスト.md](docs/10_サイト品質チェックリスト.md) | 本番公開済みサイトの定期品質確認 | v3.2 |

---

_最終更新: 2026-04-03_
