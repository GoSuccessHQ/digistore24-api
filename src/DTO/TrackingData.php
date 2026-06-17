<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;
use GoSuccess\Digistore24\Api\Enum\AffiliatePriority;
use GoSuccess\Digistore24\Api\Util\ArrayHelper;
use GoSuccess\Digistore24\Api\Util\Validator;

/**
 * Tracking Data Transfer Object
 *
 * Represents the createBuyUrl `tracking` object. Every parameter the spec defines
 * for that object is exposed: custom, affiliate, affiliate_priority, campaignkey,
 * trackingkey and the five utm_* parameters.
 *
 * The thankyou/cancellation/billing-failure URLs and the ga_tid / fb_pixel_id
 * tracking-pixel fields are retained for convenience even though they are not part
 * of the createBuyUrl tracking object; they are emitted as-is when set.
 *
 * Uses PHP 8.4 property hooks for automatic validation.
 *
 * @link https://digistore24.com/api/docs/paths/createBuyUrl.yaml
 */
final class TrackingData extends AbstractDataTransferObject
{
    /**
     * Custom tracking value
     */
    public ?string $custom = null;

    /**
     * Affiliate partner identifier
     */
    public ?string $affiliate = null;

    /**
     * How the affiliate passed here is prioritized against an affiliate the buyer
     * is already linked to (enum: email, as_set).
     */
    public ?AffiliatePriority $affiliatePriority = null;

    /**
     * Campaign key for tracking
     */
    public ?string $campaignkey = null;

    /**
     * Tracking key identifier
     */
    public ?string $trackingkey = null;

    /**
     * UTM Source parameter
     */
    public ?string $utmSource = null;

    /**
     * UTM Medium parameter
     */
    public ?string $utmMedium = null;

    /**
     * UTM Campaign parameter
     */
    public ?string $utmCampaign = null;

    /**
     * UTM Term parameter
     */
    public ?string $utmTerm = null;

    /**
     * UTM Content parameter
     */
    public ?string $utmContent = null;

    /**
     * Thank you page URL (not part of the createBuyUrl tracking object)
     */
    public ?string $thankyou_url = null {
        set {
            if ($value !== null && ! Validator::isUrl($value)) {
                throw new \InvalidArgumentException('Thank you URL must be a valid URL');
            }
            $this->thankyou_url = $value;
        }
    }

    /**
     * Cancellation URL (not part of the createBuyUrl tracking object)
     */
    public ?string $cancellation_url = null {
        set {
            if ($value !== null && ! Validator::isUrl($value)) {
                throw new \InvalidArgumentException('Cancellation URL must be a valid URL');
            }
            $this->cancellation_url = $value;
        }
    }

    /**
     * Billing failure URL (not part of the createBuyUrl tracking object)
     */
    public ?string $billing_failure_url = null {
        set {
            if ($value !== null && ! Validator::isUrl($value)) {
                throw new \InvalidArgumentException('Billing failure URL must be a valid URL');
            }
            $this->billing_failure_url = $value;
        }
    }

    /**
     * Google Analytics Tracking ID (not part of the createBuyUrl tracking object)
     */
    public ?string $ga_tid = null {
        set {
            if ($value !== null && ! preg_match('/^(UA|G|GT|AW)-/', $value)) {
                throw new \InvalidArgumentException('Google Analytics Tracking ID must start with UA-, G-, GT-, or AW-');
            }
            $this->ga_tid = $value;
        }
    }

    /**
     * Facebook Pixel ID (not part of the createBuyUrl tracking object)
     */
    public ?string $fb_pixel_id = null {
        set {
            if ($value !== null && ! preg_match('/^\d+$/', $value)) {
                throw new \InvalidArgumentException('Facebook Pixel ID must be numeric');
            }
            $this->fb_pixel_id = $value;
        }
    }

    /**
     * Convert to array for API request.
     *
     * Property names are converted to snake_case, null values are skipped and
     * enums are reduced to their backing value.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [];

        foreach (get_object_vars($this) as $property => $value) {
            if ($value === null) {
                continue;
            }

            if ($value instanceof \BackedEnum) {
                $value = $value->value;
            }

            $data[ArrayHelper::toSnakeCase((string)$property)] = $value;
        }

        return $data;
    }
}
