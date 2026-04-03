<?php

/**
 * BcCsvImportSampleProducts 設定
 *
 * 独自のメニューキーと独自コントローラーを使用するため、BcCsvImportCore のメニューキーとは
 * 別のキー（BcCsvImportSampleProducts）でメニューを登録する。
 * これにより複数のインポートプラグインを同時有効化しても競合しない。
 */
return [
    'BcApp' => [
        'adminNavigation' => [
            'Contents' => [
                'BcCsvImportSampleProducts' => [
                    'title' => __d('baser_core', '商品CSVインポート サンプル'),
                    'url' => [
                        'Admin' => true,
                        'plugin' => 'BcCsvImportSampleProducts',
                        'controller' => 'sample_products_csv_imports',
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
];
