<?php
/*
 * This file is part of the T.I.M (Tag Incident Manager) project.
 */

namespace App\DataFixtures;

use App\Entity\Rule;
use App\Entity\Zone;
use App\Repository\StatusRepository;
use App\Repository\TagRepository;
use App\Repository\ZoneRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class LoadRuleData
 */
class LoadRuleData extends Fixture implements DependentFixtureInterface
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
        $this->loadZone($manager);
    }

    /**
     * {@inheritdoc}
     */
    public function getDependencies()
    {
        return [LoadZoneData::class];
    }

    /**
     * @param ObjectManager $manager
     */
    private function loadZone(ObjectManager $manager)
    {
        $allRules = [
            ['tag' => 'Eulerian', 'zones' => ['zone1', 'zone2'], 'status' => 'actif'],
            ['tag' => 'Omniture', 'zones' => ['zone2'], 'status' => 'attente_deploiement'],
            ['tag' => 'Publicité', 'zones' => ['zone1', 'zone3'], 'status' => 'attente_suppression'],

        ];

        array_map(function ($ruleSpec) use ($manager) {
            // Creating the tag
            $tagRep = new TagRepository($this->registry);
            $tag = $tagRep->findTagByLabel($ruleSpec['tag']);

            // Creating the zones
            $zoneRep = new ZoneRepository($this->registry);
            $zones = array_map(function ($zoneLabel) use ($zoneRep) {
                return $zoneRep->findZoneByLabel($zoneLabel);
            }, $ruleSpec['zones']);

            // Creating Status
            $statusRep = new StatusRepository($this->registry);
            $status = $statusRep->findStatusByLabel($ruleSpec['status']);

            // Finally create the rule
            $rule = new Rule();
            $rule
                ->setTag($tag)
                ->setStatus($status);

            array_map(function ($zone) use ($rule) {
                $rule->addZone($zone);
            }, $zones);

            $manager->persist($rule);
        }, $allRules);

        $manager->flush();
    }
}
