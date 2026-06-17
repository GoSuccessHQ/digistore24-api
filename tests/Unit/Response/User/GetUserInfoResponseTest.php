<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\User;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\User\GetUserInfoResponse;
use PHPUnit\Framework\TestCase;

final class GetUserInfoResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'data' => [
                'user_id' => 12345,
                'user_name' => 'john.vendor',
                'granted_roles' => 'user,affiliate,merchant',
                'granted_roles_msg' => 'User,Affiliate,Vendor',
            ],
        ];
        $response = GetUserInfoResponse::fromArray($data);

        $this->assertInstanceOf(GetUserInfoResponse::class, $response);
        $this->assertSame(12345, $response->userId);
        $this->assertSame('john.vendor', $response->userName);
        $this->assertSame('user,affiliate,merchant', $response->grantedRoles);
        $this->assertSame('User,Affiliate,Vendor', $response->grantedRolesMsg);
        $this->assertSame(12345, $response->userInfo['user_id']);
    }

    public function test_coerces_string_user_id(): void
    {
        $data = [
            'data' => [
                'user_id' => '67890',
                'user_name' => 'jane.vendor',
            ],
        ];
        $response = GetUserInfoResponse::fromArray($data);

        $this->assertSame(67890, $response->userId);
        $this->assertSame('jane.vendor', $response->userName);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    'user_id' => 67890,
                    'user_name' => 'jane.vendor',
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = GetUserInfoResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(GetUserInfoResponse::class, $response);
        $this->assertSame(67890, $response->userId);
        $this->assertSame('jane.vendor', $response->userName);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    'user_id' => 11111,
                ],
            ],
            headers: [],
            rawBody: 'test',
        );

        $response = GetUserInfoResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
