<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Devis;
use App\Entity\Produit;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class DevisType extends AbstractType
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
            // Get the currently logged-in user
            //$token = $this->tokenStorage->getToken();
            //$user = $token->getUser();

            //$fullName = $user->$token->getUser()->getFirstname() . ' ' . $user->$token->getUser()->getLastname();
           
        $token = $this->tokenStorage->getToken();
        $user = $token->getUser();


            $builder
            //->add('user', TextType::class, [
            //    'data' => $fullName,
            //    'disabled' => true,
            //])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => function (User $user) {
                    return $user->getFirstname() . ' ' . $user->getLastname();
                },
                'attr' => ['class' => 'px-3 py-2.5 mt-2.5 italic font-extralight bg-white rounded-md border border-black border-solid w-full'],
            ])
            ->add('produit', EntityType::class, [
                'class' => Produit::class,
                'choice_label' => 'nom',
                'placeholder' => 'Sélectionnez un produit',
            ])
            ->add('statut', ChoiceType::class, [
                'choices' => [
                    'Valider' => Devis::STATUS_VALIDER,
                    'Refuser' => Devis::STATUS_REFUSER,
                    'En cours de validation' => Devis::STATUS_EN_COURS_DE_VALIDATION,
                ],
                'placeholder' => 'Sélectionnez un statut',
            ])
            ->add('mail', TextType::class)
            ->add('nomClient', TextType::class)
            ->add('telephone', TextType::class)
            ->add('produitPrix', MoneyType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Devis::class,
        ]);
    }
}
