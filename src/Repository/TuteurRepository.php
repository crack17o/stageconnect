<?php
// src/Repository/TuteurRepository.php

namespace App\Repository;

use App\Entity\Tuteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TuteurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tuteur::class);
    }

    public function findByEntreprise(int $entrepriseId): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.entreprise = :entrepriseId')
            ->setParameter('entrepriseId', $entrepriseId)
            ->getQuery()
            ->getResult();
    }
}