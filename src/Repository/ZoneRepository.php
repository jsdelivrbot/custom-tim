<?php
/**
 * This file is part of the T.I.M (Tag Incident Project) project.
 */

namespace App\Repository;

use App\Entity\Zone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class ZoneRepository
 */
class ZoneRepository extends ServiceEntityRepository
{

    /**
     * ZoneRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Zone::class);
    }

    /**
     * Return the zone corresponding to the given label
     * @param string $label
     *
     * @return mixed
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     */
    public function findZoneByLabel($label)
    {
        return $this->createQueryBuilder('b')
            ->where('b.label = :label')
            ->setParameter('label', $label)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}