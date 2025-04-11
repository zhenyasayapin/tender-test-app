<?php

namespace App\Service;

use App\Entity\Tender;
use Doctrine\ORM\EntityManagerInterface;

class TenderService
{
    public function __construct(
        private readonly EntityManagerInterface $em,
    ) {}

    public function create($tender): Tender
    {
        $this->em->persist($tender);
        $this->em->flush();

        return $tender;
    }
}