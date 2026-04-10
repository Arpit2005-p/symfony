<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name:',
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'form-group'],
                'constraints' => [      
                    new NotBlank(),
                    new Length(['min' => 2, 'max' => 10]),
                ]
            ])
            ->add('email', TextType::class, [
                'label' => 'Email:',
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'form-group'],
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 15, 'max' => 35]),
                    new Email(['message' => 'Invalid email format']),
                ]
            ])


            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'form-group'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        'max' => 20,
                    ]),
                ],
            ])

            ->add('repeatPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'form-group'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please repeat your password',
                    ]),
                ],
            ])

            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])

            

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,

            // Form-level validation for matching passwords
            'constraints' => [
                new Callback([$this, 'validatePasswords']),
            ],
        ]);
    }

    public function validatePasswords($data, ExecutionContextInterface $context)
    {
        $form = $context->getRoot();

        $password = $form->get('plainPassword')->getData();
        $repeat = $form->get('repeatPassword')->getData();

        if ($password !== $repeat) {
            $context->buildViolation('Passwords do not match.')
                ->atPath('repeatPassword')
                ->addViolation();
        }
    }
}
