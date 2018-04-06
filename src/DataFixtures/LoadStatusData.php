<?php
/*
 * This is part of the T.I.M (Tag Incident Manager) project.
 */

namespace App\DataFixtures;

use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class StatusFixtures
 */
class LoadStatusData extends Fixture
{

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->loadStatus($manager);
    }

    /**
     * @param ObjectManager $manager
     */
    private function loadStatus(ObjectManager $manager)
    {
        $allStatus = ['attente_deploiement', 'actif', 'attente_suppression'];
        array_map(function ($status) use ($manager) {
            $st = new Status();
            $st->setLabel($status);
            $manager->persist($st);
        }, $allStatus);

        $manager->flush();
    }
}
