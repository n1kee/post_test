<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Requests\LettersRequest;
use App\Service\LetterService;
use Symfony\Component\HttpFoundation\Request;
use App\Validator\Validator;
use App\Validator\CommonInfoValidator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class LetterController extends AbstractController
{
    function __construct(protected LetterService $letterService) {

    }

    #[Route('/api/v2.3/letters', name: 'send_letters')]
    public function send(Request $request, CommonInfoValidator $validator): JsonResponse
    {
        $commonInfo = $request->files->get('commonInfo');
        if ($commonInfo instanceof UploadedFile) {
            $commonInfoContent = file_get_contents($commonInfo->getPathname());
            $validator->populate(json_decode($commonInfoContent, true));
            $errors = $validator->validate();
        }

        $httpCode = $errors ? 400 : 200;

        $requestCode = $this->letterService->sendFromRequest($request);

        return $this->json([
            'code' => $httpCode,
            'message' => $errors ? json_encode($errors, true) : null,
            'data' => [
                "requestCode" => $requestCode,
            ],
        ], $httpCode);
    }
}
