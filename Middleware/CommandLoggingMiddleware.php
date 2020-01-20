<?php declare(strict_types=1);

namespace Averor\Messenger\Middleware;

use Averor\Messenger\Contract\Command;
use Averor\Messenger\Logger\CommandLogger;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Stamp\ReceivedStamp;
use Symfony\Component\Messenger\Stamp\RedeliveryStamp;

class CommandLoggingMiddleware implements MiddlewareInterface
{
    protected CommandLogger $logger;

    public function __construct(CommandLogger $logger)
    {
        $this->logger = $logger;
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $message = $envelope->getMessage();

        if ($message instanceof Command) {
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
