<?php

namespace App\Form;

use App\Entity\MoyenTransportStation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MoyenTransportStationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('moyenTransport', ChoiceType::class, [
                'choices' => [
                    'Bus' => 'bus',
                    'Métro' => 'metro',
                    'Tramway' => 'tramway',
                ],
                'label' => 'Moyen de transport',
            ])
            ->add('station', IntegerType::class, [
                'label' => 'ID de la station',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MoyenTransportStation::class,
        ]);
    }
}
