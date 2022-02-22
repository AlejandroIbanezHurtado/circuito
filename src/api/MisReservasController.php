<?php

namespace App\api;

use App\Entity\Reserva;
use App\Entity\DetalleReserva;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MisReservasController extends AbstractController
{
    /**
     * @Route("/api/obtenMisReservas", name="obtenMisReservas")
     */
    public function obtenMisReservas(ManagerRegistry $doctrine): Response
    {
        $repositoryCoche = $doctrine->getRepository(Reserva::class);
        if(!isset($_SESSION)) session_start();
        $correo = $_SESSION['_sf2_attributes']['_security.last_username'];
        $reservas = $repositoryCoche->buscarPorCorreo($correo);
        return new Response(json_encode($reservas));
    }

    /**
     * @Route("/api/borraReserva/{id}", name="borrarReserva")
     */
    public function borrarReserva(ManagerRegistry $doctrine, $id): Response
    {
        $entityManager = $doctrine->getManager();
        $repositoryReserva = $doctrine->getRepository(Reserva::class);
        $repositoryDetalleReserva = $doctrine->getRepository(DetalleReserva::class);
        $reserva = $repositoryDetalleReserva->findOneBy(['coche' => $id]);
        $entityManager->remove($reserva);
        $entityManager->flush();
        // dd(json_encode($doctrine));
        return new Response(json_encode($doctrine));
    }
}
