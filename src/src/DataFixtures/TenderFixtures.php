<?php

namespace App\DataFixtures;

use App\Entity\Tender;
use App\Enum\TenderStatusEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TenderFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $filePath = __DIR__ . '/test_task_data.csv';
        $lineCount = 1;
        if (($handle = fopen($filePath, 'r')) !== false) {
            fgets($handle);
            $lineCount++;

            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                try {
                    $tender = new Tender();

                    $tender->setExternalCode((int) $data[0]);
                    $tender->setNumber($data[1]);
                    $tender->setStatus(TenderStatusEnum::tryFrom($data[2])->value);
                    $tender->setName($data[3]);

                    $manager->persist($tender);

                    $lineCount++;
                } catch (\Exception $e) {
                    echo "The line {$lineCount} is skipped" . PHP_EOL;
                }
            }

            fclose($handle);
        }

        $manager->flush();
    }
}
