<?php

namespace App\Form;

use App\Entity\EntreprisePartenaire;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\Email;


class EntreprisePartenaireType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom_entreprise', null, [
            'constraints' => [
                new NotBlank(['message' => "Le nom d'entreprise est obligatoire, Veuillez le remplir"]),
                new Regex([
                    'pattern' => '/^[a-zA-Z]+$/',
                    'message' => 'Le nom d\'entreprise doit être alphabétique'
                ]),
              
            ],
        ])
        ->add('nom_admin', null, [
            'constraints' => [
                new NotBlank(['message' => "Le nom d'admin est obligatoire, Veuillez le remplir"]),
                new Regex([
                    'pattern' => '/^[a-zA-Z]+$/',
                    'message' => 'Le nom d\'admin doit être alphabétique'
                ]),
            ],
        ])
        ->add('prenom_admin', null, [
            'constraints' => [
                new NotBlank(['message' => "Le prenom d'entreprise est obligatoire, Veuillez le remplir"]),
                new Regex([
                    'pattern' => '/^[a-zA-Z]+$/',
                    'message' => 'Le prénom d\'admin doit être alphabétique'
                ]),
            ],
        ])
        ->add('nb_voiture', null, [
            'constraints' => [
                new NotBlank(['message' => "Le nombre de voiture est obligatoire, Veuillez le remplir"]),
                new Regex([
                    'pattern' => '/^[1-9]\d*$/',
                    'message' => 'Le nombre de voitures doit être un nombre supérieur à 0'
                ]),
            ],
        ])
        ->add('tel', null, [
            'constraints' => [
                new NotBlank(['message' => "Le numéro de télephone est obligatoire, Veuillez le remplir"]),
                new Regex([
                    'pattern' => '/^\d{8}$/',
                    'message' => 'Le numéro de téléphone doit contenir exactement 8 chiffres'
                ]),
            ],
        ])
        
        ->add('matricule', null, [
            'constraints' => [
                new NotBlank(['message' => "La matricule est obligatoire, Veuillez le remplir"]),
            ],
        ])
        ->add('login', null, [
            'constraints' => [
                new NotBlank(['message' => "Le login est obligatoire, Veuillez le remplir"]),
                new Email([
                    'message' => 'Le champ doit contenir une adresse email valide'
                ]),
            ],
        ])
        ->add('mdp', PasswordType::class, [
            'constraints' => [
                new NotBlank(['message' => "Le mot de passe est obligatoire, Veuillez le remplir"]),
                new Regex([
                    'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/',
                    'message' => 'Le mot de passe doit contenir au moins une lettre majuscule, un chiffre et de longeur 8 caracteres'
                ])
            ],
            'attr' => [
                'autocomplete' => 'new-password', // to prevent browser autocomplete on password
                'class' => 'form-control', // add any custom classes you want
                'type' => 'password', // set the type of the input as password
                'placeholder' => 'Mot de passe', // add a placeholder text
                'data-toggle' => 'password' // add a data-toggle attribute for showing/hiding password
            ]
        ]);
    }

        

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        // Configure your form options here            
        ]);
    }
}