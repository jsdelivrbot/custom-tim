<?php

/*
 * This file is part of the T.I.M (Tag Incident Manager) project
 */

namespace App\ModelManager;

use App\Entity\Rule;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class RuleManager
 */
class RuleManager
{

    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $entityManager;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    protected $repository;

    /**
     * RuleManager constructor.
     * @param RegistryInterface $doctrine
     */
    public function __construct(RegistryInterface $doctrine)
    {
        $this->entityManager = $doctrine->getManager();
        $this->repository = $doctrine->getRepository(Rule::class);
    }

    /**
     * @param Rule $rule
     * @param bool $andFlush
     *
     * @return Rule
     */
    public function create(Rule $rule, $andFlush = true)
    {
        // TODO: set the default status to : 'attente_deploiement'
        $this->entityManager->persist($rule);

        if (true === $andFlush) {
            $this->entityManager->flush();
        }

        return $rule;
    }
}
