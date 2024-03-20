<?php

declare(strict_types=1);

namespace GeminiD\PltCommon\Listener;

use Hyperf\Event\Annotation\Listener;
use Hyperf\Framework\Event\BootApplication;
use Psr\Container\ContainerInterface;
use Hyperf\Event\Contract\ListenerInterface;

#[Listener]
class BootRPCConsumerListener implements ListenerInterface
{
    public function __construct(protected ContainerInterface $container)
    {
    }

    public function listen(): array
    {
        return [
            BootApplication::class
        ];
    }

    public function process(object $event): void
    {
        var_dump(11);
    }
}
