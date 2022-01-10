<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Livre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livre[]    findAll()
 * @method Livre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

    // /**
    //  * @return Livre[] Returns an array of Livre objects
    //  */

    public function rechercheParPrixSuperieur($prix)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.prix > :val')
            ->setParameter('val', $prix)
            ->getQuery()
            ->getResult()
        ;
    }
/*
    public function echercheParPrixSuperieurDQL($prix)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.prix > :val')
            ->setParameter('val', $prix)
            ->getQuery()
            ->getResult()
            ;
    }
*/
    /*
    public function findOneBySomeField($value): ?Livre
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
