<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class Produit1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'px-3 py-2.5 mt-2.5 italic font-extralight bg-white rounded-md border border-black border-solid w-full'
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'px-3 py-2.5 mt-2.5 italic font-extralight bg-white rounded-md border border-black border-solid w-full'
                ]
            ])
            ->add('price', MoneyType::class, [
                'attr' => [
                    'class' => 'px-3 py-2.5 mt-2.5 italic font-extralight bg-white rounded-md border border-black border-solid w-full'
                ]
            ])
            ->add('createdAt', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'px-3 py-2.5 mt-2.5 italic font-extralight bg-white rounded-md border border-black border-solid w-full'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
