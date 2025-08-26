<?php declare(strict_types=1);

namespace HeyFrame\Administration\Login\Config;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Struct\JsonSerializableTrait;

/**
 * @internal
 */
#[Package('framework')]
final class TemplateData implements \JsonSerializable
{
    use JsonSerializableTrait;

    public function __construct(
        public readonly bool $useDefault,
        public readonly ?string $url,
    ) {
    }
}
