<?php declare(strict_types=1);

namespace Averor\Messenger\Event;

use Symfony\Component\Messenger\{
    Envelope,
    Exception\HandlerFailedException
};
use Symfony\Contracts\EventDispatcher\Event;

class MessageHandlingFailedEvent extends Event
{
    public Envelope $envelope;
    public HandlerFailedException $exception;
    public array $context;

    public function __construct(
        Envelope $envelope,
        HandlerFailedException $exception,
        ?array $context = []
    ) {
        $this->envelope = $envelope;
        $this->exception = $exception;
        $this->context = $context;
    }

    public function envelope(): Envelope
    {
        return $this->envelope;
    }

    public function exception(): HandlerFailedException
    {
        return $this->exception;
    }

    public function context(): array
    {
        return $this->context;
    }
}
