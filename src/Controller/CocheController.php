<?php

namespace App\Controller;

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
     * @Route("api/obtenIndex", name="obtenIndex")
     */
    public function obtenIndex(ManagerRegistry $doctrine): Response
    {
        $obj = new stdClass();
        $repositoryCoche = $doctrine->getRepository(Coche::class);
        $repositoryMarca = $doctrine->getRepository(Marca::class);
        $repositoryValoracionCoche = $doctrine->getRepository(ValoracionCoche::class);
        $marcas = $repositoryMarca->findAll();
        $n_coches = $repositoryCoche->countCoche();

        $data = [];
        foreach ($marcas as &$valor) {
            $data[] = $valor->getNombre();
        }
        $aleatorios = $repositoryValoracionCoche->findMejoresValoraciones();
        $comentarios = $repositoryValoracionCoche->valoracionesAleatorias();
        $obj->marcas = $data;
        $obj->n_coches = $n_coches;
        $obj->coches = $aleatorios;
        $obj->comentarios = $comentarios;
        return new Response(json_encode($obj));
    }

    /**
     * @Route("api/obtenVehiculos", name="obtenVehiculos")
     */
    public function obtenVehiculos(ManagerRegistry $doctrine, int $pagina=1, int $filas=6): Response
    {
        $obj = new stdClass();
        $repositoryCoche = $doctrine->getRepository(Coche::class);
        $repositoryMarca = $doctrine->getRepository(Marca::class);
        $marcas = $repositoryMarca->findAll();
        $n_coches = $repositoryCoche->countCoche();

        $data = [];
        foreach ($marcas as &$valor) {
            $data[] = $valor->getNombre();
        }

        $obj->marcas = $data;
        $obj->n_coches = $n_coches;
        $obj->coches = $repositoryCoche->obtenCochesPaginados($pagina,$filas);
        return new Response(json_encode($obj));
    }

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
    // $obj->coches = $repositoryCoche->obtenCochesPaginados(2,2);
}