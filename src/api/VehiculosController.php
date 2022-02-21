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

class VehiculosController extends AbstractController
{
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

        // $data = [];
        // foreach ($marcas as &$valor) {
        //     $data[] = $valor->getNombre();
        // }

        $obj->marcas = $marcas;
        $obj->n_coches = $n_coches;
        $obj->coches = $repositoryCoche->obtenCochesPaginados($pagina,$filas);
        return new Response(json_encode($obj));
    }
}
