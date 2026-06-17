<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Eticket;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * List E-Tickets Request
 *
 * Lists e-tickets, optionally filtered through the `search` object. Every search
 * criterion the endpoint accepts is exposed as a constructor argument and is
 * emitted under the `search` key only when set.
 *
 * @link https://digistore24.com/api/docs/paths/listEtickets.yaml
 */
final class ListEticketsRequest extends AbstractRequest
{
    /**
     * @param string|null $ownerId Filter by e-ticket owner (account) ID
     * @param string|null $purchaseId Filter by purchase ID
     * @param string|null $firstName Filter by buyer first name
     * @param string|null $lastName Filter by buyer last name
     * @param string|null $email Filter by buyer email
     * @param string|null $templateId Filter by template ID
     * @param string|null $locationId Filter by location ID
     * @param \DateTimeInterface|null $date Filter by event date
     */
    public function __construct(
        public readonly ?string $ownerId = null,
        public readonly ?string $purchaseId = null,
        public readonly ?string $firstName = null,
        public readonly ?string $lastName = null,
        public readonly ?string $email = null,
        public readonly ?string $templateId = null,
        public readonly ?string $locationId = null,
        public readonly ?\DateTimeInterface $date = null,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/listEtickets';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function toArray(): array
    {
        $search = [];

        if ($this->ownerId !== null) {
            $search['owner_id'] = $this->ownerId;
        }
        if ($this->purchaseId !== null) {
            $search['purchase_id'] = $this->purchaseId;
        }
        if ($this->firstName !== null) {
            $search['first_name'] = $this->firstName;
        }
        if ($this->lastName !== null) {
            $search['last_name'] = $this->lastName;
        }
        if ($this->email !== null) {
            $search['email'] = $this->email;
        }
        if ($this->templateId !== null) {
            $search['template_id'] = $this->templateId;
        }
        if ($this->locationId !== null) {
            $search['location_id'] = $this->locationId;
        }
        if ($this->date !== null) {
            $search['date'] = $this->date->format('Y-m-d');
        }

        if ($search === []) {
            return [];
        }

        return ['search' => $search];
    }
}
