<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Enum;

use GoSuccess\Digistore24\Api\Contract\StringBackedEnum;
use GoSuccess\Digistore24\Api\Trait\StringBackedEnumTrait;

/**
 * API Permission Level
 *
 * Permission level requested when creating a new API key via requestApiKey.
 *
 * @link https://digistore24.com/api/docs/paths/requestApiKey.yaml
 */
enum ApiPermissionLevel: string implements StringBackedEnum
{
    use StringBackedEnumTrait;

    case READ_ONLY = 'read-only';
    case WRITABLE = 'writable';

    public function label(): string
    {
        return match ($this) {
            self::READ_ONLY => 'Read Only',
            self::WRITABLE => 'Writable',
        };
    }
}
