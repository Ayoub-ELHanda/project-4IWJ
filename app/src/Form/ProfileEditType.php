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
        ->add('garageName', TextType::class, [
            'label' => 'Garage Name',
            'required' => false,
            'attr' => ['class' => 'block w-full px-3 py-2 mb-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'],
        ])
        ->add('email', EmailType::class, [
            'label' => 'Email',
            'disabled' => true, // You might want to disable email editing
            'attr' => ['class' => 'block w-full px-3 py-2 mb-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'],
        ])
        ->add('firstname', TextType::class, [
            'label' => 'First Name',
            'attr' => ['class' => 'block w-full px-3 py-2 mb-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'],
        ])
        ->add('lastname', TextType::class, [
            'label' => 'Last Name',
            'attr' => ['class' => 'block w-full px-3 py-2 mb-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'],
        ])
        ->add('address', TextareaType::class, [
            'label' => 'Address',
            'attr' => ['class' => 'block w-full px-3 py-2 mb-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'],
        ])
        ->add('zipcode', TextType::class, [
            'label' => 'Zipcode',
            'attr' => ['class' => 'block w-full px-3 py-2 mb-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'],
        ])
        ->add('city', TextType::class, [
            'label' => 'City',
            'attr' => ['class' => 'block w-full px-3 py-2 mb-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'],
        ])
        ->add('password', PasswordType::class, [
            'label' => 'New Password',
            'mapped' => false, // This field is not mapped to the User entity directly
            'required' => false, // Set to true if password change is required
            'attr' => ['class' => 'block w-full px-3 py-2 mb-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'],
        ])
        ->add('save', SubmitType::class, [
            'label' => 'Enregistrer les changements',
            'attr' => ['class' => 'self-center px-3 py-2.5 rounded-md bg-slate-900 text-white hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
