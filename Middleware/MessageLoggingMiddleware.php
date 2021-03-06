<?php declare(strict_types=1);

namespace Averor\Messenger\Middleware;

use Averor\Messenger\MessageLogger;
use Symfony\Component\Messenger\{
    Envelope,
    Middleware\MiddlewareInterface,
    Middleware\StackInterface,
    Stamp\ReceivedStamp,
    Stamp\RedeliveryStamp
};

class MessageLoggingMiddleware implements MiddlewareInterface
{
    protected MessageLogger $logger;

    public function __construct(MessageLogger $logger)
    {
        $this->logger = $logger;
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        // Do not log messages received from transport
        // (should already be logged before sending)
        if (!$envelope->all(ReceivedStamp::class)
            && !$envelope->all(RedeliveryStamp::class)
        ) {
            $this->logger->log($envelope);
        }

        $envelope = $stack->next()->handle($envelope, $stack);

        return $envelope;
    }
}
