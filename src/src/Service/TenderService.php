<?php

namespace App\Service;

use App\Entity\Tender;
use App\Repository\TenderRepository;
use Doctrine\ORM\EntityManagerInterface;

class TenderService
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly TenderRepository $repository
    ) {}

    public function create($tender): Tender
    {
        $this->em->persist($tender);
        $this->em->flush();

        return $tender;
    }

    public function get(int $id): ?Tender
    {
        return $this->repository->find($id);
    }
}