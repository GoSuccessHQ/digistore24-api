<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Buyer;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;
use GoSuccess\Digistore24\Api\Enum\Salutation;

/**
 * Update Buyer Request
 *
 * Updates a buyer's contact details. Every field except the buyer ID is optional;
 * only the fields that are provided are sent to the API. The spec uses flat
 * address fields (street_name, street_number, city, ...), not a nested object.
 *
 * @link https://digistore24.com/api/docs/paths/updateBuyer.yaml
 */
final class UpdateBuyerRequest extends AbstractRequest
{
    /**
     * @param string $buyerId The buyer ID, as returned by e.g. getPurchase
     * @param string|null $email New email address
     * @param string|null $firstName New first name
     * @param string|null $lastName New last name
     * @param Salutation|null $salutation New salutation (M, F or none)
     * @param string|null $title New title
     * @param string|null $company New company name
     * @param string|null $streetName New street name
     * @param string|null $streetNumber New street number
     * @param string|null $phoneNumber New phone number (pass an empty string to clear it)
     * @param string|null $city New city
     * @param string|null $zipcode New ZIP/postal code
     * @param string|null $state New state/province
     * @param string|null $country New two-letter ISO country code (e.g. DE or AT)
     */
    public function __construct(
        private string $buyerId,
        private ?string $email = null,
        private ?string $firstName = null,
        private ?string $lastName = null,
        private ?Salutation $salutation = null,
        private ?string $title = null,
        private ?string $company = null,
        private ?string $streetName = null,
        private ?string $streetNumber = null,
        private ?string $phoneNumber = null,
        private ?string $city = null,
        private ?string $zipcode = null,
        private ?string $state = null,
        private ?string $country = null,
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
        // buyer_id stays flat (query param); the editable fields go under data[] --
        // sent flat the update is silently ignored (modified:N). Verified live.
        $data = [];

        if ($this->email !== null) {
            $data['email'] = $this->email;
        }
        if ($this->firstName !== null) {
            $data['first_name'] = $this->firstName;
        }
        if ($this->lastName !== null) {
            $data['last_name'] = $this->lastName;
        }
        if ($this->salutation !== null) {
            $data['salutation'] = $this->salutation->value;
        }
        if ($this->title !== null) {
            $data['title'] = $this->title;
        }
        if ($this->company !== null) {
            $data['company'] = $this->company;
        }
        if ($this->streetName !== null) {
            $data['street_name'] = $this->streetName;
        }
        if ($this->streetNumber !== null) {
            $data['street_number'] = $this->streetNumber;
        }
        if ($this->phoneNumber !== null) {
            $data['phone_number'] = $this->phoneNumber;
        }
        if ($this->city !== null) {
            $data['city'] = $this->city;
        }
        if ($this->zipcode !== null) {
            $data['zipcode'] = $this->zipcode;
        }
        if ($this->state !== null) {
            $data['state'] = $this->state;
        }
        if ($this->country !== null) {
            $data['country'] = $this->country;
        }

        return ['buyer_id' => $this->buyerId, 'data' => $data];
    }
}
