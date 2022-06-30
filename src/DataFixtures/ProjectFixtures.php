<?php

namespace App\DataFixtures;

use App\Entity\Project;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProjectFixtures extends Fixture
{
    private const NAMES = [
        'Co-Voiturage',
    ];
    private const DATE = [
        '05/09/2022',
    ];
    
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < count(self::NAMES); $i++) {
            $project = new Project();
            $project->setName(self::NAMES[$i]);
            $project->setDate(new DateTime(self::DATE[$i]));
            $manager->persist($project);
            $this->addReference('project' . $i, $project);
        }
        $manager->flush();
    }
}
