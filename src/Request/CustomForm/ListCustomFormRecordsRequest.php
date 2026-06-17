<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\CustomForm;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Request to list custom form records.
 *
 * Returns a list with data from additional input fields collected
 * during the checkout process.
 *
 * @see https://digistore24.com/api/docs/paths/listCustomFormRecords.yaml
 */
final class ListCustomFormRecordsRequest extends AbstractRequest
{
    /**
     * @param string|null $purchaseId Optional purchase ID to filter records
     */
    public function __construct(
        private ?string $purchaseId = null,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/listCustomFormRecords';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function toArray(): array
    {
        $params = [];

        if ($this->purchaseId !== null) {
            $params['purchase_id'] = $this->purchaseId;
        }

        return $params;
    }
}
