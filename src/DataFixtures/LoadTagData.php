<?php
/*
 * This file is part of the T.I.M (Tag Incident Manager) project.
 */

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadTagData
 */
class LoadTagData extends Fixture
{

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->loadTag($manager);
    }

    /**
     * @param ObjectManager $manager
     */
    private function loadTag(ObjectManager $manager)
    {
        $tags = ['Omniture', 'Publicité', 'Eulerian'];
        array_map(function ($tag) use ($manager) {
            $t = new Tag();
            $t->setLabel($tag);
            $manager->persist($t);
        }, $tags);

        $manager->flush();
    }
}
