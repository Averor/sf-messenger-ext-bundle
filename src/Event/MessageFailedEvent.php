<?php declare(strict_types=1);

namespace Averor\Messenger\Event;

use Symfony\Component\Messenger\Envelope;
use Symfony\Contracts\EventDispatcher\Event;
use Throwable;

class MessageFailedEvent extends Event
{
    protected Envelope $envelope;
    protected Throwable $exception;
    protected array $context;

    public function __construct(
        Envelope $envelope,
        Throwable $exception,
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

    public function exception(): Throwable
    {
        return $this->exception;
    }

    public function context(): array
    {
        return $this->context;
    }
}
