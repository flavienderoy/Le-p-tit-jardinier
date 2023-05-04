<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\HttpFoundation\Request;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $request = Request::createFromGlobals();
        $choix = $request->get('choix');

        $builder
            ->add('email', EmailType::class, ['attr' => ['class' => 'form-control'], 'label' => 'E-mail'])
            ->add('nom', TextType::class, ['attr' => ['class' => 'form-control'], 'label' => 'Nom'])
            ->add('prenom', TextType::class, ['attr' => ['class' => 'form-control'], 'label' => 'Prenom'])
            ->add('adresse', TextType::class, ['attr' => ['class' => 'form-control'], 'label' => 'Adresse'])
            ->add('ville', TextType::class, ['attr' => ['class' => 'form-control'], 'label' => 'Ville'])
            ->add('cp', TextType::class, ['attr' => ['class' => 'form-control'], 'label' => 'Code Postal'])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'Accepter les termes',
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter accepter les termes pour pouvoir créer votre compte.',
                    ]),
                ],
            ])
            ->add('typeClient', TextType::class, [
                'attr' => ['class' => 'invisible'], 
                'label_attr' => ['class' => 'invisible'],
                'label' => '',
                'data' => $choix,
            ])

            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
