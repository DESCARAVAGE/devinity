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
    private const FOLLOWERS =
    3;
    private const PARTICIPANTS =
    2;
    private const IDEAS =
    3;

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < count(self::NAMES); $i++) {
            $project = new Project();
            $project->setName(self::NAMES[$i]);
            $manager->persist($project);
            $this->addReference('project' . $i, $project);
            for ($j = 0; $j < self::FOLLOWERS; $j++) {
                $project->addCountFollower($this->getReference('user' . $j));
            }
            for ($k = 0; $k < self::PARTICIPANTS; $k++) {
                $project->addParticipant($this->getReference('user' . $k));
            }
            $project->addReport($this->getReference('report0'));
            for ($l = 0; $l < self::IDEAS; $l++) {
                $project->addIdea($this->getReference('idea'. $l));
            }
            
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            ReportFixtures::class,
            IdeaFixtures::class
        ];
    }
}
