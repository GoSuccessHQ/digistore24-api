<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use DateTimeImmutable;
use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;
use GoSuccess\Digistore24\Api\Enum\BuyerType;
use GoSuccess\Digistore24\Api\Enum\Salutation;
use GoSuccess\Digistore24\Api\Util\Validator;

/**
 * Buyer Data Transfer Object
 *
 * Represents buyer information for API requests and responses.
 * Uses PHP 8.4 property hooks for automatic validation.
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
     * Address ID
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
     * Salutation message
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
     * Street name (without number)
     */
    public ?string $streetName {
        get => $this->streetName;
    }

    /**
     * Street number
     */
    public ?string $streetNumber {
        get => $this->streetNumber;
    }

    /**
     * Additional address line
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
     * Buyer type (business, consumer, common, vendor)
     */
    public ?BuyerType $buyerType {
        get => $this->buyerType;
    }

    /**
     * Creation timestamp
     */
    public ?DateTimeImmutable $createdAt {
        get => $this->createdAt;
    }

    /**
     * Readonly keys (comma-separated)
     */
    public ?string $readonlyKeys {
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
        ?string $readonlyKeys = null,
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
}
