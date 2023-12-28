<?php

namespace App\modules\api\test\events;

use Symfony\Contracts\EventDispatcher\Event;

final class ApiTestEvent extends Event
{
    /**
     * Название события
     */
    public const NAME = 'api.test.dispatched';

    protected string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    /**
     * Получить сообщение
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}