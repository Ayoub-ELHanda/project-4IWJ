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
            ->add('mail', TextType::class, [
                'attr' => ['class' => 'px-3 py-2.5 mt-2.5 italic font-extralight bg-white rounded-md border border-black border-solid w-full'],
            ])
            ->add('nomClient', TextType::class, [
                'attr' => ['class' => 'px-3 py-2.5 mt-2.5 italic font-extralight bg-white rounded-md border border-black border-solid w-full'],
            ])
            ->add('telephone', TextType::class, [
                'attr' => ['class' => 'px-3 py-2.5 mt-2.5 italic font-extralight bg-white rounded-md border border-black border-solid w-full'],
            ])
            ->add('user', TextType::class, [
                'disabled' => true,
                'data' => $this->getUserGarageName(),
                'required' => false,
                'attr' => ['class' => 'px-3 py-2.5 mt-2.5 italic font-extralight bg-white rounded-md border border-black border-solid w-full'],
            ])
            ->add('produits', EntityType::class, [
                'class' => Produit::class,
                'choice_label' => function (Produit $produit) {
                    return $produit->getNom() . ' - ' . $produit->getPrix() . ' €';
                },
                'multiple' => true,
                'expanded' => true,
                'required' => true,
                'attr' => [
                    'class' => 'flex flex-wrap gap-4 mt-2.5 mb-4',
                ],
                'choice_attr' => function(Produit $produit, $key, $value) {
                    return ['class' => 'form-checkbox h-5 w-5 text-blue-600'];
                },
            ])
            ->add('totalPrix', MoneyType::class, [
                'currency' => false,
                'mapped' => false,
                'disabled' => true,
                'attr' => [
                    'readonly' => true,
                    'class' => 'hidden',
                ],
                'label' => false, // Pas de label
                'required' => false, // Pas requis
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
