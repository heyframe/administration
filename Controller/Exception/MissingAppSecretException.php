<?php declare(strict_types=1);

namespace HeyFrame\Administration\Controller\Exception;

use HeyFrame\Core\Framework\HeyFrameHttpException;
use HeyFrame\Core\Framework\Log\Package;

#[Package('framework')]
class MissingAppSecretException extends HeyFrameHttpException
{
    public function __construct()
    {
        parent::__construct('Failed to retrieve app secret.');
    }

    public function getErrorCode(): string
    {
        return 'ADMINISTRATION__MISSING_APP_SECRET';
    }
}
