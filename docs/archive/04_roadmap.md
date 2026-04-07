---
Version: 2.5
Last Updated: 2026-04-03
Archived: 2026-04-07
Archive Reason: STEP12・STEP13全件完了。次回の保守タスク発生時はSTEP14として新規ロードマップを作成すること。
---

# 🗺️ HanaCAFE nappa69 ロードマップ

本番公開済み（2026-03-27）。以下は公開後の改善・保守タスクを管理する。
過去の作業記録（STEP 7〜11）は `docs/archive/04_roadmap-archive-step7-11.md` を参照。

---

## 📌 サイト構成・確定事項（AIメンター共有）

### サイト構成

**公開ページ（インデックス対象）**

| ページ | URL | 種別 |
|------|-----|------|
| トップ | `/` | 固定ページ |
| Concept | `/concept/` | 固定ページ |
| News一覧 | `/news/` | 固定ページ |
| News詳細 | `/news/記事名/` | 投稿（post） |
| Menu一覧 | `/menu/` | CPTアーカイブ |
| Menu詳細 | `/menu/メニュー名/` | CPT（menu） |

**マスターページ（noindex対象・訪問者には見えない）**

| ページ | スラッグ | 役割 |
|------|---------|------|
| common-info | `/common-info/` | ヒーロー画像等 |
| access-info | `/access-info/` | 住所・営業時間等 |
| menu-info | `/menu-info/` | トップ表示メニュー |
| about-seats | `/about-seats/` | 席情報 |
| news-info | `/news-info/` | ニュース共通設定 |

### XMLサイトマップの確定状態

| サイトマップ | 状態 | 理由 |
|------------|------|------|
| `page-sitemap.xml` | ✅ あり | `/` と `/concept/` の2ページ |
| `post-sitemap.xml` | — なし | ニュース投稿が0件のため生成されない（正常） |
| `menu-sitemap.xml` | — なし | CPT menuはYoastで意図的にnoindex設定済みのため生成されない（正常） |

---

## ✅ 完了済み STEP 概要

| STEP | 内容 | 完了日 |
| ---- | ---- | ------ |
| STEP 7 | フォーマット統一・開発環境整備 | 2026-03-22 |
| STEP 8 | コンポーネント共通化・ファイル構成整理 | 2026-03-22 |
| STEP 8.5 | 技術的負債クリーニング | 2026-03-23 |
| STEP 9 | 運用マニュアル整備 | 2026-03-22 |
| STEP 9.5 | CSS設計・品質補強 | 2026-03-23 |
| STEP 10 | リファクタリング・品質改善 | 2026-03-23 |
| STEP 11 | 本番公開チェック・移行 | 2026-03-27 |
| STEP 12 | docs 整理・引き継ぎ準備 | 2026-03-27 |
| STEP 13 | 公開後モニタリング | 2026-04-03 |

---

## ✅ STEP 12 — docs 整理・引き継ぎ準備（全件完了）

| # | 内容 | 状態 |
| --- | --- | --- |
| 12-1 | `04_roadmap.md` を新規作成・旧 04 を archive へ移動 | ✅ |
| 12-2 | `05_technical-debt-audit.md` を archive へ移動 | ✅ |
| 12-3 | `07_acf-field-dependency-map.md` → `07_acf-field-reference.md` にリネーム | ✅ |
| 12-4 | `08_runtime-environment-audit-checklist.md` + `10_deploy-checklist.md §7` を統合 | ✅ |
| 12-5 | `09_cms-operation-manual.md` → `09_cms運用マニュアル.md` にリネーム | ✅ |
| 12-6 | `10_deploy-checklist.md §1〜§6` を `10_公開前チェックリスット.md` として独立 | ✅ |

---

## ✅ STEP 13 — 公開後モニタリング・改善（全件完了）

| # | 内容 | 状態 |
| --- | --- | --- |
| 13-1 | Google Search Console でサイトマップ「成功」を確認 | ✅（2026-04-03確認・検出2ページ） |
| 13-2 | Google Search Console — カバレッジエラー0件を確認 | ✅（2026-04-03確認・エラー0件） |
| 13-3 | robots.txt が本番で正しく配信されているか確認・対応 | ✅ |
| 13-4 | noindex 5ページが意図通り除外されているか確認 | ✅ |
| 13-5 | PageSpeed Insights 再計測 | ✅ |
| 13-6 | SNS URL（Instagram / Facebook）設定 | ✅（ポートフォリオ用のためスキップ） |
| 13-7 | お席確認 URL（seat_check_url）設定 | ✅（ポートフォリオ用のためスキップ） |
