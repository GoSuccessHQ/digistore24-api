<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Buyer;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Update Buyer Request
 *
 * Updates buyer information such as email, name, and address.
 */
final class UpdateBuyerRequest extends AbstractRequest
{
    /**
     * @param string $buyerId The buyer ID
     * @param string|null $email New email address
     * @param string|null $firstName New first name
     * @param string|null $lastName New last name
     * @param array<string, mixed>|null $address New address data
     */
    public function __construct(
        private string $buyerId,
        private ?string $email = null,
        private ?string $firstName = null,
        private ?string $lastName = null,
        private ?array $address = null,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/updateBuyer';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::PUT;
    }

    public function toArray(): array
    {
        $params = ['buyer_id' => $this->buyerId];
        if ($this->email !== null) {
            $params['email'] = $this->email;
        }
        if ($this->firstName !== null) {
            $params['first_name'] = $this->firstName;
        }
        if ($this->lastName !== null) {
            $params['last_name'] = $this->lastName;
        }
        if ($this->address !== null) {
            $params['address'] = $this->address;
        }

        return $params;
    }
}
