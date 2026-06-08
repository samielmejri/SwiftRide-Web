<?php

namespace App\Form;

use App\Entity\Annonces;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use VictorPrdh\RecaptchaBundle\Form\ReCaptchaType;

class UpdateannonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title')
        
        ->add('date',DateTimeType::class, [
            'widget' => 'single_text',
            'attr' => [
                'min' => (new \DateTime())->format('Y-m-d')
            ]
        ])
        ->add('image', FileType::class, [
            'label' => 'Image (JPG or PNG file)',
            'required' => false,
            'data_class' => null, // add this line to allow string value
        ])
        ->add('content')
        ->add("recaptcha", ReCaptchaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonces::class,
        ]);
    }
}
