<?php
/*
 * This file is part of the T.I.M (Tag Incident Manager) project.
 */

namespace App\DataFixtures;

use App\Entity\VscaTag;
use App\Repository\TagRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\DataFixtures\LoadTagData;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class LoadVscaTagData
 */
class LoadVscaTagData extends Fixture implements DependentFixtureInterface
{

    private $registry;


    /**
     * LoadVscaTagData constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->loadTag($manager);
    }

    /**
     * {@inheritdoc}
     */
    public function getDependencies()
    {
        return array(
            LoadTagData::class,
        );
    }

    /**
     * @param ObjectManager $manager
     */
    private function loadTag(ObjectManager $manager)
    {
        $tagMap = [
            'omniture' => 'Omniture',
            'dart' => 'Publicité',
            'eulerian' => 'Eulerian',
            'eulerian2' => 'Eulerian',
            'eulerianwrapper' => 'Eulerian',
            'euleriananalytics' => 'Eulerian',
        ];

        array_map(function ($vscaTagLabel, $timTagLabel) use ($manager) {
             $tagRep = new TagRepository($this->registry);
             $timTag = $tagRep->findTagByLabel($timTagLabel);
             $vscaTag = new VscaTag();
             $vscaTag
                ->setTag($timTag)
                ->setLabel($vscaTagLabel);
             $manager->persist($vscaTag);

             $manager->flush();
        }, array_keys($tagMap), $tagMap);
    }
}
