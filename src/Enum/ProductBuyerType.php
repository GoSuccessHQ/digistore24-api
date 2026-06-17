<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Enum;

use GoSuccess\Digistore24\Api\Contract\StringBackedEnum;
use GoSuccess\Digistore24\Api\Trait\StringBackedEnumTrait;

/**
 * Product Buyer Type
 *
 * Buyer type accepted by createProduct and updateProduct: consumer (prices
 * include VAT) or business (prices exclude VAT). The broader BuyerType enum also
 * carries common/vendor, which these endpoints reject.
 */
enum ProductBuyerType: string implements StringBackedEnum
{
    use StringBackedEnumTrait;

    case CONSUMER = 'consumer';
    case BUSINESS = 'business';

    public function label(): string
    {
        return match ($this) {
            self::CONSUMER => 'Consumer',
            self::BUSINESS => 'Business',
        };
    }
}
