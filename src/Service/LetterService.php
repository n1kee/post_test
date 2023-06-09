<?php

namespace App\Service;

use App\Requests\LettersRequest;
use Symfony\Component\HttpFoundation\Request;

class LetterService
{
    # Сохраняет письмо, используя данные из входящего запроса.
    public function saveFromRequest(Request $request): int
    {
        /* ... */
        return 123;
    }

    # Отправляет письмо, используя данные из входящего запроса.
    public function sendFromRequest(Request $request): string
    {
        $letterId = $this->saveFromRequest($request);
        /* ... */
        return "req_089aebf2-a95c-4b93-88b9-8c391137249c";
    }
}
