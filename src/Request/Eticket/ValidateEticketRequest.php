<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Eticket;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Validate E-Ticket Request
 *
 * Validates (scans) an e-ticket against a template/location and date.
 *
 * @link https://digistore24.com/api/docs/paths/validateEticket.yaml
 */
final class ValidateEticketRequest extends AbstractRequest
{
    /**
     * @param string $eticketId The e-ticket serial number or ID to validate
     * @param string $templateId Template ID or comma-separated list of template IDs
     * @param string $locationId Location ID or comma-separated list of location IDs
     * @param \DateTimeInterface|null $date Date(s) to validate against; defaults to "now"
     * @param string|null $seperator Separator character for response messages; defaults to " "
     */
    public function __construct(
        public readonly string $eticketId,
        public readonly string $templateId,
        public readonly string $locationId,
        public readonly ?\DateTimeInterface $date = null,
        public readonly ?string $seperator = null,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/validateEticket';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function toArray(): array
    {
        $data = [
            'eticket_id' => $this->eticketId,
            'template_id' => $this->templateId,
            'location_id' => $this->locationId,
        ];

        if ($this->date !== null) {
            $data['date'] = $this->date->format('Y-m-d');
        }

        if ($this->seperator !== null) {
            $data['seperator'] = $this->seperator;
        }

        return $data;
    }

    protected function rules(): array
    {
        return [
            'eticket_id' => 'required',
            'template_id' => 'required',
            'location_id' => 'required',
        ];
    }
}
