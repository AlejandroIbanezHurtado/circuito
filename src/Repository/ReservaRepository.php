<?php

namespace App\Repository;

use App\Entity\Reserva;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Reserva|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reserva|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reserva[]    findAll()
 * @method Reserva[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reserva::class);
    }

    public function buscarPorCorreo(string $correo)
    {
        $conn = $this->getEntityManager()->getConnection();

        $registros = array();
        $sql = "select coche.id, modelo.imagen, coche.precio as 'precio_coche', reserva.fecha, reserva.precio, reserva.fecha_inicio, reserva.fecha_fin, marca.nombre as 'marca', modelo.nombre as 'modelo' from reserva inner join usuario on usuario.id = reserva.usuario_id inner join detalle_reserva on detalle_reserva.reserva_id = reserva.id inner join coche on coche.id = detalle_reserva.coche_id inner join modelo on modelo.id = coche.modelo_id inner join marca on marca.id = modelo.marca_id where usuario.email = '${correo}' order by reserva.fecha desc";
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $registros = $resultSet->fetchAll();
        return $registros;
    }

    // /**
    //  * @return Reserva[] Returns an array of Reserva objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Reserva
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
