<?php declare(strict_types=1);

namespace Averor\Messenger\Contract;

interface EventProducer
{
    /**
     * @return Event[]
     */
    public function pullEvents(): array;
}
