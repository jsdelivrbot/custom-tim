<?php
/*
 * This file is part of the T.I.M (Tag Incident Manager) project.
 */

namespace App\DataFixtures;

use App\Entity\Zone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadZoneData
 */
class LoadZoneData extends Fixture implements DependentFixtureInterface
{

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->loadZone($manager);
    }

    /**
     * {@inheritdoc}
     */
    public function getDependencies()
    {
        return [LoadVscaTagData::class];
    }

    /**
     * @param ObjectManager $manager
     */
    private function loadZone($manager)
    {
        $allZones = [
            'zone1',
            'zone2',
            'zone3',
        ];
        array_map(function ($zoneLabel) use ($manager) {
            $zone = new Zone();
            $zone
                ->setLabel($zoneLabel)
                ->setDescription('Default desc.');
            $manager->persist($zone);

            $manager->flush();
        }, $allZones);
    }
}
