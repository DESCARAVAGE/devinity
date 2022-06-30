<?php

namespace App\DataFixtures;

use App\Entity\Idea;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class IdeaFixtures extends Fixture
{
    private const NAMES = [
        'Travel',
        'Screen Managment',
        'Underground',
    ];
    private const DESCRIPTION = [
        'Making travel easier and cheaper for businesses so they can co-operate better',
        'Office setup is put in place by specific selected people',
        'Having a louge in the underground room might increase efficiency',
    ];
    
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < count(self::NAMES); $i++) {
            $idea = new Idea();
            $idea->setName(self::NAMES[$i]);
            $idea->setDescription(self::DESCRIPTION[$i]);
            $manager->persist($idea);
            $this->addReference('idea' . $i, $idea);
        }
        $manager->flush();
    }
}
