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
        '06/29/2022',
    ];
    private const DESCRIPTION =
    'Last night we were able to advance in the data services and have completed the display of our product';

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
