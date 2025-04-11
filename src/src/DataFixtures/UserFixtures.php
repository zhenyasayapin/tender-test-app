<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();

        $user->setUsername('test');
        $user->setApiToken('0123456789');

        $manager->persist($user);

        $manager->flush();
    }
}
