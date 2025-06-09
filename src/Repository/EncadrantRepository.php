<?php
// src/Repository/EncadrantRepository.php

namespace App\Repository;

use App\Entity\Encadrant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EncadrantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Encadrant::class);
    }

    public function findByEmail(string $email): ?Encadrant
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findAllSupervising(): array
    {
        return $this->createQueryBuilder('e')
            ->join('e.etudiants', 'et')
            ->addSelect('et')
            ->andWhere('et.id IS NOT NULL')
            ->getQuery()
            ->getResult();
    }
}