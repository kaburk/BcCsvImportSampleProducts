<?php
declare(strict_types=1);

namespace BcCsvImportSampleProducts\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BcCsvSampleProductsTable
 */
class BcCsvSampleProductsTable extends Table
{

    /**
     * Initialize
     *
     * @param array $config
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('bc_csv_sample_products');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
    }

    /**
     * Validation Default
     *
     * @param Validator $validator
     * @return Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->notEmptyString('name', __d('baser_core', '商品名は必須です。'));

        $validator
            ->scalar('sku')
            ->maxLength('sku', 100)
            ->allowEmptyString('sku');

        $validator
            ->integer('price')
            ->greaterThanOrEqual('price', 0, __d('baser_core', '価格は0以上の数値を入力してください。'))
            ->allowEmptyString('price');

        $validator
            ->integer('stock')
            ->greaterThanOrEqual('stock', 0, __d('baser_core', '在庫数は0以上の数値を入力してください。'))
            ->allowEmptyString('stock');

        $validator
            ->scalar('category')
            ->maxLength('category', 100)
            ->allowEmptyString('category');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->boolean('status')
            ->allowEmptyString('status');

        return $validator;
    }

}
