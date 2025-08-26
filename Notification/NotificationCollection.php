<?php declare(strict_types=1);

namespace HeyFrame\Administration\Notification;

use HeyFrame\Core\Framework\DataAbstractionLayer\EntityCollection;
use HeyFrame\Core\Framework\Log\Package;

/**
 * @deprecated tag:v6.8.0 - Will be removed in 6.8.0. Use HeyFrame\Core\Framework\Notification\NotificationCollection instead
 *
 * @extends EntityCollection<NotificationEntity>
 */
#[Package('framework')]
class NotificationCollection extends EntityCollection
{
}
