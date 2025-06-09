<?php
// src/Repository/StageRepository.php

namespace App\Repository;

use App\Entity\Stage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class StageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stage::class);
    }

    public function findByEtudiant(int $etudiantId): ?Stage
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.etudiant = :etudiantId')
            ->setParameter('etudiantId', $etudiantId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByEntreprise(int $entrepriseId): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.entreprise = :entrepriseId')
            ->setParameter('entrepriseId', $entrepriseId)
            ->getQuery()
            ->getResult();
    }

    public function findInProgress(): array
    {
        $now = new \DateTime();
        
        return $this->createQueryBuilder('s')
            ->andWhere('s.date_debut <= :now')
            ->andWhere('s.date_fin >= :now')
            ->setParameter('now', $now)
            ->getQuery()
            ->getResult();
    }

    public function findCompleted(): array
    {
        $now = new \DateTime();
        
        return $this->createQueryBuilder('s')
            ->andWhere('s.date_fin < :now')
            ->setParameter('now', $now)
            ->getQuery()
            ->getResult();
    }

    public function findByEncadrant(int $encadrantId): array
    {
        return $this->createQueryBuilder('s')
            ->join('s.etudiant', 'e')
            ->andWhere('e.encadrant = :encadrantId')
            ->setParameter('encadrantId', $encadrantId)
            ->getQuery()
            ->getResult();
    }
}