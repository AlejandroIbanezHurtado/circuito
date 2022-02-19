<?php

namespace App\Controller;

use App\Entity\Coche;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReservaController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/reservar/coche/{id}", name="reservar")
     */
    public function reservar(ManagerRegistry $doctrine, int $id): Response
    {
        $repositoryCoche = $doctrine->getRepository(Coche::class);

        $coche = $repositoryCoche->buscarPorId($id);
        $dia = date("d/m/Y",($_GET['inicio'])/1000);
        $horaInicio = date("H:i",($_GET['inicio'])/1000);
        $horaFin = date("H:i",($_GET['fin'])/1000);
        return $this->render('reservar.html.twig', [
            'dia' => $dia,
            'horaInicio' => $horaInicio,
            'horaFin' => $horaFin,
            'coche' => $coche[0]
        ]);
    }
}
