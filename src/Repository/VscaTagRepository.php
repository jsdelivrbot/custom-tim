<?php
/**
 * This file is part of the T.I.M (Tag Incident Project) project.
 */

namespace App\Repository;

use App\Entity\VscaTag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class VscaTagRepository
 */
class VscaTagRepository extends ServiceEntityRepository
{

    /**
     * VscaTagRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VscaTag::class);
    }
}
