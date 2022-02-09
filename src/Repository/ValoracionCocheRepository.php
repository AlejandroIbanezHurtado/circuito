<?php

namespace App\Repository;

use App\Entity\ValoracionCoche;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ValoracionCoche|null find($id, $lockMode = null, $lockVersion = null)
 * @method ValoracionCoche|null findOneBy(array $criteria, array $orderBy = null)
 * @method ValoracionCoche[]    findAll()
 * @method ValoracionCoche[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ValoracionCocheRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ValoracionCoche::class);
    }

    // /**
    //  * @return ValoracionCoche[] Returns an array of ValoracionCoche objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ValoracionCoche
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}