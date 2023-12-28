<?php

namespace App\modules\api\test\listeners;

use App\modules\api\test\events\ApiTestEvent;
use Psr\Log\LoggerInterface;

/**
 * @psalm-suppress UnusedClass
 */
final class ApiTestEventListener
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Обработка тестового события
     * @param ApiTestEvent $event Объект тестового события
     * @return void Логирование сообщения из тестового события
     */
    public function onApiTestDispatched(ApiTestEvent $event): void
    {
        $this->logger->info('Обработка прослушиваемого события');
        $this->logger->info(sprintf('Полученное сообщение: %s', $event->getMessage()));

        $this->logger->info('Завершение обработки события');
    }
}