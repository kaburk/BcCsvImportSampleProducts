<?php
declare(strict_types=1);

use BaserCore\Database\Migration\BcMigration;

class CreateBcCsvSampleProducts extends BcMigration
{
    public function up()
    {
        $this->table('bc_csv_sample_products', ['collation' => 'utf8mb4_general_ci'])
            ->addColumn('name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('sku', 'string', ['limit' => 100, 'null' => true, 'default' => null])
            ->addColumn('price', 'integer', ['null' => true, 'default' => null])
            ->addColumn('stock', 'integer', ['null' => true, 'default' => null])
            ->addColumn('category', 'string', ['limit' => 100, 'null' => true, 'default' => null])
            ->addColumn('description', 'text', ['null' => true, 'default' => null])
            ->addColumn('status', 'boolean', ['null' => true, 'default' => true])
            ->addColumn('created', 'datetime', ['null' => true, 'default' => null])
            ->addColumn('modified', 'datetime', ['null' => true, 'default' => null])
            ->create();
    }

    public function down()
    {
        $this->table('bc_csv_sample_products')->drop()->save();
    }
}
