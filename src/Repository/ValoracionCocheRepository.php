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

    public function findMejoresValoraciones()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "select ROUND(AVG(valoracion_coche.valoracion)) as 'media', coche.precio, modelo.nombre as 'modelo', marca.nombre as 'marca',modelo.imagen from valoracion_coche inner join detalle_reserva on valoracion_coche.detalle_reserva_id = detalle_reserva.id inner join coche on detalle_reserva.coche_id = coche.id inner join modelo on modelo.id = coche.modelo_id inner join marca on modelo.marca_id = marca.id group by modelo.nombre order by SUM(valoracion_coche.valoracion) desc";
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        return $resultSet->fetchAllAssociative();
    }

    public function valoracionesAleatorias()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "select usuario.imagen, usuario.nombre, usuario.apellidos, valoracion_coche.valoracion, valoracion_coche.comentario from valoracion_coche inner join detalle_reserva on valoracion_coche.detalle_reserva_id = detalle_reserva.id inner join reserva on reserva.id = detalle_reserva.reserva_id inner join usuario on usuario.id = reserva.usuario_id where valoracion_coche.comentario is not null order by rand() limit 3";
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        return $resultSet->fetchAllAssociative();
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
