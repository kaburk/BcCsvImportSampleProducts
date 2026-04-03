<?php
declare(strict_types=1);

namespace BcCsvImportSampleProducts\Service;

use BcCsvImportCore\Service\CsvImportService;
use BcCsvImportCore\Service\CsvImportServiceInterface;
use Cake\Datasource\EntityInterface;
use Cake\ORM\TableRegistry;

/**
 * SampleProductsCsvImportService
 *
 * 商品情報サンプルテーブル（bc_csv_sample_products）へのインポートサービス。
 * BcCsvImportCore を使った独自テーブルへのインポート実装のサンプル。
 * 実際のプロジェクトでは、このクラスを参考に独自のサービスクラスを作成してください。
 */
class SampleProductsCsvImportService extends CsvImportService implements CsvImportServiceInterface
{

    /**
     * インポート対象のテーブル名
     *
     * @return string
     */
    public function getTableName(): string
    {
        return 'BcCsvImportSampleProducts.BcSampleProducts';
    }

    /**
     * CSVカラムマップ
     * key: テーブルのカラム名, label: CSV上の表示名, required: 必須かどうか, sample: サンプル値
     *
     * @return array
     */
    public function getColumnMap(): array
    {
        return [
            'name' => [
                'label' => '商品名',
                'required' => true,
                'sample' => 'サンプル商品A',
            ],
            'sku' => [
                'label' => '商品コード',
                'required' => false,
                'sample' => 'SKU-001',
            ],
            'price' => [
                'label' => '価格',
                'required' => false,
                'sample' => '1000',
            ],
            'stock' => [
                'label' => '在庫数',
                'required' => false,
                'sample' => '100',
            ],
            'category' => [
                'label' => 'カテゴリ',
                'required' => false,
                'sample' => '電化製品',
            ],
            'description' => [
                'label' => '説明',
                'required' => false,
                'sample' => '商品の説明テキスト',
            ],
            'status' => [
                'label' => '公開状態',
                'required' => false,
                'sample' => true,
            ],
        ];
    }

    /**
     * 重複チェックに使うカラム名
     *
     * @return string
     */
    public function getDuplicateKey(): string
    {
        return 'sku';
    }

    /**
     * CSV1行（連想配列）からEntityを生成する
     *
     * @param array $row
     * @return EntityInterface
     */
    public function buildEntity(array $row): EntityInterface
    {
        $table = TableRegistry::getTableLocator()->get($this->getTableName());

        $data = [
            'name'        => $row['name'] ?? null,
            'sku'         => $row['sku'] ?? null,
            'price'       => isset($row['price']) && $row['price'] !== '' ? (int)$row['price'] : null,
            'stock'       => isset($row['stock']) && $row['stock'] !== '' ? (int)$row['stock'] : null,
            'category'    => $row['category'] ?? null,
            'description' => $row['description'] ?? null,
            'status'      => isset($row['status']) ? (bool)$row['status'] : true,
        ];

        return $table->newEntity($data);
    }

}
