<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Facture;
use App\Entity\User; 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class FactureType extends AbstractType
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Get the currently logged-in user
        $token = $this->tokenStorage->getToken();
        $user = $token->getUser();

        $builder
            ->add('mail', EmailType::class)
            ->add('nomClient', TextType::class)
            ->add('telephone', TextType::class)
            ->add('produit', EntityType::class, [
                'class' => Produit::class,
                'choice_label' => 'nom',
            ])
            ->add('prixTotal', MoneyType::class, [
                'currency' => 'EUR',
            ])
            ->add('statut', TextType::class)
            ->add('dateValidation', TextType::class, [
                'disabled' => true,
                'data' => (new \DateTime())->format('Y-m-d H:i:s'),
            ])
            ->add('user', TextType::class, [
                'data' => $user->getUser->getFirstname.$user->getUser->getLastname, // Display only the username of the logged-in user
                'disabled' => true, // Disable editing of this field
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Facture::class,
        ]);
    }
}
