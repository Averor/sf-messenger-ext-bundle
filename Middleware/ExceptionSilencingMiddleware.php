<?php declare(strict_types=1);

namespace Averor\Messenger\Middleware;

use Averor\Messenger\Event\{
    MessageFailedEvent,
    MessageHandlingFailedEvent,
    MessageValidationFailedEvent
};
use Symfony\Component\Messenger\{
    Envelope,
    Exception\HandlerFailedException,
    Exception\ValidationFailedException,
    Middleware\MiddlewareInterface,
    Middleware\StackInterface
};
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Throwable;

class ExceptionSilencingMiddleware implements MiddlewareInterface
{
    protected EventDispatcherInterface $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $message = $envelope->getMessage();

        try {

            $envelope = $stack->next()
                ->handle($envelope, $stack);

        } catch (ValidationFailedException $e) {

            $this->eventDispatcher->dispatch(
                new MessageValidationFailedEvent($envelope, $e)
            );

        } catch (HandlerFailedException $e) {

            $this->eventDispatcher->dispatch(
                new MessageHandlingFailedEvent($envelope, $e)
            );

        } catch (Throwable $e) {

            $this->eventDispatcher->dispatch(
                new MessageFailedEvent($envelope, $e)
            );
        }

        return $envelope;
    }
}
