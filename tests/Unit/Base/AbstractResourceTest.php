<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Base;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Base\AbstractResource;
use GoSuccess\Digistore24\Api\Contract\HttpClientInterface;
use GoSuccess\Digistore24\Api\Exception\ValidationException;
use GoSuccess\Digistore24\Api\Http\Response;
use PHPUnit\Framework\TestCase;

final class AbstractResourceTest extends TestCase
{
    public function test_execute_throws_validation_exception_for_invalid_request(): void
    {
        $client = $this->createMock(HttpClientInterface::class);
        $client->expects($this->never())->method('request');

        $resource = new class ($client) extends AbstractResource {
            public function run(AbstractRequest $request): Response
            {
                return $this->execute($request);
            }
        };

        $request = new class () extends AbstractRequest {
            public function getEndpoint(): string
            {
                return '/test';
            }

            public function validate(): array
            {
                return ['email' => ['Email is required']];
            }
        };

        try {
            $resource->run($request);
            $this->fail('Expected a ValidationException to be thrown.');
        } catch (ValidationException $exception) {
            $this->assertSame(['email' => ['Email is required']], $exception->getErrors());
            $this->assertSame(400, $exception->getCode());
        }
    }

    public function test_execute_sends_valid_request(): void
    {
        $client = $this->createMock(HttpClientInterface::class);
        $client->expects($this->once())
            ->method('request')
            ->willReturn(new Response(statusCode: 200, data: ['result' => 'success', 'data' => []]));

        $resource = new class ($client) extends AbstractResource {
            public function run(AbstractRequest $request): Response
            {
                return $this->execute($request);
            }
        };

        $request = new class () extends AbstractRequest {
            public function getEndpoint(): string
            {
                return '/test';
            }
        };

        $response = $resource->run($request);

        $this->assertSame(200, $response->statusCode);
    }
}
