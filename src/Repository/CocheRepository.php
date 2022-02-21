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

    public function obtenCochesPaginados(int $pagina, int $filas)
    {
        $conn = $this->getEntityManager()->getConnection();

        $registros = array();
        $sql = "select coche.id, coche.potencia, coche.precio, coche.cilindrada, coche.velocidad, modelo.nombre as 'modelo', modelo.imagen, marca.nombre 'marca' from coche inner join modelo on modelo.id = coche.modelo_id inner JOIN marca on marca.id = modelo.marca_id";
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $registros = $resultSet->fetchAll();
        $n_total = count($registros);

        $total = count($registros);
        $paginas = ceil($total /$filas);
        $registros = array();
        if ($pagina <= $paginas)
        {
            $inicio = ($pagina-1) * $filas;
            $sql = "select coche.id, coche.potencia, coche.precio, coche.cilindrada, coche.velocidad, modelo.nombre as 'modelo', modelo.imagen, marca.nombre 'marca' from coche inner join modelo on modelo.id = coche.modelo_id inner JOIN marca on marca.id = modelo.marca_id limit $inicio, $filas";
            $stmt = $conn->prepare($sql);
            $resultSet = $stmt->executeQuery();
            $registros = $resultSet->fetchAll(); 
        }
        return $registros;
    }

    public function obtenTotalCoches()
    {
        $conn = $this->getEntityManager()->getConnection();

        $registros = array();
        $sql = "select coche.id, coche.potencia, coche.precio, coche.cilindrada, coche.velocidad, modelo.nombre as 'modelo', modelo.imagen, marca.nombre 'marca' from coche inner join modelo on modelo.id = coche.modelo_id inner JOIN marca on marca.id = modelo.marca_id";
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $registros = $resultSet->fetchAll();
        return $registros;
    }

    public function buscarPorId(int $id)
    {
        $conn = $this->getEntityManager()->getConnection();

        $registros = array();
        $sql = "select coche.*, modelo.imagen, modelo.nombre as 'modelo', marca.nombre as 'marca' from coche inner join modelo on modelo.id = coche.modelo_id inner join marca on marca.id = modelo.marca_id where coche.id = ${id}";
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $registros = $resultSet->fetchAll();
        return $registros;
    }

    public function buscarCochesNoFechas($fecha_inicio, $fecha_fin, $ids)
    {
        $conn = $this->getEntityManager()->getConnection();
        $coches_ids="";
        $ids = json_decode($ids);
        foreach ($ids as &$valor) {
            $coches_ids = $coches_ids.$valor.",";
        }
        $coches_ids = substr($coches_ids,0,-1);
        $registros = array();
        $sql = "select marca.nombre as 'marca', modelo.nombre as 'modelo', coche.* from coche inner join modelo on modelo.id = coche.modelo_id inner join marca on marca.id = modelo.marca_id where coche.id not in (SELECT detalle_reserva.coche_id FROM reserva inner join detalle_reserva on detalle_reserva.reserva_id = reserva.id WHERE (reserva.fecha_inicio BETWEEN '${fecha_inicio}' AND '${fecha_fin}') and (reserva.fecha_fin BETWEEN '${fecha_inicio}' AND '${fecha_fin}')) and coche.id not in (${coches_ids})";
        // dd($sql);
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $registros = $resultSet->fetchAll();
        return $registros;
    }


    public function obtenCochesPaginadosNoFechas($fecha_inicio,$fecha_fin, int $pagina, int $filas,$marca=false,$buscar=false,$orden=false)
    {
        $conn = $this->getEntityManager()->getConnection();

        $registros = array();
        $sql = "select marca.nombre as 'marca', modelo.nombre as 'modelo', coche.*, modelo.imagen from coche inner join modelo on modelo.id = coche.modelo_id inner join marca on marca.id = modelo.marca_id where coche.id not in (SELECT detalle_reserva.coche_id FROM reserva inner join detalle_reserva on detalle_reserva.reserva_id = reserva.id WHERE (reserva.fecha_inicio BETWEEN '${fecha_inicio}' AND '${fecha_fin}') and (reserva.fecha_fin BETWEEN '${fecha_inicio}' AND '${fecha_fin}'))";
        if($marca!="false") $sql = $sql." and marca.id = '${marca}'";
        if($buscar!="false") $sql = $sql." and modelo.nombre like '${buscar}%'";
        if($orden!="false") $sql = $sql." order by '${orden}'";

        
        // dd($sql);
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $registros = $resultSet->fetchAll();
        $n_total = count($registros);

        $total = count($registros);
        $paginas = ceil($total /$filas);
        $registros = array();
        if ($pagina <= $paginas)
        {
            $inicio = ($pagina-1) * $filas;
            $sql = $sql."limit $inicio, $filas";
            // dd($sql);
            $stmt = $conn->prepare($sql);
            $resultSet = $stmt->executeQuery();
            $registros = $resultSet->fetchAll(); 
        }
        return $registros;
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
