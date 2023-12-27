<?php

namespace App\modules\api\test\controllers;

use Symfony\Component\Routing\Annotation\Route;

final class ApiTestController
{
    #[Route('/api/test/event', name: 'api_test_event')]
    public function event()
    {

    }
}
