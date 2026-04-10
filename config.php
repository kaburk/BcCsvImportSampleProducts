<?php
return [
    'type' => 'Plugin',
    'title' => __d('baser_core', '商品CSVインポート サンプル'),
    'description' => __d('baser_core', 'BcCsvImportCore の活用サンプルプラグインです。商品サンプルテーブルへのCSVインポート機能を提供します。'),
    'author' => 'kaburk',
    'url' => 'https://blog.kaburk.com/',
    'adminLink' => [
        'prefix' => 'Admin',
        'plugin' => 'BcCsvImportSampleProducts',
        'controller' => 'SampleProductsCsvImports',
        'action' => 'index',
    ],
];
