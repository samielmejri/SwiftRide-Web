<?php

namespace App\Form;

use App\Entity\Maintenance;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;

class MaintenanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $myEntities = $options['myEntities'];
        $builder
            ->add('dateMaintenance',DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'min' => (new \DateTime())->format('Y-m-d H:i:s')
                ],
                'constraints' => [
                    new Assert\GreaterThan([
                        'value'=>new \DateTime() ,
                          'message'=>"Doit etre aprés la date d'ajourd'hui"
                    ]),

                ],
            ])
            ->add('type', ChoiceType::class,[
                'choices'=>[
                    'Entretient'=>'entretient',
                    'Réparation'=>'reparation'
                ],
                'expanded' => true,
                'constraints' => [
                    new Assert\NotNull([
                        'message'=>"Ce champs est vide"
                    ]),
                ]
            ])
            ->add('idGarage' , ChoiceType::class,[
                
                'choices'=>$this->getDropdownListChoices($myEntities),
                'constraints' => [
                    new Assert\NotNull([
                        'message'=>"Ce champs est vide"
                    ]),
                ]
            ])
            ->add('ajouter',SubmitType::class,[
                'label'=>'Metre à jour'
            ])
        ;
    }

    private function getDropdownListChoices($myEntities)
    {
        $choices = [];

        foreach ($myEntities as $entity) {
            $choices[$entity->getMatriculeGarage()." / ".$entity->getLocalisation()] = $entity;
        }

        return $choices;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Maintenance::class,
            'cascade_validation' => true
        ]);

        $resolver->setRequired('myEntities');
        $resolver->setAllowedTypes('myEntities', 'array');
    }
}
