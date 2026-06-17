<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\PaymentPlan;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\PaymentPlan\UpdatePaymentplanResponse;
use PHPUnit\Framework\TestCase;

final class UpdatePaymentplanResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'result' => 'success',
            'data' => [
                'modified' => 'Y',
                'rendered_texts' => [
                    'headline' => 'Updated headline',
                ],
                'plan' => [
                    'id' => 555,
                ],
            ],
        ];
        $response = UpdatePaymentplanResponse::fromArray($data);

        $this->assertInstanceOf(UpdatePaymentplanResponse::class, $response);
        $this->assertSame('success', $response->result);
        $this->assertTrue($response->modified);
        $this->assertNotNull($response->renderedTexts);
        $this->assertSame('Updated headline', $response->renderedTexts->headline);
        $this->assertSame(555, $response->plan['id']);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'result' => 'success',
                'data' => [
                    'modified' => 'N',
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = UpdatePaymentplanResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(UpdatePaymentplanResponse::class, $response);
        $this->assertFalse($response->modified);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [],
            headers: [],
            rawBody: 'test',
        );

        $response = UpdatePaymentplanResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
