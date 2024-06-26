<?php

// src/Form/DevisType.php

namespace App\Form;

use App\Entity\Devis;
use App\Entity\Garage;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class DevisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('garage', EntityType::class, [
                'class' => Garage::class,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionnez un garage',
            ])
            ->add('produit', EntityType::class, [
                'class' => Produit::class,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionnez un produit',
            ])
            ->add('status', TextType::class)
            ->add('price', MoneyType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Devis::class,
        ]);
    }
}
