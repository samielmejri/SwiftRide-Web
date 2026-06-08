<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\Range;




class MoyenTransportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('type', ChoiceType::class, [
            'choices' => [
                'Bus' => 'bus',
                'Train' => 'train',
                'Metro' => 'metro',
            ],
            'placeholder' => 'type de transport',
            'constraints' => [
                new NotBlank(),
            ],
        ])
            ->add('numero_trans', null, [
                'constraints' => [
                    new NotBlank(), 
                    new Range([
                        'min' => 1,
                        'max' => 9999,
                        'notInRangeMessage' => 'the transport number should be between {{ min }} and {{ max }}.',
                    ]),
                ],        
                ])
                
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
