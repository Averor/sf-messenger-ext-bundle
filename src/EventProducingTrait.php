<?php declare(strict_types=1);

namespace Averor\Messenger;

use Averor\Messenger\Contract\Event;

trait EventProducingTrait
{
    /** @var Event[] */
    protected array $events = [];

    /**
     * @return Event[]
     */
    public function pullEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }

    protected function raise(Event $event): void
    {
        $this->events[] = $event;
    }
}
