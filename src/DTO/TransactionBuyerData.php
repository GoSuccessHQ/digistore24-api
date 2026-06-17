<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;

/**
 * Transaction Buyer Data
 *
 * The `buyer` sub-object of a single `transaction_list` entry returned by
 * listTransactions. Holds the minimal buyer identity carried with each
 * transaction. Response-only DTO: all fields use get-only property hooks.
 *
 * @link https://digistore24.com/api/docs/paths/listTransactions.yaml
 */
final class TransactionBuyerData extends AbstractDataTransferObject
{
    /**
     * Buyer ID.
     */
    public ?int $id = null {
        get => $this->id;
    }

    /**
     * Buyer email address.
     */
    public ?string $email = null {
        get => $this->email;
    }

    /**
     * Buyer first name.
     */
    public ?string $firstName = null {
        get => $this->firstName;
    }

    /**
     * Buyer last name.
     */
    public ?string $lastName = null {
        get => $this->lastName;
    }
}
