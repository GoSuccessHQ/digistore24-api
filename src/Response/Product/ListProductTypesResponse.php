<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Product;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Response containing list of available product types.
 *
 * Returns an array of product type objects, each containing:
 * - id: Product type ID (integer)
 * - name: Product type name (string)
 * - category: Product type category (string)
 *
 * @see https://digistore24.com/api/docs/paths/listProductTypes.yaml
 */
final class ListProductTypesResponse extends AbstractResponse
{
    public string $result = '';

    /** @var array<int, object{id: int, name: string, category: string}> */
    public array $productTypes = [];

    /**
     * Get a specific product type by ID.
     *
     * @param int $id Product type ID
     * @return object{id: int, name: string, category: string}|null Product type object or null if not found
     */
    public function getProductTypeById(int $id): ?object
    {
        foreach ($this->productTypes as $type) {
            if ($type->id === $id) {
                return $type;
            }
        }

        return null;
    }

    /**
     * Get all product types in a specific category.
     *
     * @param string $category Category name
     * @return array<int, object{id: int, name: string, category: string}>
     */
    public function getProductTypesByCategory(string $category): array
    {
        return array_filter(
            $this->productTypes,
            fn ($type) => $type->category === $category,
        );
    }

    /**
     * Get unique categories from all product types.
     *
     * @return array<int, string>
     */
    public function getCategories(): array
    {
        $categories = array_map(fn ($type) => $type->category, $this->productTypes);

        return array_values(array_unique($categories));
    }

    /**
     * {@inheritDoc}
     */
    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        // API returns array of product type objects directly
        $productTypes = [];

        // Check if $data is an indexed array (list of product types)
        // or an associative array (wrapped response)
        $items = $data;
        if (isset($data['data']) && is_array($data['data'])) {
            $items = $data['data'];
        }

        foreach ($items as $item) {
            if (! is_array($item)) {
                continue;
            }
            $id = $item['id'] ?? 0;
            $name = $item['name'] ?? '';
            $category = $item['category'] ?? '';

            $productTypes[] = (object)[
                'id' => TypeConverter::toInt($id) ?? 0,
                'name' => TypeConverter::toString($name) ?? '',
                'category' => TypeConverter::toString($category) ?? '',
            ];
        }

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->productTypes = $productTypes;
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
