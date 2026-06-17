<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Image;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Image List Item
 *
 * Represents a single image entry returned in the images array by listImages.
 *
 * @link https://digistore24.com/api/docs/paths/listImages.yaml
 */
final class ImageListItem
{
    /**
     * @param string $id Unique image identifier (e.g. "05CZEP6G")
     * @param string $url Full image URI
     * @param string $fileExtension Image format (e.g. "png")
     * @param string $name Image name/label
     * @param string|null $approvalStatus Moderation state (e.g. "approved")
     * @param string|null $usageType Categorized purpose (e.g. "product")
     * @param string|null $altTag Accessibility text (nullable)
     * @param int|null $width Image width in pixels
     * @param int|null $height Image height in pixels
     */
    public function __construct(
        public readonly string $id,
        public readonly string $url,
        public readonly string $fileExtension,
        public readonly string $name,
        public readonly ?string $approvalStatus,
        public readonly ?string $usageType,
        public readonly ?string $altTag,
        public readonly ?int $width,
        public readonly ?int $height,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        return new self(
            id: TypeConverter::toString($data['id'] ?? '') ?? '',
            url: TypeConverter::toString($data['url'] ?? '') ?? '',
            fileExtension: TypeConverter::toString($data['file_extension'] ?? '') ?? '',
            name: TypeConverter::toString($data['name'] ?? '') ?? '',
            approvalStatus: TypeConverter::toString($data['approval_status'] ?? null),
            usageType: TypeConverter::toString($data['usage_type'] ?? null),
            altTag: TypeConverter::toString($data['alt_tag'] ?? null),
            width: TypeConverter::toInt($data['width'] ?? null),
            height: TypeConverter::toInt($data['height'] ?? null),
        );
    }
}
