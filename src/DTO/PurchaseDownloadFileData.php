<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;

/**
 * Purchase Download File Data
 *
 * A single downloadable file entry returned by getPurchaseDownloads. The
 * response groups these by purchase ID and product ID. Response-only DTO: all
 * fields use get-only property hooks.
 *
 * @link https://digistore24.com/api/docs/paths/getPurchaseDownloads.yaml
 */
final class PurchaseDownloadFileData extends AbstractDataTransferObject
{
    /**
     * Download URL for the file
     */
    public ?string $url = null {
        get => $this->url;
    }

    /**
     * Maximum number of allowed downloads
     */
    public ?int $downloadsTotal = null {
        get => $this->downloadsTotal;
    }

    /**
     * Number of download attempts made
     */
    public ?int $downloadsTries = null {
        get => $this->downloadsTries;
    }

    /**
     * Whether access is granted to download (response value is the Y/N enum, exposed as bool)
     */
    public ?bool $isAccessGranted = null {
        get => $this->isAccessGranted;
    }

    /**
     * Whether the purchase has been paid (response value is the Y/N enum, exposed as bool)
     */
    public ?bool $isPurchasePaid = null {
        get => $this->isPurchasePaid;
    }

    /**
     * Optional headline for the download
     */
    public ?string $headline = null {
        get => $this->headline;
    }

    /**
     * Optional download instructions
     */
    public ?string $instructions = null {
        get => $this->instructions;
    }

    /**
     * Name of the file
     */
    public ?string $fileName = null {
        get => $this->fileName;
    }

    /**
     * File extension
     */
    public ?string $fileExt = null {
        get => $this->fileExt;
    }

    /**
     * Size of file in bytes
     */
    public ?int $fileSize = null {
        get => $this->fileSize;
    }

    /**
     * Date until download is available
     */
    public ?string $downloadUntil = null {
        get => $this->downloadUntil;
    }
}
