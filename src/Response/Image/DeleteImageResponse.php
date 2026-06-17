<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Image;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Delete Image Response
 *
 * Response after deleting an image.
 */
final class DeleteImageResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * Whether deletion was successful
     */
    public bool $success = true;

    /**
     * ID of the deleted image
     */
    public string $imageId = '';

    /**
     * Optional message
     */
    public ?string $message = null;

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->success = TypeConverter::toBool($innerData['success'] ?? true) ?? true;
        $response->imageId = TypeConverter::toString($innerData['image_id'] ?? '') ?? '';
        $response->message = isset($innerData['message']) ? TypeConverter::toString($innerData['message']) : null;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
