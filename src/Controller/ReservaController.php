<?php

namespace App\Controller;

use App\Entity\Coche;
use App\Entity\Circuito;
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

        $tramo = (($_GET['fin']-$_GET['inicio'])/60000)/30;
        $coche = $repositoryCoche->buscarPorId($id);
        $dia = date("d/m/Y",($_GET['inicio'])/1000);
        $horaInicio = date("H:i",($_GET['inicio']+3600000)/1000);
        $horaFin = date("H:i",($_GET['fin']+3600000)/1000);
        return $this->render('reservar.html.twig', [
            'dia' => $dia,
            'horaInicio' => $horaInicio,
            'horaFin' => $horaFin,
            'coche' => $coche[0],
            'tramo' => $tramo
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/reservar/circuito", name="reservarCircuito")
     */
    public function reservarCircuito(ManagerRegistry $doctrine): Response
    {
        $repositoryCoche = $doctrine->getRepository(Coche::class);
        $repositoryCircuito = $doctrine->getRepository(Circuito::class);
        $circuito = $repositoryCircuito->findOneBy(['id' => 1]);

        $tramo = (($_GET['fin']-$_GET['inicio'])/60000)/30;
        $dia = date("d/m/Y",($_GET['inicio'])/1000);
        $horaInicio = date("H:i",($_GET['inicio']+3600000)/1000);
        $horaFin = date("H:i",($_GET['fin']+3600000)/1000);
        // dd($circuito);
        return $this->render('reservarCircuito.html.twig', [
            'dia' => $dia,
            'horaInicio' => $horaInicio,
            'horaFin' => $horaFin,
            'tramo' => $tramo,
            'foto' => $circuito->getFoto(),
            'precio' => $circuito->getPrecioCircuito()
        ]);
    }
}
