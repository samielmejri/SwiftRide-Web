<?php

namespace App\Form;

use App\Entity\Accident;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;


class UpdateaccidentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('type', TextType::class, ['required' => true])
            
        ->add('date',DateTimeType::class, [
            'widget' => 'single_text',
            'attr' => [
                'min' => (new \DateTime())->format('Y-m-d')
            ]
        ])
        ->add('description', TextType::class, ['required' => true])
        ->add('lieu', TextType::class, ['required' => true])
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Accident::class,
        ]);
    }
}
