<?php

namespace App\Form;

use App\Entity\Voiture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\RegexValidator;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\File;

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        
        ->add('marque', ChoiceType::class, [
            'attr' => [
               
                'class' => 'contact-form bg-light mb-4 ',
                'style' => 'padding: 15px; margin: 0 50px;',
            ],
            'label_attr' => [
                'style' => 'padding: 15px; margin: 0 50px;',
            ],
            'row_attr' => [
                'class' => 'form-group row'
            ],
            'choices' => [
                'Audi' => 'Audi',
                'BMW' => 'BMW',
                'Mercedes' => 'Mercedes',
                'Renault' => 'Renault',
                'Peugeot' => 'Peugeot',
            ],
            'placeholder' => 'Donner la marque',
        ])
            ->add('model' , TextType::class , [
                'label_attr' => [
                    'style' => 'padding: 15px; margin: 0 50px;',
                ],
                'row_attr' => [
                    'class' => 'form-group row'
                ],
                'attr' => [
             
                    'class' => 'contact-form bg-light mb-4',
                    'style' => 'padding: 15px; margin: 0 50px;',
                ]])
            ->add('matricule', TextType::class, [
                'label_attr' => [
                    'style' => 'padding: 15px; margin: 0 50px;',
                ],
                'row_attr' => [
                    'class' => 'form-group row'
                ],
                'attr' => [
                    'placeholder' => 'XXX TU XXXX',
                    'class' => 'contact-form bg-light mb-4',
                    'style' => 'padding: 15px; margin: 0 50px;',
                ],
                'label' => 'Matricule',
                
        'required' => true,
                'constraints' => [
                    new Regex([
                        'pattern' => '/^\d{3}\s[A-Z]{2}\s\d{4}$/',
                        'message' => 'Matricule format is invalid',
                        'match' => true,
                    ]),
                ],
            ])
            ->add('cartegrise', TextType::class , [
                'label_attr' => [
                    'style' => 'padding: 15px; margin: 0 50px;',
                ],
                'row_attr' => [
                    'class' => 'form-group row'
                ],
               
                'attr' => [
                    
                    'class' => 'form-group',
                    
                    'class' => 'contact-form bg-light mb-4',
                    'style' => 'padding: 15px; margin: 0 50px;',
                ]]
                )
            ->add('couleur', TextType::class , [
                'label_attr' => [
                    'style' => 'padding: 15px; margin: 0 50px;',
                ],
                'row_attr' => [
                    'class' => 'form-group row'
                ],
                'attr' => [
                   
                    'class' => 'contact-form bg-light mb-4',
                    'style' => 'padding: 15px; margin: 0 50px;',
                ]])

            ->add('etat', ChoiceType::class, [
                'label_attr' => [
                    'style' => 'padding: 15px; margin: 0 50px;',
                ],
                'row_attr' => [
                    'class' => 'form-group row'
                ],
                'attr' => [
               
                    'class' => 'contact-form bg-light mb-4',
                    'style' => 'padding: 15px; margin: 0 50px;',
                ],
                'choices' => [
                    'Bonne etat' => 'Bonne etat',
                    'En panne' => 'En panne',
                   
                ],
                'placeholder' => 'Donner l"etat',
            ])

            ->add('prix', TextType::class , [
                'label_attr' => [
                    'style' => 'padding: 15px; margin: 0 50px;',
                ],
                'row_attr' => [
                    'class' => 'form-group row'
                ],
                'attr' => [
                   
                    'class' => 'contact-form bg-light mb-4',
                    'style' => 'padding: 15px; margin: 0 50px;',
                ]])

            ->add('kilometrage', TextType::class , [
                'label_attr' => [
                    'style' => 'padding: 15px; margin: 0 50px;',
                ],
                'row_attr' => [
                    'class' => 'form-group row'
                ],
                'attr' => [
                   
                    'class' => 'contact-form bg-light mb-4',
                    'style' => 'padding: 15px; margin: 0 50px;',
                ]])

            ->add('image', FileType::class, [
                'label_attr' => [
                    'style' => 'padding: 15px; margin: 0 50px;',
                ],
                'row_attr' => [
                    'class' => 'form-group row'
                ],
                'label' => 'Image (JPG, JPEG, PNG file)',
                'mapped' => true, // map the uploaded file to the 'image' property in the entity
                'required' => false,
                'data_class' => null, // Set data_class to null for this field
                'attr' => [
                  
                        'class' => 'contact-form bg-light mb-4',
                        'style' => 'padding: 15px; margin: 0 50px;',
                    
                    'accept' => 'image/jpeg, image/png',
                ],

                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid JPG, JPEG, or PNG image',
                    ])
                ]
            ])

            ->add('position', TextType::class , [
                'label_attr' => [
                    'style' => 'padding: 15px; margin: 0 50px;',
                ],
                'row_attr' => [
                    'class' => 'form-group row'
                ],
                'attr' => [
                    
                    'class' => 'contact-form bg-light mb-4',
                    'style' => 'padding: 15px; margin: 0 50px;',
                ]])

                ->add('entrepriseId', ChoiceType::class, [
                    'choices' => [
                        'skander_entreprise' => 1,
                        'Sami_entreprise' => 2,
                        'ines_entreprise' => 3,
                    ],
                    'expanded' => true,
                    'label_attr' => [
                        'style' => 'padding: 15px; margin: 0 50px;',
                    ],
                    'row_attr' => [
                        'class' => 'form-group row'
                    ],
                    'attr' => [
                        'class' => 'contact-form bg-light mb-4',
                        'style' => 'padding: 15px; margin: 0 50px;',
                    ]
                ])

                ->add('dateAjout', DateType::class, [
                    'label_attr' => [
                        'style' => 'padding: 15px; margin: 0 50px;',
                    ],
                    'row_attr' => [
                        'class' => 'form-group row'
                    ],
                    
                    
                'attr' => [
                    
                    'class' => 'contact-form bg-light mb-4',
                    'style' => 'padding: 15px; margin: 0 50px;',
                ]
                
                
                ])
                

            ;

       
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}