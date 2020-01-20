<?php declare(strict_types=1);

namespace Averor\Messenger;

use Averor\Messenger\Contract\EventSubscriber;
use Symfony\Component\Messenger\MessageBusInterface;

abstract class ProcessManager implements EventSubscriber
{
    protected MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }
}
