<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Project;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProjectFixtures extends Fixture implements DependentFixtureInterface
{
    private const NAMES = [
        'Co-Voiturage',
    ];
    private const DATE = [
        '05/09/2022',
    ];
    private const FOLLOWERS =
    3;

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < count(self::NAMES); $i++) {
            $project = new Project();
            $project->setName(self::NAMES[$i]);
            $project->setDate(new DateTime(self::DATE[$i]));
            $manager->persist($project);
            $this->addReference('project' . $i, $project);
            for ($j = 0; $j < self::FOLLOWERS; $j++) {
                $project->addCountFollower($this->getReference('user' . $j));
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
