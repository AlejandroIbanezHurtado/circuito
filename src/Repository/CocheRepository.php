<?php

namespace App\Repository;

use App\Entity\Coche;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Coche|null find($id, $lockMode = null, $lockVersion = null)
 * @method Coche|null findOneBy(array $criteria, array $orderBy = null)
 * @method Coche[]    findAll()
 * @method Coche[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CocheRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Coche::class);
    }

    public function countCoche()
    {
        return $this->createQueryBuilder('t')
            ->select('count(t.id)')
            ->getQuery()
            ->getSingleScalarResult();

    }
    // SELECT * FROM comentarios ORDER BY rand() LIMIT 1;
    public function findMejoresValoraciones()
    {
        $criteria = array_rand(array(
            't.id' => 'loquesea',
            't.precio' => 'loquesea',
            't.modelo' => 'loquesea'
          ));
        $orderby = array_rand(array(
            'DESC' => 'DESC',
            'ASC' => 'ASC'
          ));
        return $this->createQueryBuilder('t')
            ->select('t')
            ->orderBy($criteria, $orderby)
            ->setMaxResults(5)
            ->getQuery()
            ->execute();

    }

    // /**
    //  * @return Coche[] Returns an array of Coche objects
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
    public function findOneBySomeField($value): ?Coche
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
