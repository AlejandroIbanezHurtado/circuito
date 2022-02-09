<?php

namespace App\Repository;

use App\Entity\Circuito;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Circuito|null find($id, $lockMode = null, $lockVersion = null)
 * @method Circuito|null findOneBy(array $criteria, array $orderBy = null)
 * @method Circuito[]    findAll()
 * @method Circuito[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CircuitoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Circuito::class);
    }

    // /**
    //  * @return Circuito[] Returns an array of Circuito objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Circuito
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
