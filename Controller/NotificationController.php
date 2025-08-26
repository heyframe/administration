<?php declare(strict_types=1);

namespace HeyFrame\Administration\Controller;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Routing\ApiRouteScope;
use HeyFrame\Core\PlatformRequest;
use Symfony\Component\Routing\Attribute\Route;

/**
 * @deprecated tag:v6.8.0 - Will be removed in 6.8.0. Use HeyFrame\Core\Framework\Notification\Api\NotificationController instead
 */
#[Route(defaults: [PlatformRequest::ATTRIBUTE_ROUTE_SCOPE => [ApiRouteScope::ID]])]
#[Package('framework')]
class NotificationController extends \HeyFrame\Core\Framework\Notification\Api\NotificationController
{
}
