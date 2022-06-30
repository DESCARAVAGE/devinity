<?php

namespace App\DataFixtures;

use App\Entity\Report;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ReportFixtures extends Fixture
{
    private const NAMES = [
        'Report Of the day',
    ];
    private const DATE = [
        '05/09/2022',
    ];
    private const DESCRIPTION =
    'Lorem Ipsum is simply dummy text of the printing and typesetting industry';

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < count(self::NAMES); $i++) {
            $report = new Report();
            $report->setName(self::NAMES[$i]);
            $report->setDate(new DateTime(self::DATE[$i]));
            $report->setDescription(self::DESCRIPTION);
            $manager->persist($report);
            $this->addReference('report' . $i, $report);
        }
        $manager->flush();
    }
}
