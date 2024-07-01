<?php

namespace App\Form;
use App\Entity\Devis;
use App\Entity\User;
use App\Entity\Facture;
use App\Entity\Produit;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class FactureType extends AbstractType
{
    private TokenStorageInterface $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mail', TextType::class)
            ->add('nomClient', TextType::class)
            ->add('telephone', TextType::class)
            ->add('user', TextType::class, [
                'disabled' => true,
                'data' => $this->getUserGarageName(),
                'required' => false,
            ])
            ->add('produits', EntityType::class, [
                'class' => Produit::class,
                'choice_label' => function (Produit $produit) {
                    return $produit->getNom() . ' - ' . $produit->getPrix() . ' €';
                },
                'multiple' => true,
                'expanded' => true,
                'required' => true,
            ])
            ->add('totalPrix', MoneyType::class, [
                'label' => 'Total Prix des Produits',
                'currency' => 'EUR',
                'mapped' => false,
                'disabled' => true,
                'attr' => [
                    'readonly' => true,
                ],
            ]);

        // Event listener for calculating totalPrix on form pre-set data
        $builder->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'onPreSetData']);

        // Event listener for updating totalPrix on produits selection changes
        $builder->get('produits')->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use ($builder) {
            $form = $event->getForm()->getParent();
            $produits = $event->getForm()->getData();

            $totalPrix = 0;
            foreach ($produits as $produit) {
                $totalPrix += $produit->getPrix();
            }

            $form->get('totalPrix')->setData($totalPrix);
        });

        // Event listener to update totalPrix when data is submitted (necessary for initial display)
        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();
            $facture = $event->getData();

            $totalPrix = 0;
            foreach ($facture->getProduits() as $produit) {
                $totalPrix += $produit->getPrix();
            }

            $facture->setTotalPrix($totalPrix);
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Facture::class,
        ]);
    }

    private function getUserGarageName(): string
    {
        $token = $this->tokenStorage->getToken();
        $user = $token->getUser();

        if ($user instanceof User) {
            return $user->getGarageName() ?? '';
        }

        return '';
    }

    public function onPreSetData(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();

        // Calculate totalPrix if produits are already set
        if ($data instanceof Facture && !empty($data->getProduits())) {
            $totalPrix = 0;

            foreach ($data->getProduits() as $produit) {
                $totalPrix += $produit->getPrix();
            }

            // Set the calculated totalPrix to the form field
            $form->get('totalPrix')->setData($totalPrix);
        }
    }
}
