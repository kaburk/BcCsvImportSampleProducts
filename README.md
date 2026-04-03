# BcCsvImportSampleProducts

`BcCsvImportSampleProducts` は、`BcCsvImportCore` を使った最小構成のサンプルプラグインです。
独自テーブルへの CSV インポート実装例として、商品サンプルテーブル `bc_csv_sample_products` を提供します。

## 用途

- `BcCsvImportCore` の導入確認
- 独自テーブル向け `CsvImportService` 実装の学習用
- テンプレートCSV生成、重複処理、strict / lenient の動作確認

## 前提

- `BcCsvImportCore` を有効化済みであること
- 本プラグインを有効化すると、サンプル用のテーブルの migration が実行されます。
- 実際に使うときは不要な部分ですが、サンプル動作確認の為に入れています。

実運用では、`products` テーブルは商品管理側プラグインが持つ想定です。
この migration はあくまで動作確認用です。


## 管理画面

- メニュー名: `商品CSVインポート サンプル`
- URL: `/baser/admin/bc-csv-import-sample-products/sample_products_csv_imports/index`

画面構成自体は `BcCsvImportCore` の共通UIです。

## 対象テーブル

- Model alias: `BcCsvImportSampleProducts.BcSampleProducts`
- 物理テーブル: `bc_csv_sample_products`
- 重複キー: `sku`

## CSVフォーマット

テンプレートCSVのヘッダは次の通りです。

```csv
商品名,商品コード,価格,在庫数,カテゴリ,説明,公開状態
```

## テストデータ生成

大量件数で挙動確認したい場合は、CakePHP コンソールコマンドでテスト用 CSV を生成できます。

```bash
bin/cake BcCsvImportSampleProducts.generate_test_csv
```

CSVヘッダは `SampleProductsCsvImportService::getColumnMap()` から自動取得するため、
カラム定義を変更しても常にインポート仕様と一致します。

生成ファイル名は `import_products_*.csv` です。
例: `--sizes=10k --errors=5` の場合は `import_products_10k_err5pct.csv` が生成されます。

主なオプション:

- `--output=/path/to/dir` 出力先ディレクトリを変更（デフォルト: `tmp/csv/`）
- `--sizes=10k,100k` 生成件数をカンマ区切りで指定（デフォルト: `10k` / `k`・`m` サフィックス対応）
- `--errors=5` エラー行を約 5% 含める（デフォルト: `0`）

エラー行は一定間隔で差し込まれ、必須項目欠落・不正値・重複SKUなどのパターンを確認できます。

ヘルプを表示するには:

```bash
bin/cake BcCsvImportSampleProducts.generate_test_csv --help
```

## 実装の見どころ

- サービス実装: `src/Service/SampleProductsCsvImportService.php`
- Table / Entity: `src/Model/Table/BcSampleProductsTable.php`, `src/Model/Entity/BcSampleProduct.php`
- 専用コントローラー: `src/Controller/Admin/SampleProductsCsvImportsController.php`
- 画面テンプレート: `BcCsvImportCore` の共通テンプレート `Admin/CsvImports/index` を再利用

追加UIなしで独自インポート画面を持たせる最小サンプルとして利用できます。

## 動作画面サンプル

初期画面
<img width="1280" height="882" alt="000" src="https://github.com/user-attachments/assets/95b67688-6018-4f67-bd4b-dc8579396702" />
処理中
<img width="1280" height="877" alt="001" src="https://github.com/user-attachments/assets/f283f890-327d-423f-b700-b0a5c8921504" />
<img width="1280" height="876" alt="002" src="https://github.com/user-attachments/assets/6bd55564-ac8f-4ae0-84ac-46eaef1808c3" />

処理結果
<img width="1280" height="876" alt="003" src="https://github.com/user-attachments/assets/fa52591f-a769-429c-b982-bc380cc4c377" />

エラーの表示
<img width="1280" height="875" alt="004" src="https://github.com/user-attachments/assets/4ec60602-91e3-475e-a708-211c7faec1de" />

## ライセンス

MIT License. 詳細は `LICENSE.txt` を参照してください。
