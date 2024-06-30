<?php

namespace App\EventSubscriber;

use App\Entity\Devis;
use App\Entity\Facture;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\EntityManagerInterface;

class DevisSubscriber implements EventSubscriber
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getSubscribedEvents(): array
    {
        return [Events::preUpdate];
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof Devis) {
            return;
        }

        if ($entity->getStatut() === Devis::STATUS_VALIDER) {
            $facture = new Facture();
            $facture->setMail($entity->getMail())
                ->setNomClient($entity->getNomClient())
                ->setTelephone($entity->getTelephone())
                ->setProduit($entity->getProduit())
                ->setPrixTotal($entity->getProduitPrix())
                ->setStatut('valider')
                ->setGarage($entity->getGarage())
                ->setDateValidation(new \DateTimeImmutable());

            $this->entityManager->persist($facture);
            $this->entityManager->flush();
        }
    }
}
