<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Enum;

use GoSuccess\Digistore24\Api\Contract\StringBackedEnum;
use GoSuccess\Digistore24\Api\Trait\StringBackedEnumTrait;

/**
 * Delivery Tracking Operation
 *
 * Operation to perform on a tracking entry when calling updateDelivery.
 */
enum DeliveryTrackingOperation: string implements StringBackedEnum
{
    use StringBackedEnumTrait;

    case CREATE_OR_UPDATE = 'create_or_update';
    case DELETE = 'delete';

    public function label(): string
    {
        return match ($this) {
            self::CREATE_OR_UPDATE => 'Create or update',
            self::DELETE => 'Delete',
        };
    }
}
