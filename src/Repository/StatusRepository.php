<?php
/**
 * This file is part of the T.I.M (Tag Incident Manager) project.
 */

namespace App\Repository;

use App\Entity\Status;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class StatusRepository
 */
class StatusRepository extends ServiceEntityRepository
{
    /**
     * StatusRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Status::class);
    }

    /**
     * Return the status corresponding the given label
     *
     * @param string $label
     *
     * @return mixed
     *
     * @throws \Doctrine\ORM\NonUniqueResultException

     */
    public function findStatusByLabel($label)
    {
        return $this->createQueryBuilder('b')
            ->where('b.label = :label')
            ->setParameter('label', $label)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
