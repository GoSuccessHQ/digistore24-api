<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Eticket;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Get E-Ticket Settings Response
 *
 * Response containing e-ticket configuration settings.
 */
final class GetEticketSettingsResponse extends AbstractResponse
{
    public string $result = '';

    public bool $eticketEnabled = false;

    public ?string $defaultLocationId = null;

    public ?string $defaultTemplateId = null;

    public int $maxTicketsPerOrder = 10;

    public bool $requireEmailValidation = false;

    /** @var array<string, mixed> */
    public array $settings = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $defaultLocationId = $data['default_location_id'] ?? null;
        $defaultTemplateId = $data['default_template_id'] ?? null;
        $maxTicketsPerOrder = $data['max_tickets_per_order'] ?? 10;
        $settings = $data['settings'] ?? [];
        if (! is_array($settings)) {
            $settings = [];
        }
        /** @var array<string, mixed> $validatedSettings */
        $validatedSettings = $settings;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->eticketEnabled = TypeConverter::toBool($data['eticket_enabled'] ?? false) ?? false;
        $response->defaultLocationId = $defaultLocationId !== null ? TypeConverter::toString($defaultLocationId) : null;
        $response->defaultTemplateId = $defaultTemplateId !== null ? TypeConverter::toString($defaultTemplateId) : null;
        $response->maxTicketsPerOrder = TypeConverter::toInt($maxTicketsPerOrder) ?? 10;
        $response->requireEmailValidation = TypeConverter::toBool($data['require_email_validation'] ?? false) ?? false;
        $response->settings = $validatedSettings;
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
