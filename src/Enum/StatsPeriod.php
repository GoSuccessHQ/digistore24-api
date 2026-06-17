<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Enum;

use GoSuccess\Digistore24\Api\Contract\StringBackedEnum;
use GoSuccess\Digistore24\Api\Trait\StringBackedEnumTrait;

/**
 * Stats Period
 *
 * Time period used to group sales statistics.
 *
 * @link https://digistore24.com/api/docs/paths/statsSales.yaml
 */
enum StatsPeriod: string implements StringBackedEnum
{
    use StringBackedEnumTrait;

    case DAY = 'day';
    case WEEK = 'week';
    case MONTH = 'month';
    case QUARTER = 'quarter';
    case YEAR = 'year';

    public function label(): string
    {
        return match ($this) {
            self::DAY => 'Day',
            self::WEEK => 'Week',
            self::MONTH => 'Month',
            self::QUARTER => 'Quarter',
            self::YEAR => 'Year',
        };
    }
}
