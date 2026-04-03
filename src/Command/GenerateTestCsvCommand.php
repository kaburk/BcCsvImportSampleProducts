<?php
declare(strict_types=1);

namespace BcCsvImportSampleProducts\Command;

use BcCsvImportCore\Command\AbstractGenerateTestCsvCommand;
use BcCsvImportCore\Service\CsvImportServiceInterface;
use BcCsvImportSampleProducts\Service\SampleProductsCsvImportService;

/**
 * GenerateTestCsvCommand
 *
 * SampleProducts テスト用CSVファイルを生成する CakePHP コンソールコマンド。
 * CSVヘッダは SampleProductsCsvImportService::getColumnMap() から自動取得します。
 *
 * 使い方（プロジェクトルートから実行）:
 *   bin/cake BcCsvImportSampleProducts.generate_test_csv
 */
class GenerateTestCsvCommand extends AbstractGenerateTestCsvCommand
{

    public static function defaultName(): string
    {
        return 'bc_csv_import_sample_products.generate_test_csv';
    }

    protected function getCommandDescription(): string
    {
        return 'SampleProducts テスト用CSVファイルを生成します。';
    }

    protected function getService(): CsvImportServiceInterface
    {
        return new SampleProductsCsvImportService();
    }

    protected function getFilenamePrefix(): string
    {
        return 'import_products_';
    }

    protected function buildRow(int $i, array $columnKeys): array
    {
        $categories = ['電化製品', '食品', '衣料品', '家具', '書籍', 'おもちゃ', 'スポーツ', '美容', 'ペット用品', '文具'];
        $statuses = [1, 1, 1, 1, 0];
        $category = $categories[($i - 1) % count($categories)];
        $status = $statuses[($i - 1) % count($statuses)];
        $row = [];
        foreach ($columnKeys as $key) {
            $row[$key] = match ($key) {
                'name'        => 'テスト商品' . $i,
                'sku'         => sprintf('SKU-%07d', $i),
                'price'       => (($i % 100) + 1) * 100,
                'stock'       => ($i % 500) + 1,
                'category'    => $category,
                'description' => $category . 'の商品説明テキスト（行番号:' . $i . '）',
                'status'      => $status,
                default       => '',
            };
        }
        return $row;
    }

    protected function getErrorPatterns(): array
    {
        return [
            '商品名が空（必須項目エラー）' => function (array $row): array {
                $row['name'] = '';
                return $row;
            },
            '価格が負の値（バリデーションエラー）' => function (array $row): array {
                $row['price'] = -999;
                return $row;
            },
            '価格が文字列（型エラー）' => function (array $row): array {
                $row['price'] = '千円';
                return $row;
            },
            '公開状態が不正値（バリデーションエラー）' => function (array $row): array {
                $row['status'] = 99;
                return $row;
            },
            '商品コードが重複（SKU-0000001と同じ）' => function (array $row): array {
                $row['sku'] = 'SKU-0000001';
                return $row;
            },
        ];
    }
}
