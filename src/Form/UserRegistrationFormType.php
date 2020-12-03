<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserRegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class,[
                'label'=> false,
                'attr' =>[
                    "placeholder"=>"Saisir votre nom"
                ]
            ])
            ->add('prenom', TextType::class,[
                'label'=> false,
                'attr' =>["placeholder"=>"Saisir votre prénom"
            ]
            ])
            ->add('email', EmailType::class,[
                'label'=> false,
                'attr' =>[
                    "placeholder"=>"Saisir votre email"
            ]
            ])
            ->add('adresse',TextType::class,[
                'label'=> false,
                'attr' =>[
                    "placeholder"=>"Saisir votre adresse"
                ]
            ])
            ->add('plainPassword', RepeatedType::class,[
                "type" => PasswordType::class,
                "invalid_message" => "Les mots de passe doivent être identiques ",
                'first_options' => [
                    'label'=> false,
                    'attr' =>[
                        "placeholder"=>"Saisir votre mot de passe"
                    ]
                ],
                'second_options' => [
                    'label'=> false,
                    'attr' =>[
                        "placeholder"=>"Répéter votre mot de passe"
                    ]
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
