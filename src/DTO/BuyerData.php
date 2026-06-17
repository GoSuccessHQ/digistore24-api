<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use DateTimeImmutable;
use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;
use GoSuccess\Digistore24\Api\Enum\BuyerReadonlyKeys;
use GoSuccess\Digistore24\Api\Enum\BuyerType;
use GoSuccess\Digistore24\Api\Enum\Salutation;
use GoSuccess\Digistore24\Api\Util\Validator;

/**
 * Buyer Data Transfer Object
 *
 * Represents buyer information for API requests and responses.
 * Uses PHP 8.4 property hooks for automatic validation.
 *
 * Response usage (getBuyer / listBuyers): every field of the spec's buyer object
 * is exposed, including the response-only fields (id, address_id, salutation_msg,
 * street_name, street_number, street2, buyer_type, created_at).
 *
 * Request usage (createBuyUrl `buyer` object): only the fields the spec accepts as
 * input are emitted by {@see self::toArray()} (id, email, salutation, title,
 * first_name, last_name, company, street, city, zipcode, state, country, phone_no,
 * tax_id, readonly_keys). The response-only fields above are intentionally excluded
 * so they never leak into a request payload.
 *
 * @link https://digistore24.com/api/docs/paths/getBuyer.yaml
 * @link https://digistore24.com/api/docs/paths/listBuyers.yaml
 * @link https://digistore24.com/api/docs/paths/createBuyUrl.yaml
 */
final class BuyerData extends AbstractDataTransferObject
{
    /**
     * Buyer ID
     */
    public ?int $id {
        get => $this->id;
    }

    /**
     * Address ID (response-only)
     */
    public ?int $addressId {
        get => $this->addressId;
    }

    /**
     * Email address
     */
    public string $email {
        get => $this->email;
        set {
            if ($value !== '' && ! Validator::isEmail($value)) {
                throw new \InvalidArgumentException('Invalid email format');
            }
            $this->email = $value;
        }
    }

    /**
     * Salutation (enum)
     */
    public ?Salutation $salutation {
        get => $this->salutation;
    }

    /**
     * Salutation message (response-only)
     */
    public ?string $salutationMsg {
        get => $this->salutationMsg;
    }

    /**
     * Title (e.g., Dr., Prof.)
     */
    public ?string $title {
        get => $this->title;
    }

    /**
     * First name
     */
    public ?string $firstName {
        get => $this->firstName;
    }

    /**
     * Last name
     */
    public ?string $lastName {
        get => $this->lastName;
    }

    /**
     * Company name
     */
    public ?string $company {
        get => $this->company;
    }

    /**
     * Full street address
     */
    public ?string $street {
        get => $this->street;
    }

    /**
     * Street name without number (response-only)
     */
    public ?string $streetName {
        get => $this->streetName;
    }

    /**
     * Street number (response-only)
     */
    public ?string $streetNumber {
        get => $this->streetNumber;
    }

    /**
     * Additional address line (response-only)
     */
    public ?string $street2 {
        get => $this->street2;
    }

    /**
     * City
     */
    public ?string $city {
        get => $this->city;
    }

    /**
     * ZIP/Postal code
     */
    public ?string $zipcode {
        get => $this->zipcode;
    }

    /**
     * State/Province
     */
    public ?string $state {
        get => $this->state;
    }

    /**
     * Country code (ISO 3166-1 alpha-2)
     */
    public ?string $country {
        get => $this->country;
    }

    /**
     * Phone number
     */
    public ?string $phoneNo {
        get => $this->phoneNo;
    }

    /**
     * Tax ID
     */
    public ?string $taxId {
        get => $this->taxId;
    }

    /**
     * Buyer type (business, consumer, common, vendor) (response-only)
     */
    public ?BuyerType $buyerType {
        get => $this->buyerType;
    }

    /**
     * Creation timestamp (response-only)
     */
    public ?DateTimeImmutable $createdAt {
        get => $this->createdAt;
    }

    /**
     * Which prefilled buyer fields the customer may not change on the order form.
     *
     * Request-only field used by createBuyUrl (`buyer.readonly_keys`).
     */
    public ?BuyerReadonlyKeys $readonlyKeys {
        get => $this->readonlyKeys;
    }

    public function __construct(
        ?int $id = null,
        ?int $addressId = null,
        string $email = '',
        ?Salutation $salutation = null,
        ?string $salutationMsg = null,
        ?string $title = null,
        ?string $firstName = null,
        ?string $lastName = null,
        ?string $company = null,
        ?string $street = null,
        ?string $streetName = null,
        ?string $streetNumber = null,
        ?string $street2 = null,
        ?string $city = null,
        ?string $zipcode = null,
        ?string $state = null,
        ?string $country = null,
        ?string $phoneNo = null,
        ?string $taxId = null,
        ?BuyerType $buyerType = null,
        ?DateTimeImmutable $createdAt = null,
        ?BuyerReadonlyKeys $readonlyKeys = null,
    ) {
        $this->id = $id;
        $this->addressId = $addressId;
        $this->email = $email;
        $this->salutation = $salutation;
        $this->salutationMsg = $salutationMsg;
        $this->title = $title;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->company = $company;
        $this->street = $street;
        $this->streetName = $streetName;
        $this->streetNumber = $streetNumber;
        $this->street2 = $street2;
        $this->city = $city;
        $this->zipcode = $zipcode;
        $this->state = $state;
        $this->country = $country;
        $this->phoneNo = $phoneNo;
        $this->taxId = $taxId;
        $this->buyerType = $buyerType;
        $this->createdAt = $createdAt;
        $this->readonlyKeys = $readonlyKeys;
    }

    /**
     * Convert to array for the createBuyUrl `buyer` request object.
     *
     * Only the spec's input fields are emitted; the response-only fields
     * (address_id, salutation_msg, street_name, street_number, street2,
     * buyer_type, created_at) are intentionally excluded so they never leak
     * into a request payload. null values are skipped.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [];

        if ($this->id !== null) {
            $data['id'] = $this->id;
        }
        if ($this->email !== '') {
            $data['email'] = $this->email;
        }
        if ($this->salutation !== null) {
            $data['salutation'] = $this->salutation->value;
        }
        if ($this->title !== null) {
            $data['title'] = $this->title;
        }
        if ($this->firstName !== null) {
            $data['first_name'] = $this->firstName;
        }
        if ($this->lastName !== null) {
            $data['last_name'] = $this->lastName;
        }
        if ($this->company !== null) {
            $data['company'] = $this->company;
        }
        if ($this->street !== null) {
            $data['street'] = $this->street;
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
        if ($this->phoneNo !== null) {
            $data['phone_no'] = $this->phoneNo;
        }
        if ($this->taxId !== null) {
            $data['tax_id'] = $this->taxId;
        }
        if ($this->readonlyKeys !== null) {
            $data['readonly_keys'] = $this->readonlyKeys->value;
        }

        return $data;
    }
}
