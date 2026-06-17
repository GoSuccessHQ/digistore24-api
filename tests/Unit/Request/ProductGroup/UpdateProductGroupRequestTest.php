<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Request\ProductGroup;

use GoSuccess\Digistore24\Api\DTO\ProductGroupData;
use GoSuccess\Digistore24\Api\Request\ProductGroup\UpdateProductGroupRequest;
use PHPUnit\Framework\TestCase;

final class UpdateProductGroupRequestTest extends TestCase
{
    public function test_can_create_instance(): void
    {
        $group = new ProductGroupData();
        $group->name = 'Updated Group';

        $request = new UpdateProductGroupRequest(
            productGroupId: 'PG123',
            productGroup: $group,
        );

        $this->assertInstanceOf(UpdateProductGroupRequest::class, $request);
    }

    public function test_endpoint_returns_correct_value(): void
    {
        $group = new ProductGroupData();
        $group->name = 'Updated Group';

        $request = new UpdateProductGroupRequest(
            productGroupId: 'PG123',
            productGroup: $group,
        );

        $this->assertSame('/updateProductGroup', $request->getEndpoint());
    }

    public function test_to_array_includes_product_group_id_and_data(): void
    {
        $group = new ProductGroupData();
        $group->name = 'Updated Group';

        $request = new UpdateProductGroupRequest(
            productGroupId: 'PG123',
            productGroup: $group,
        );

        $array = $request->toArray();
        $this->assertSame('PG123', $array['product_group_id']);
        $data = $array['data'];
        $this->assertIsArray($data);
        $this->assertSame('Updated Group', $data['name']);
    }

    public function test_validate_returns_empty_array(): void
    {
        $group = new ProductGroupData();
        $group->name = 'Updated Group';

        $request = new UpdateProductGroupRequest(
            productGroupId: 'PG123',
            productGroup: $group,
        );

        $errors = $request->validate();
        $this->assertEmpty($errors);
    }
}
