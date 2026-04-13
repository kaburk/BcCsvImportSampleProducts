<?php
declare(strict_types=1);

namespace BcCsvImportSampleProducts\Test\TestCase\Service;

use BaserCore\TestSuite\BcTestCase;
use BcCsvImportSampleProducts\Service\SampleProductsCsvImportService;

/**
 * SampleProductsCsvImportServiceTest
 *
 * SampleProductsCsvImportService のカラムマップ・エンティティ構築・重複キー等を検証する。
 */
class SampleProductsCsvImportServiceTest extends BcTestCase
{
    /** @var SampleProductsCsvImportService */
    private SampleProductsCsvImportService $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = new SampleProductsCsvImportService();
    }

    // ─────────────────────────────────────────────────────────────
    // getColumnMap
    // ─────────────────────────────────────────────────────────────

    public function testGetColumnMapReturnsExpectedKeys(): void
    {
        $map = $this->service->getColumnMap();

        $expectedKeys = ['name', 'sku', 'price', 'stock', 'category', 'description', 'status'];
        $this->assertSame($expectedKeys, array_keys($map));
    }

    public function testGetColumnMapHasLabelForEachKey(): void
    {
        foreach ($this->service->getColumnMap() as $key => $definition) {
            $this->assertArrayHasKey('label', $definition, "カラム '{$key}' に label キーが必要");
            $this->assertNotEmpty($definition['label'], "カラム '{$key}' の label が空");
        }
    }

    public function testGetColumnMapNameIsRequired(): void
    {
        $map = $this->service->getColumnMap();
        $this->assertTrue($map['name']['required'] ?? false, "'name' は required=true であるべき");
    }

    // ─────────────────────────────────────────────────────────────
    // getDuplicateKey
    // ─────────────────────────────────────────────────────────────

    public function testGetDuplicateKeyReturnsSku(): void
    {
        $this->assertSame('sku', $this->service->getDuplicateKey());
    }

    // ─────────────────────────────────────────────────────────────
    // buildEntity
    // ─────────────────────────────────────────────────────────────

    public function testBuildEntityCreatesEntityWithName(): void
    {
        $entity = $this->service->buildEntity([
            'name'        => 'テスト商品',
            'sku'         => 'SKU-TEST',
            'price'       => '1500',
            'stock'       => '50',
            'category'    => 'テスト',
            'description' => '説明文',
            'status'      => '1',
        ]);

        $this->assertSame('テスト商品', $entity->get('name'));
        $this->assertSame('SKU-TEST', $entity->get('sku'));
        $this->assertSame(1500, $entity->get('price'));
        $this->assertSame(50, $entity->get('stock'));
        $this->assertFalse($entity->hasErrors(), 'バリデーションエラーがないこと');
    }

    public function testBuildEntityHasErrorWhenNameIsEmpty(): void
    {
        $entity = $this->service->buildEntity([
            'name'        => '',
            'sku'         => 'SKU-001',
            'price'       => '100',
            'stock'       => '10',
            'category'    => '',
            'description' => '',
            'status'      => '1',
        ]);

        $this->assertTrue($entity->hasErrors(), '商品名が空の場合はバリデーションエラーになること');
        $this->assertArrayHasKey('name', $entity->getErrors());
    }

    public function testBuildEntityHandlesNullFields(): void
    {
        $entity = $this->service->buildEntity([
            'name'        => '商品X',
            'sku'         => '',
            'price'       => '',
            'stock'       => '',
            'category'    => '',
            'description' => '',
            'status'      => '',
        ]);

        $this->assertNull($entity->get('sku'));
        $this->assertNull($entity->get('price'));
        $this->assertFalse($entity->hasErrors(), 'オプション項目が空でもエラーにならないこと');
    }

    // ─────────────────────────────────────────────────────────────
    // buildTemplateCsv
    // ─────────────────────────────────────────────────────────────

    public function testBuildTemplateCsvContainsAllLabels(): void
    {
        $csv    = $this->service->buildTemplateCsv();
        $lines  = array_filter(explode("\n", trim($csv)));
        $header = str_getcsv(array_values($lines)[0]);

        $expectedLabels = array_map(fn($v) => $v['label'], $this->service->getColumnMap());
        $this->assertSame(array_values($expectedLabels), $header);
    }
}
