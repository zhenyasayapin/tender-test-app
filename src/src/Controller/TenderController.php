<?php

namespace App\Controller;

use App\Entity\Tender;
use App\Service\TenderService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class TenderController extends AbstractController
{
    public function __construct(
        private readonly TenderService $tenderService,
    ) {}

    #[Route('/tender', name: 'app_tender_create', methods: ['POST'])]
    public function create(SerializerInterface $serializer, ValidatorInterface $validator, Request $request): JsonResponse
    {
        if (empty($request->getContent())) {
            throw new \Exception('The request body is empty');
        }

        $tender = $serializer->deserialize(
            $request->getContent(),
            Tender::class,
            'json'
        );

        $violations = $validator->validate($tender);

        if (count($violations) > 0) {
            return $this->json([$violations[0]->getPropertyPath() => $violations[0]->getMessage()]);
        } else {
            return $this->json($this->tenderService->create($tender));
        }
    }

    #[Route('/tender/{id}', name: 'app_tender_get', methods: ['GET'])]
    public function get(int $id): JsonResponse
    {
        return $this->json($this->tenderService->get($id));
    }

    #[Route('/tender', name: 'app_tender_get_all', methods: ['GET'])]
    public function getAll(): JsonResponse
    {
        return $this->json($this->tenderService->getAll());
    }
}
