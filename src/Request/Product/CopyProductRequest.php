<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Product;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Request to copy an existing product
 *
 * @link https://digistore24.com/api/docs/paths/copyProduct.yaml OpenAPI Specification
 */
final class CopyProductRequest extends AbstractRequest
{
    /**
     * @param int $productId The ID of the product to be copied
     * @param string|null $nameIntern Internal product name (max 63 chars)
     * @param int|null $productTypeId Product type ID (from getGlobalSettings)
     * @param string|null $language Comma separated list of languages (e.g. "en,de")
     * @param bool|null $isActive Product activation status
     * @param int|null $productGroupId Product group ID
     * @param string|null $nameDe German product name (max 63 chars)
     * @param string|null $nameEn English product name (max 63 chars)
     * @param string|null $nameEs Spanish product name (max 63 chars)
     * @param string|null $nameFr French product name (max 63 chars)
     * @param string|null $namePt Portuguese product name (max 63 chars)
     * @param string|null $namePl Polish product name (max 63 chars)
     * @param string|null $nameIt Italian product name (max 63 chars)
     * @param string|null $nameNl Dutch product name (max 63 chars)
     * @param string|null $nameSl Slovenian product name (max 63 chars)
     */
    public function __construct(
        public int $productId,
        public ?string $nameIntern = null,
        public ?int $productTypeId = null,
        public ?string $language = null,
        public ?bool $isActive = null,
        public ?int $productGroupId = null,
        public ?string $nameDe = null,
        public ?string $nameEn = null,
        public ?string $nameEs = null,
        public ?string $nameFr = null,
        public ?string $namePt = null,
        public ?string $namePl = null,
        public ?string $nameIt = null,
        public ?string $nameNl = null,
        public ?string $nameSl = null,
    ) {
    }

    public function toArray(): array
    {
        $data = [
            'product_id' => (string)$this->productId,
        ];

        if ($this->nameIntern !== null) {
            $data['name_intern'] = $this->nameIntern;
        }
        if ($this->productTypeId !== null) {
            $data['product_type_id'] = $this->productTypeId;
        }
        if ($this->language !== null) {
            $data['language'] = $this->language;
        }
        if ($this->isActive !== null) {
            $data['is_active'] = TypeConverter::fromBool($this->isActive);
        }
        if ($this->productGroupId !== null) {
            $data['product_group_id'] = $this->productGroupId;
        }
        if ($this->nameDe !== null) {
            $data['name_de'] = $this->nameDe;
        }
        if ($this->nameEn !== null) {
            $data['name_en'] = $this->nameEn;
        }
        if ($this->nameEs !== null) {
            $data['name_es'] = $this->nameEs;
        }
        if ($this->nameFr !== null) {
            $data['name_fr'] = $this->nameFr;
        }
        if ($this->namePt !== null) {
            $data['name_pt'] = $this->namePt;
        }
        if ($this->namePl !== null) {
            $data['name_pl'] = $this->namePl;
        }
        if ($this->nameIt !== null) {
            $data['name_it'] = $this->nameIt;
        }
        if ($this->nameNl !== null) {
            $data['name_nl'] = $this->nameNl;
        }
        if ($this->nameSl !== null) {
            $data['name_sl'] = $this->nameSl;
        }

        return $data;
    }

    public function getEndpoint(): string
    {
        return '/copyProduct';
    }
}
