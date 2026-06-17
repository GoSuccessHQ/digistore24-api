<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Eticket;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * List E-Ticket Templates Response
 *
 * Response containing a list of e-ticket templates.
 */
final class ListEticketTemplatesResponse extends AbstractResponse
{
    public string $result = '';

    /** @var array<EticketTemplate> Array of e-ticket templates */
    public array $templates = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $templates = [];

        if (isset($data['templates']) && is_array($data['templates'])) {
            foreach ($data['templates'] as $template) {
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
