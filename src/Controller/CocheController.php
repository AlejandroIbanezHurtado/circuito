<?php

namespace App\Controller;

use stdClass;
use App\Entity\Coche;
use App\Entity\Marca;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CocheController extends AbstractController
{
    /**
     * @Route("/api/obtenIndex", name="obtenIndex")
     */
    public function obtenIndex(ManagerRegistry $doctrine): Response
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
        $aleatorios = $repositoryCoche->findAleatorios();
        // var_dump($aleatorios);
        $obj->marcas = $data;
        $obj->n_coches = $n_coches;
        $obj->coches = $aleatorios;
        return new Response(json_encode($obj));
    }
}