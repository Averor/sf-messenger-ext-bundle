<?php declare(strict_types=1);

namespace Averor\Messenger\Middleware;

use Averor\Messenger\Stamp\IdentifiableMessageStamp;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

class IdentifiableMessageMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        if (!$envelope->all(IdentifiableMessageStamp::class)) {
            $envelope = $envelope->with(
                new IdentifiableMessageStamp()
            );
        }

        return $stack->next()->handle($envelope, $stack);
    }
}
