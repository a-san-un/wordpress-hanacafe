---
Version: 2.2
Last Updated: 2026-03-27
SSOT: このドキュメントは HanaCAFE nappa69 の現在地と今後の作業計画の唯一の情報源です。
---

# 🗺️ HanaCAFE nappa69 ロードマップ

本番公開済み（2026-03-27）。以下は公開後の改善・保守タスクを管理する。
過去の作業記録（STEP 7〜11）は `docs/archive/04_roadmap-archive-step7-11.md` を参照。

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

---

## ✅ STEP 12 — docs 整理・引き継ぎ準備（全件完了）

目的: docs/ を引き継ぎ可能な状態に整理する。

| # | 内容 | 状態 |
| --- | --- | --- |
| 12-1 | `04_roadmap.md` を新規作成（本ファイル）・旧04をarchiveへ移動 | ✅ |
| 12-2 | `05_technical-debt-audit.md` を archive へ移動 | ✅ |
| 12-3 | `07_acf-field-dependency-map.md` → `07_acf-field-reference.md` にリネーム | ✅ |
| 12-4 | `08_runtime-environment-audit-checklist.md` + `10_deploy-checklist.md §7` を統合 → `08_本番移行手順書.md` | ✅ |
| 12-5 | `09_cms-operation-manual.md` → `09_cms運用マニュアル.md` にリネーム | ✅ |
| 12-6 | `10_deploy-checklist.md §1〜§6` を `10_公開前チェックリスト.md` として独立・旧10をarchiveへ | ✅ |

---

## 🟡 STEP 13 — 公開後モニタリング・改善

| # | 内容 | 状態 |
| --- | --- | --- |
| 13-1 | Google Search Console でサイトマップ「成功」を確認 | 🔲（サイトマップ送信済み・数日後に確認） |
| 13-2 | Google Search Console — カバレッジエラー0件を確認 | 🔲（数日後に確認） |
| 13-3 | robots.txt が本番で正しく配信されているか確認・対応 | ✅（Yoast ファイルエディターで内容確認済み。内容は正常） |
| 13-4 | noindex 5ページが意図通り除外されているか確認 | ✅（全ページ noindex, nofollow をコンソールで確認済み） |
| 13-5 | PageSpeed Insights 再計測 | ✅（スコア55・FCP27秒はサーバーTTFB起因。コード品質問題なし） |
| 13-6 | SNS URL（Instagram / Facebook）設定 | ✅（ポートフォリオ用のためスキップ） |
| 13-7 | お席確認 URL（seat_check_url）設定 | ✅（ポートフォリオ用のためスキップ） |

---

## 進捗サマリー

| STEP | 件数 | 状態 |
| ---- | ---- | ---- |
| STEP 12 docs整理 | 6件 | **全件完了 ✅** |
| STEP 13 公開後モニタリング | 7件 | 5件完了・⬜ 2件残（13-1, 13-2はGSC数日後に確認） |
