<?php

namespace App\modules\api\test\controllers;

use App\modules\api\test\events\ApiTestEvent;
use App\modules\logging\event_dispatchers\LoggingEventDispatcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

/**
 * @psalm-suppress UnusedClass
 */
final class ApiTestController extends AbstractController
{
    /**
     * Текст сообщения для тестового запроса по умолчанию
     */
    private const MESSAGE_NOT_TRANSMITTED = 'Сообщение не передано';

    private LoggingEventDispatcher $loggingEventDispatcher;

    public function __construct(LoggingEventDispatcher $loggingEventDispatcher)
    {
        $this->loggingEventDispatcher = $loggingEventDispatcher;
    }

    /**
     * Обработка тестового запроса, вызов тестового события, его логирование
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     */
    #[Route('/api/test/event', name: 'api_test_event')]
    public function event(Request $request): JsonResponse
    {
        $message = $request->query->get('message') ?? self::MESSAGE_NOT_TRANSMITTED;
        $this->loggingEventDispatcher->dispatch(new ApiTestEvent($message), ApiTestEvent::NAME);

        $jsonResponse = new JsonResponse(['message' => $message], Response::HTTP_OK);
        $jsonResponse->setEncodingOptions(JSON_UNESCAPED_UNICODE);

        return $jsonResponse;
    }
}
