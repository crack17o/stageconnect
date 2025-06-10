<?php

namespace App\Repository;

use App\Entity\OffreDeStage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OffreDeStage>
 *
 * @method OffreDeStage|null find($id, $lockMode = null, $lockVersion = null)
 * @method OffreDeStage|null findOneBy(array $criteria, array $orderBy = null)
 * @method OffreDeStage[]    findAll()
 * @method OffreDeStage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OffreDeStageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OffreDeStage::class);
    }

    /**
     * Trouve toutes les offres de stage avec leurs entreprises associées
     */
    public function findAllWithEntreprise()
    {
        return $this->createQueryBuilder('o')
            ->leftJoin('o.entreprise', 'e')
            ->addSelect('e')
            ->orderBy('o.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Trouve les offres de stage pour une entreprise spécifique
     */
    public function findByEntreprise($entrepriseId)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.entreprise = :entrepriseId')
            ->setParameter('entrepriseId', $entrepriseId)
            ->orderBy('o.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Recherche des offres par mot-clé dans le titre ou la description
     */
    public function searchOffres($keyword)
    {
        return $this->createQueryBuilder('o')
            ->leftJoin('o.entreprise', 'e')
            ->addSelect('e')
            ->andWhere('o.titre LIKE :keyword OR o.description LIKE :keyword')
            ->setParameter('keyword', '%' . $keyword . '%')
            ->orderBy('o.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Trouve les offres récentes (limitées par un nombre)
     */
    public function findRecentOffres($limit = 5)
    {
        return $this->createQueryBuilder('o')
            ->leftJoin('o.entreprise', 'e')
            ->addSelect('e')
            ->orderBy('o.id', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * Sauvegarde une offre de stage
     */
    public function save(OffreDeStage $offre, bool $flush = false): void
    {
        $this->getEntityManager()->persist($offre);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Supprime une offre de stage
     */
    public function remove(OffreDeStage $offre, bool $flush = false): void
    {
        $this->getEntityManager()->remove($offre);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
} 