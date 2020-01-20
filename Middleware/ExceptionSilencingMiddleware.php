<?php declare(strict_types=1);

namespace Averor\Messenger\Middleware;

use Averor\Messenger\Event\{
    MessageFailedEvent,
    MessageHandlingFailedEvent,
    MessageValidationFailedEvent
};
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\{
    Envelope,
    Exception\HandlerFailedException,
    Exception\ValidationFailedException,
    Middleware\MiddlewareInterface,
    Middleware\StackInterface
};
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Throwable;
use function get_class;

class ExceptionSilencingMiddleware implements MiddlewareInterface
{
    protected LoggerInterface $logger;
    protected EventDispatcherInterface $eventDispatcher;

    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        LoggerInterface $messengerLogger
    ) {
        $this->logger = $messengerLogger;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $message = $envelope->getMessage();

        try {

            $envelope = $stack->next()
                ->handle($envelope, $stack);

        } catch (ValidationFailedException $e) {

            $this->logger->error(
                'An validation exception occurred while handling message {class}',
                array_merge(
                    $this->createContext($message),
                    [
                        'exception' => $e,
                        'violations' => $e->getViolations()
                    ]
                )
            );

            $this->eventDispatcher->dispatch(
                new MessageValidationFailedEvent($envelope, $e)
            );

        } catch (HandlerFailedException $e) {

            $this->logger->error(
                'An exception occurred while handling message {class}',
                array_merge(
                    $this->createContext($message),
                    ['exception' => $e]
                )
            );

            $this->eventDispatcher->dispatch(
                new MessageHandlingFailedEvent($envelope, $e)
            );

        } catch (Throwable $e) {

            $this->logger->error(
                'An exception occurred while handling message {class}',
                array_merge(
                    $this->createContext($message),
                    ['exception' => $e]
                )
            );

            $this->eventDispatcher->dispatch(
                new MessageFailedEvent($envelope, $e)
            );
        }

        return $envelope;
    }

    protected function createContext($message): array
    {
        return [
            'message' => $message,
            'class' => get_class($message),
        ];
    }
}
