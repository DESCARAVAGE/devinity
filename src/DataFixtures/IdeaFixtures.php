<?php

namespace App\DataFixtures;

use App\Entity\Idea;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class IdeaFixtures extends Fixture
{
    private const NAMES = [
        'Travel',
        'Higher Sky',
        'Underground',
    ];
    private const DESCRIPTION = [
        'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
        'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
        'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
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
