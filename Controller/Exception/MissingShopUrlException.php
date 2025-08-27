<?php declare(strict_types=1);

namespace HeyFrame\Administration\Controller\Exception;

use HeyFrame\Core\Framework\HeyFrameHttpException;
use HeyFrame\Core\Framework\Log\Package;

#[Package('framework')]
class MissingShopUrlException extends HeyFrameHttpException
{
    public function __construct()
    {
        parent::__construct('Failed to retrieve the shop url.');
    }

    public function getErrorCode(): string
    {
        return 'ADMINISTRATION__MISSING_SHOP_URL';
    }
}
