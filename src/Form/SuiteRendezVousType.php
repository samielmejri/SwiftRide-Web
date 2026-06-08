<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;

class SuiteRendezVousType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $myEntities = $options['myEntities'];
        $builder
               ->add('temps', ChoiceType::class,[
                'choices'=>$this->getDropdownListChoices($myEntities),
                'expanded' => true,
                'constraints'=>[
                new Assert\NotNull([
                    'message'=>"Ce champs est vide"
                ]),
                ]
            ])
            ->add('type', ChoiceType::class,[
                'choices'=>[
                    'Entretient'=>'entretient',
                    'Réparation'=>'reparation'
                ],
                'expanded' => true,
                'constraints'=>[
                new Assert\NotNull([
                    'message'=>"Ce champs est vide"
                ]),
                ]
            ])
        /*    ->add('idGarage' , ChoiceType::class,[
                
                'choices'=>$this->getDropdownListChoices($myEntities)
            ])*/
            ->add('envoyer',SubmitType::class);
        ;
    }

     
    private function getDropdownListChoices($myEntities)
    {
        $choices = [];

        foreach ($myEntities as $entity) {
            $choices[$entity] = $entity;
        }

        return $choices;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
        
        $resolver->setRequired('myEntities');
        $resolver->setAllowedTypes('myEntities', 'array');
    }
   
}
