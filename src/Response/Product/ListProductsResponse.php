<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Product;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * List Products Response
 *
 * Response containing a list of products.
 */
final class ListProductsResponse extends AbstractResponse
{
    public string $result = '';

    /** @var array<ProductListItem> Array of product list items */
    public array $products = [];

    /** Total number of products */
    public int $totalCount = 0;

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $products = [];

        if (isset($data['products']) && is_array($data['products'])) {
            foreach ($data['products'] as $product) {
                if (! is_array($product)) {
                    continue;
                }
                /** @var array<string, mixed> $validatedProduct */
                $validatedProduct = $product;
                $products[] = ProductListItem::fromArray($validatedProduct);
            }
        }

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->products = $products;
        $response->totalCount = count($products); // DS24 API doesn't return total_count, so we count the array
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
