<?php

namespace App\Form;

use App\Entity\Annonces;
use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use VictorPrdh\RecaptchaBundle\Form\ReCaptchaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Repository\UtilisateurRepository;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $myEntities = $options['myEntities'];
        $builder
            ->add('title')
            ->add('image', FileType::class, [
                'label' => 'Image (JPG or PNG file)',
                'required' => false,
            ])
            ->add('date',DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'min' => (new \DateTime())->format('Y-m-d')
                ]
            ])
           
            ->add('content')
            
            ->add('voiture', ChoiceType::class, [
                'choices' => $this->getmodelVoitures($myEntities), // This should return an array of available voitures
                'expanded' => true, // This makes the field a radio button instead of a dropdown list
                'multiple' => false, // This allows only one voiture to be selected at a time
                
            ])
            
            ->add("recaptcha", ReCaptchaType::class)
           
        ;
    }
    private function getmodelVoitures($myEntities)
    {
        $choices = [];

        foreach ($myEntities as $entity) {
            $choices[$entity->getModel()] = $entity;
        }

        return $choices;
    }
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonces::class,
            
        ]);
        $resolver->setRequired('myEntities');
        $resolver->setAllowedTypes('myEntities', 'array');
    }
}
