<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;

/**
 * Payment Plan Rendered Texts Data Transfer Object
 *
 * The display texts returned for the order form by createPaymentplan /
 * updatePaymentplan under the `rendered_texts` key. Response-only, read-only.
 *
 * @link https://digistore24.com/api/docs/paths/createPaymentplan.yaml
 * @link https://digistore24.com/api/docs/paths/updatePaymentplan.yaml
 */
final class PaymentPlanRenderedTextsData extends AbstractDataTransferObject
{
    /**
     * Rendered headline for the order form
     */
    public ?string $headline {
        get => $this->headline;
    }

    /**
     * Rendered description for the order form
     */
    public ?string $description {
        get => $this->description;
    }

    /**
     * Rendered footnote for the order form
     */
    public ?string $footnote {
        get => $this->footnote;
    }

    public function __construct(
        ?string $headline = null,
        ?string $description = null,
        ?string $footnote = null,
    ) {
        $this->headline = $headline;
        $this->description = $description;
        $this->footnote = $footnote;
    }
}
