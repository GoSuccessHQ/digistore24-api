<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\BuyUrl;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Delete Buy URL Request
 *
 * Deletes a previously generated buy URL.
 *
 * @link https://digistore24.com/api/docs/paths/deleteBuyUrl.yaml
 */
final class DeleteBuyUrlRequest extends AbstractRequest
{
    /**
     * @param int $id Buy URL ID to delete
     */
    public function __construct(
        public int $id,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/deleteBuyUrl';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::DELETE;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
        ];
    }

    /**
     * @return array<string, array<string>>
     */
    public function validate(): array
    {
        $errors = [];

        if ($this->id <= 0) {
            $errors['id'] = ['Buy URL ID must be greater than 0'];
        }

        return $errors;
    }
}
