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

    private TenderService $service;

    protected function setUp(): void
    {
        $this->em = self::getContainer()->get('doctrine')->getManager();
        $this->service = new TenderService(
            em: $this->em,
            repository: new TenderRepository(self::getContainer()->get(ManagerRegistry::class))
        );
    }

    public function testMustCreateTender()
    {
        $tender = $this->createTender();

        $this->service->create($tender);

        $this->assertEquals(
            $tender,
            $this->em->getRepository(Tender::class)->find($tender->getId())
        );
    }

    public function testMustGetTender()
    {
        $tender = $this->createTender();

        $this->service->create($tender);

        $this->assertEquals(
            $tender,
            $this->service->get($tender->getId())
        );
    }

    public function testMustGetAllTenders()
    {
        $tender = $this->createTender();

        $tenders = [
            $tender,
            $tender,
            $tender
        ];

        foreach ($tenders as $testTender) {
            $this->service->create($testTender);
        }

        $this->assertCount(
            count($tenders),
            $this->service->getAll(),
        );
    }

    public function testMustReturnAllTendersWithFilter()
    {
        $defaultTender = $this->createTender();

        $customTender = $this->createTender();
        $customTender->setName('Custom');

        $this->service->create($defaultTender);
        $this->service->create($customTender);

        $tenders = $this->service->getAll(['name' => 'Custom', 'date' => $customTender->getDate()->format(DATE_ATOM)]);

        /** @var Tender $tender */
        foreach($tenders as $tender) {
            $this->assertEquals('Custom', $tender->getName());
            $this->assertEquals($customTender->getDate()->format(DATE_ATOM), $tender->getDate()->format(DATE_ATOM));
        }
    }

    private function createTender(): Tender
    {
        $tender = new Tender();

        $tender->setName('Casual name');
        $tender->setStatus(TenderStatusEnum::OPEN->value);
        $tender->setExternalCode(123);
        $tender->setNumber('1234-5');

        return $tender;
    }
}