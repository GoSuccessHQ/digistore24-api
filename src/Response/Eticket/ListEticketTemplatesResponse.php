<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Eticket;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * List E-Ticket Templates Response
 *
 * Response containing a list of e-ticket templates. The API returns an array of
 * template objects directly.
 *
 * @link https://digistore24.com/api/docs/paths/listEticketTemplates.yaml
 */
final class ListEticketTemplatesResponse extends AbstractResponse
{
    public string $result = '';

    /** @var array<int, EticketTemplate> Array of e-ticket templates */
    public array $templates = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        // The API returns a bare array of templates. Support a `templates`
        // wrapper too for forward compatibility and direct fromArray() calls.
        $items = $data['templates'] ?? $data;
        $templates = [];

        if (is_array($items)) {
            foreach ($items as $template) {
                if (! is_array($template)) {
                    continue;
                }
                /** @var array<string, mixed> $validatedTemplate */
                $validatedTemplate = $template;
                $templates[] = EticketTemplate::fromArray($validatedTemplate);
            }
        }

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->templates = $templates;
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
