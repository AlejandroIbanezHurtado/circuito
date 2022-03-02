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

    public function crearComentario($user,$valoracion,$comentario,$coche)
    {
        $conn = $this->getEntityManager()->getConnection();

        $registros = array();
        $sql = "select detalle_reserva.id from valoracion_coche inner join detalle_reserva on detalle_reserva.id = valoracion_coche.detalle_reserva_id inner join reserva on reserva.id = detalle_reserva.reserva_id where reserva.usuario_id = ${user} and detalle_reserva.coche_id = ${coche} and EXISTS (select * from detalle_reserva inner join reserva on reserva.id = detalle_reserva.reserva_id where reserva.usuario_id = ${user} and detalle_reserva.coche_id = ${coche})";
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $registros = $resultSet->fetchAll();

        if(empty($registros))
        {
            $registros2 = array();
            $sql2 = "select detalle_reserva.id from detalle_reserva inner join reserva on reserva.id = detalle_reserva.reserva_id where reserva.usuario_id = ${user} and detalle_reserva.coche_id = ${coche}";
            $stmt2 = $conn->prepare($sql2);
            $resultSet2 = $stmt2->executeQuery();
            $registros2 = $resultSet2->fetchAll();
            if(empty($registros2)) return $registros=NULL;

            $id_detalle = $registros2[0]["id"];
            
            $sql = "INSERT INTO valoracion_coche (detalle_reserva_id,valoracion,comentario) VALUES (${id_detalle},${valoracion},'${comentario}')";
            $stmt = $conn->prepare($sql);
            $resultSet = $stmt->execute();
        }
        else{
            $id_detalle = $registros[0]["id"];
            $sql = "UPDATE valoracion_coche inner join detalle_reserva on valoracion_coche.detalle_reserva_id = detalle_reserva.id inner join reserva on reserva.id = detalle_reserva.reserva_id set valoracion_coche.comentario = '${comentario}', valoracion_coche.valoracion = ${valoracion} where detalle_reserva.id = ${id_detalle}";
            $stmt = $conn->prepare($sql);
            $resultSet = $stmt->execute();
        }
        return $registros;
    }

    public function findMejoresValoraciones()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "select ROUND(AVG(valoracion_coche.valoracion)) as 'media', coche.precio, modelo.nombre as 'modelo', marca.nombre as 'marca',modelo.imagen from valoracion_coche inner join detalle_reserva on valoracion_coche.detalle_reserva_id = detalle_reserva.id inner join coche on detalle_reserva.coche_id = coche.id inner join modelo on modelo.id = coche.modelo_id inner join marca on modelo.marca_id = marca.id group by modelo.nombre order by SUM(valoracion_coche.valoracion) desc limit 5";
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

    public function valoracionesPorId($id)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "select valoracion_coche.*, usuario.nombre, usuario.apellidos, usuario.imagen from valoracion_coche inner join detalle_reserva on detalle_reserva.id = valoracion_coche.detalle_reserva_id inner join reserva on reserva.id = detalle_reserva.reserva_id inner join usuario on usuario.id = reserva.usuario_id where detalle_reserva.coche_id = ${id} order by detalle_reserva.id desc";
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
