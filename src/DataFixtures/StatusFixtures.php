<?php

namespace App\DataFixtures;

use App\Entity\Project;
use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class StatusFixtures extends Fixture implements DependentFixtureInterface
{
    private const NAMES = [
        'New',
        'Abadoned',
        'Work in Progress',
        'Help Idea',
        'Help Wanted',
        'Finished',
    ];
    private const COLOR = [
        'primary',
        'danger',
        'warning',
        'secondary',
        'info',
        'success',
    ];

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < count(self::NAMES); $i++) {
            $status = new Status();
            $status->setName(self::NAMES[$i]);
            $status->setColor(self::COLOR[$i]);
            $manager->persist($status);
            $status->addProject($this->getReference('project0'));
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return
            [
                ProjectFixtures::class
            ];
    }
}
