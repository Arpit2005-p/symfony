<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;

class ContactType extends AbstractType
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
                    new Length([ 'min' => 3, 'max' => 10]),
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

            ->add('phone', TextType::class, [
                'label'=> 'Phone:',
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'form-group'],
                'constraints'=>[
                    new NotBlank(['message' => 'Phone is required']),
                    new Length(['min'=> 10, 'max' => 11]),
                    new Regex([
                        'pattern' => "/^\+?[0-9\s]+$/",
                        'message' => "Enter a valid phone number"
                    ])
                ]
            ])
            ->add('message', TextType::class, [
                'label'=> 'Message:',
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'form-group'],
                'constraints'=> [
                    new Length(['max'=> 300]),
                ]
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Submit',
                'attr' => ['class' => 'btn btn-primary mt-3']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
