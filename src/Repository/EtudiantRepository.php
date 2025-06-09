<?php
// src/Repository/EtudiantRepository.php

namespace App\Repository;

use App\Entity\Etudiant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EtudiantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Etudiant::class);
    }

    public function findByEmail(string $email): ?Etudiant
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByEncadrant(int $encadrantId): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.encadrant = :encadrantId')
            ->setParameter('encadrantId', $encadrantId)
            ->getQuery()
            ->getResult();
    }

    public function findAllWithStages(): array
    {
        return $this->createQueryBuilder('e')
            ->leftJoin('e.stage', 's')
            ->addSelect('s')
            ->andWhere('s.id IS NOT NULL')
            ->getQuery()
            ->getResult();
    }
}