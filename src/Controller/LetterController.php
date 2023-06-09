<?php

namespace App\Controller;

use App\Service\LetterService;
use App\Validator\CommonInfoValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LetterController extends AbstractController
{
    public function __construct(protected LetterService $letterService)
    {
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
                'requestCode' => $requestCode,
            ],
        ], $httpCode);
    }
}
