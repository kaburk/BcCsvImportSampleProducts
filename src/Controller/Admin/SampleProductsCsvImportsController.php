<?php
declare(strict_types=1);

namespace BcCsvImportSampleProducts\Controller\Admin;

use BcCsvImportCore\Controller\Admin\CsvImportsController;
use BcCsvImportCore\Service\CsvImportServiceInterface;
use BcCsvImportSampleProducts\Service\SampleProductsCsvImportService;

/**
 * SampleProductsCsvImportsController
 *
 * BcCsvImportCore の CsvImportsController を継承し、
 * サンプル商品テーブル用のサービスを差し込む。
 * 複数のインポートプラグインを同時有効化できるよう、
 * ServiceProvider 経由の DI ではなく createImportService() で直接インスタンス化する。
 */
class SampleProductsCsvImportsController extends CsvImportsController
{

    /**
     * CSVアップロード画面
     *
     * コアのテンプレートを利用し、タイトルと adminBase のみ差し替える。
     *
     * @return void
     */
    public function index(): void
    {
        parent::index();
        $this->set('pageTitle', __d('baser_core', '商品CSVインポート サンプル'));
        $this->set('adminBase', '/baser/admin/bc-csv-import-sample-products/sample_products_csv_imports');
        $this->viewBuilder()->setTemplatePath($this->name);
        $this->viewBuilder()->setTemplate('BcCsvImportCore.Admin/CsvImports/index');
    }

    /**
     * インポートサービスを生成する
     *
     * @return CsvImportServiceInterface
     */
    protected function createImportService(): CsvImportServiceInterface
    {
        return new SampleProductsCsvImportService();
    }

}
