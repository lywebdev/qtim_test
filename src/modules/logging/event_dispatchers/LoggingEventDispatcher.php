<?php

namespace App\modules\logging\event_dispatchers;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;
use Throwable;
use function get_class;

final class LoggingEventDispatcher implements EventDispatcherInterface
{
    private EventDispatcherInterface $eventDispatcher;

    private LoggerInterface $logger;

    /**
     * @psalm-suppress UnusedMethod
     * @param EventDispatcherInterface $eventDispatcher
     * @param LoggerInterface $logger
     */
    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        LoggerInterface $logger
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     * @throws Throwable
     */
    public function dispatch(object $event, ?string $eventName = null): void
    {
        $eventName = $eventName ?? get_class($event);

        try {
            $this->logger->info("Отправка события: $eventName");
            $dispatchParams = [$event];
            if ($eventName !== null) {
                $dispatchParams[] = $eventName;
            }

            $this->eventDispatcher->dispatch(...$dispatchParams);
            $this->logger->info("Событие успешно отправлено: $eventName");
        } catch (Throwable $e) {
            $this->logger->error("Ошибка при отправки события $eventName: " . $e->getMessage());
            throw $e;
        }
    }
}