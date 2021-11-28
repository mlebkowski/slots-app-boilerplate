<?php

declare(strict_types=1);

namespace Enraged\Interactions\Web\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatusController
{
    #[Route('/', name: 'status_index')]
    public function indexHtml() : Response
    {
        return new Response('OK');
    }
}
