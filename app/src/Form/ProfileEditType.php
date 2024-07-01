<?php
// src/Form/ProfileEditType.php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProfileEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'disabled' => true, // You might want to disable email editing
            ])
            ->add('firstname', TextType::class, [
                'label' => 'First Name',
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Last Name',
            ])
            ->add('address', TextareaType::class, [
                'label' => 'Address',
            ])
            ->add('zipcode', TextType::class, [
                'label' => 'Zipcode',
            ])
            ->add('city', TextType::class, [
                'label' => 'City',
            ])
            ->add('password', PasswordType::class, [
                'label' => 'New Password',
                'mapped' => false, // This field is not mapped to the User entity directly
                'required' => false, // Set to true if password change is required
            ])
            ->add('garageName', TextType::class, [
                'label' => 'Garage Name',
                'required' => false,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Save Changes',
                'attr' => ['class' => 'btn btn-primary'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
