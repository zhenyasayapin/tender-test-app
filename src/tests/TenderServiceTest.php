<?php

namespace App\Tests;

use App\Repository\TenderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Service\TenderService;
use App\Entity\Tender;
use App\Enum\TenderStatusEnum;

class TenderServiceTest extends KernelTestCase
{

    private EntityManagerInterface $em;

    protected function setUp(): void
    {
        $this->em = self::getContainer()->get('doctrine')->getManager();
    }

    public function testServiceMustCreateTender()
    {
        $service = new TenderService(
            em: $this->em,
            repository: $this->createMock(TenderRepository::class)
        );

        $tender = new Tender();

        $tender->setName('Casual name');
        $tender->setStatus(TenderStatusEnum::OPEN->value);
        $tender->setExternalCode(123);
        $tender->setNumber('1234-5');

        $service->create($tender);

        $this->assertEquals(
            $tender,
            $this->em->getRepository(Tender::class)->find($tender->getId())
        );
    }

    public function testServiceMustGetTender()
    {
        $service = new TenderService(
            em: $this->em,
            repository: new TenderRepository(self::getContainer()->get(ManagerRegistry::class))
        );

        $tender = new Tender();

        $tender->setName('Casual name');
        $tender->setStatus(TenderStatusEnum::OPEN->value);
        $tender->setExternalCode(123);
        $tender->setNumber('1234-5');

        $service->create($tender);

        $this->assertEquals(
            $tender,
            $service->get($tender->getId())
        );
    }
}