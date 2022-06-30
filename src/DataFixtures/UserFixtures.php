<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture implements DependentFixtureInterface
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
    private const IDEAS = 
        3;

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < count(self::NAMES); $i++) {
            $user = new User();
            $user->setName(self::NAMES[$i]);
            $user->setSector(self::SECTORS[$i]);
            $manager->persist($user);
            $this->addReference('user' . $i, $user);
            for ($j = 0; $j < self::IDEAS; $j++) {
                $user->addIdea($this->getReference('idea'. $j));
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            IdeaFixtures::class,
        ];
    }
}
