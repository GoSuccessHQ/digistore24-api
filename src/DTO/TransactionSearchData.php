<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Transaction Search Criteria Data
 *
 * Search filter criteria for transaction list queries. Used as the `search`
 * object of the listTransactions request.
 *
 * @link https://digistore24.com/api/docs/paths/listTransactions.yaml
 */
final class TransactionSearchData extends AbstractDataTransferObject
{
    /**
     * @param string|null $role Filter by role (vendor, affiliate, other - comma separated)
     * @param string|null $productId Filter by product IDs (comma separated)
     * @param string|null $firstName Filter by buyer first name
     * @param string|null $lastName Filter by buyer last name
     * @param string|null $email Filter by buyer email
     * @param bool|null $hasAffiliate Filter transactions with/without affiliate
     * @param string|null $affiliateName Filter by affiliate name
     * @param string|null $payMethod Filter by payment methods (comma separated)
     * @param string|null $billingType Filter by billing types (comma separated)
     * @param string|null $transactionType Filter by transaction types (payment, refund, chargeback, refund_request - comma separated)
     * @param string|null $currency Filter by currency
     * @param string|null $purchaseId Filter by purchase IDs (comma separated)
     */
    public function __construct(
        public ?string $role = null,
        public ?string $productId = null,
        public ?string $firstName = null,
        public ?string $lastName = null,
        public ?string $email = null,
        public ?bool $hasAffiliate = null,
        public ?string $affiliateName = null,
        public ?string $payMethod = null,
        public ?string $billingType = null,
        public ?string $transactionType = null,
        public ?string $currency = null,
        public ?string $purchaseId = null,
    ) {
    }

    public function toArray(): array
    {
        $data = [];

        if ($this->role !== null) {
            $data['role'] = $this->role;
        }
        if ($this->productId !== null) {
            $data['product_id'] = $this->productId;
        }
        if ($this->firstName !== null) {
            $data['first_name'] = $this->firstName;
        }
        if ($this->lastName !== null) {
            $data['last_name'] = $this->lastName;
        }
        if ($this->email !== null) {
            $data['email'] = $this->email;
        }
        if ($this->hasAffiliate !== null) {
            $data['has_affiliate'] = TypeConverter::fromBool($this->hasAffiliate);
        }
        if ($this->affiliateName !== null) {
            $data['affiliate_name'] = $this->affiliateName;
        }
        if ($this->payMethod !== null) {
            $data['pay_method'] = $this->payMethod;
        }
        if ($this->billingType !== null) {
            $data['billing_type'] = $this->billingType;
        }
        if ($this->transactionType !== null) {
            $data['transaction_type'] = $this->transactionType;
        }
        if ($this->currency !== null) {
            $data['currency'] = $this->currency;
        }
        if ($this->purchaseId !== null) {
            $data['purchase_id'] = $this->purchaseId;
        }

        return $data;
    }
}
