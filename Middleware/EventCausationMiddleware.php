<?php declare(strict_types=1);

namespace Averor\Messenger\Middleware;

use Averor\Messenger\Contract\Command;
use Averor\Messenger\Stamp\{
    CausationStamp,
    IdentifiableMessageStamp
};
use Symfony\Component\Messenger\{
    Envelope,
    Middleware\MiddlewareInterface,
    Middleware\StackInterface
};

class EventCausationMiddleware implements MiddlewareInterface
{
    protected ?string $id = null;

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $message = $envelope->getMessage();

        if (
            $message instanceof Command
            && ($idStamp = $envelope->last(IdentifiableMessageStamp::class))
            && !$this->id
            && !$envelope->last(CausationStamp::class)
        ) {
            // root command
            $this->id = $idStamp->messageId();
        }

        if (
            $message instanceof Command
            && ($causationStamp = $envelope->last(CausationStamp::class))
        ) {
            // Dependant command
            $this->id = $causationStamp->commandId();
        }

        if (
            $this->id
            && !$envelope->last(CausationStamp::class)
        ) {
            // Root command will have its own id set as its causation.
            // It is always possible to check if command is root or not by
            // comparing ids from IdentifiableMessageStamp & CausationStamp (same => root)
            $envelope = $envelope->with(new CausationStamp($this->id));
        }

        $envelope = $stack->next()->handle($envelope, $stack);

        return $envelope;
    }
}
