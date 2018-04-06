<?php

/*
 * This file is part of the T.I.M (Tag Incident Manager) project.
 */

namespace App\Form\Type;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Rule;
use App\Form\Type\TagType;
use App\Form\Type\ZoneType;

/**
 * Form for creating Rules
 *
 * @author Andry Randriana <ARandriana.prestataire@oui-sncf.com>
 */
class RuleType extends AbstractType
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * RuleType constructor.
     */
    public function __construct()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tag', TagType::class)
            ->add('zones', TextType::class)
        ;

        return $builder;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rule::class,
        ]);
    }
}
