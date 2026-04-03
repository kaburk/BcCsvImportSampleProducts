<?php
declare(strict_types=1);

namespace BcCsvImportSampleProducts\Model\Entity;

use Cake\ORM\Entity;

/**
 * BcSampleProduct Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $sku
 * @property int|null $price
 * @property int|null $stock
 * @property string|null $category
 * @property string|null $description
 * @property bool|null $status
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 */
class BcSampleProduct extends Entity
{

    /**
     * Accessible
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        '*' => true,
        'id' => false,
    ];

}