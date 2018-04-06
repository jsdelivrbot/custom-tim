<?php

/*
 * This file is part of the T.I.M (Tag Incident Manager) project.
 */

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Flex\Options;
use App\Entity\Zone;

/**
 * Form for creating Zones
 *
 * @author Andry Randriana <ARandirana.prestataire@oui-sncf.com>
 */
class ZoneType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        $builder
            ->add('zones', ChoiceType::class)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Zone::class,
        ]);
    }
}
