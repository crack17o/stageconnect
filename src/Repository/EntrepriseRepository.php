<?php
// src/Repository/EntrepriseRepository.php

namespace App\Repository;

use App\Entity\Entreprise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EntrepriseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entreprise::class);
    }

    public function findByNom(string $nom): ?Entreprise
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.nom = :nom')
            ->setParameter('nom', $nom)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findWithAvailableStages(): array
    {
        return $this->createQueryBuilder('e')
            ->leftJoin('e.stages', 's')
            ->addSelect('s')
            ->andWhere('s.id IS NOT NULL')
            ->getQuery()
            ->getResult();
    }
}