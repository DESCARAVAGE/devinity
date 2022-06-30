<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    private const NAMES = [
        'Fabrice',
        'Kyle',
        'Dimitri',
    ];
    private const SECTORS = [
        'Accountant',
        'Developeur',
        'Front Design',
    ];
    
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < count(self::NAMES); $i++) {
            $user = new User();
            $user->setName(self::NAMES[$i]);
            $user->setSector(self::SECTORS[$i]);
            $manager->persist($user);
            $this->addReference('user' . $i, $user);
        }
        $manager->flush();
    }
}
