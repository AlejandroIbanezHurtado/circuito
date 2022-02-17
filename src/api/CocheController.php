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
    // $obj->coches = $repositoryCoche->obtenCochesPaginados(2,2);
}