<?php declare(strict_types=1);

namespace Averor\Messenger\Event;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Symfony\Contracts\EventDispatcher\Event;

class MessageValidationFailedEvent extends Event
{
    public Envelope $envelope;
    public ValidationFailedException $exception;
    public array $context;

    public function __construct(
        Envelope $envelope,
        ValidationFailedException $exception,
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

    public function exception(): ValidationFailedException
    {
        return $this->exception;
    }

    public function context(): array
    {
        return $this->context;
    }
}
