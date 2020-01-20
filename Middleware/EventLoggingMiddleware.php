<?php declare(strict_types=1);

namespace Averor\Messenger\Middleware;

use Averor\Messenger\Contract\Event;
use Averor\Messenger\Logger\EventLogger;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Stamp\ReceivedStamp;
use Symfony\Component\Messenger\Stamp\RedeliveryStamp;

class EventLoggingMiddleware implements MiddlewareInterface
{
    protected EventLogger $logger;

    public function __construct(EventLogger $logger)
    {
        $this->logger = $logger;
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $message = $envelope->getMessage();

        if ($message instanceof Event) {
            // Do not log messages received from transport
            // (should already be logged before sending)
            if (!$envelope->all(ReceivedStamp::class)
                && !$envelope->all(RedeliveryStamp::class)
            ) {
                $this->logger->log($envelope);
            }
        }

        $envelope = $stack->next()->handle($envelope, $stack);

        return $envelope;
    }
}
