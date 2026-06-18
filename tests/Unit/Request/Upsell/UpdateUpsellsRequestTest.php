<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Request\Upsell;

use GoSuccess\Digistore24\Api\Request\Upsell\UpdateUpsellsRequest;
use PHPUnit\Framework\TestCase;

final class UpdateUpsellsRequestTest extends TestCase
{
    public function test_can_create_instance(): void
    {
        $request = new UpdateUpsellsRequest(productId: 12345, data: ['upsells' => [67890]]);

        $this->assertInstanceOf(UpdateUpsellsRequest::class, $request);
    }

    public function test_endpoint_returns_correct_value(): void
    {
        $request = new UpdateUpsellsRequest(productId: 12345, data: ['upsells' => [67890]]);

        $this->assertSame('/updateUpsells', $request->getEndpoint());
    }

    public function test_to_array_includes_product_id_and_data(): void
    {
        $request = new UpdateUpsellsRequest(productId: 12345, data: ['upsells' => [67890]]);

        $array = $request->toArray();
        $this->assertSame(12345, $array['product_id']);
        $data = $array['data'];
        $this->assertIsArray($data);
        $this->assertSame([67890], $data['upsells']);
    }

    public function test_validate_returns_empty_array(): void
    {
        $request = new UpdateUpsellsRequest(productId: 12345, data: ['upsells' => [67890]]);

        $errors = $request->validate();
        $this->assertEmpty($errors);
    }
}
