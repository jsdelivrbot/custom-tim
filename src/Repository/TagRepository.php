<?php
/**
 * This file is part of the T.I.M (Tag Incident Project) project.
 */

namespace App\Repository;

use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class TagRepository
 */
class TagRepository extends ServiceEntityRepository
{
    /**
     * TagRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tag::class);
    }

    /**
     * Return the T.I.M-tag by label and NULL if the tag doesn't exist
     *
     * @param string $label
     *
     * @return mixed
     *
     * @throws \Doctrine\ORM\NonUniqueResultException

     */
    public function findTagByLabel($label)
    {
        return $this->createQueryBuilder('b')
            ->where('b.label = :label')
            ->setParameter('label', $label)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
