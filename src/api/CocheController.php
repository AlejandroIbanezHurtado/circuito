<?php

namespace App\api;

use stdClass;
use App\Entity\Coche;
use App\Entity\Marca;
use App\Entity\ValoracionCoche;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CocheController extends AbstractController
{
    /**
     * @Route("api/obtenVehiculosPaginados/{pagina}/{filas}", name="obtenVehiculosPaginados")
     */
    public function obtenVehiculosPaginados(ManagerRegistry $doctrine, int $pagina=1, int $filas=2): Response
    {
        $obj = new stdClass();
        $repositoryCoche = $doctrine->getRepository(Coche::class);

        $obj->coches = $repositoryCoche->obtenCochesPaginados($pagina,$filas);
        $obj->total_coches = count($repositoryCoche->obtenTotalCoches());
        return new Response(json_encode($obj));
    }

    /**
     * @Route("api/obtenVehiculosNoFechas/{fecha_inicio}/{fecha_fin}/{ids}", name="obtenVehiculosNoFechas")
     */
    public function obtenVehiculosNoFechas(ManagerRegistry $doctrine, $fecha_inicio, $fecha_fin, $ids): Response
    {
        $obj = new stdClass();
        $repositoryCoche = $doctrine->getRepository(Coche::class);

        $obj->coches = $repositoryCoche->buscarCochesNoFechas($fecha_inicio,$fecha_fin,$ids);
        return new Response(json_encode($obj));
    }

    /**
     * @Route("api/obtenVehiculosPaginadosNoFechas/{fechaInicio}/{fechaFin}/{pagina}/{filas}/{marca}/{buscar}/{orden}", name="obtenVehiculosPaginadosNoFechas")
     */
    public function obtenVehiculosPaginadosNoFechas(ManagerRegistry $doctrine, int $pagina=1, int $filas=2,$fechaInicio,$fechaFin,$marca,$buscar,$orden): Response
    {
        $obj = new stdClass();
        $repositoryCoche = $doctrine->getRepository(Coche::class);

        $obj->coches = $repositoryCoche->obtenCochesPaginadosNoFechas($fechaInicio,$fechaFin,$pagina,$filas,$marca,$buscar,$orden);
        return new Response(json_encode($obj));
    }

    /**
     * @Route("api/obtenVehiculo/{id}", name="obtenVehiculoId")
     */
    public function obtenVehiculo(ManagerRegistry $doctrine, $id): Response
    {
        $repositoryCoche = $doctrine->getRepository(Coche::class);
        $obj = $repositoryCoche->buscarCocheId($id);
        return new Response(json_encode($obj));
    }

}