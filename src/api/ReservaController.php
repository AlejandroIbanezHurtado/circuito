<?php

namespace App\api;

use DateTime;
use App\Entity\Coche;
use App\Entity\Reserva;
use App\Entity\Usuario;
use App\Entity\DetalleReserva;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReservaController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("api/hacerReserva/{ids}/{precio}/{inicio}/{fin}", name="hacerReserva")
     */
    public function reservar(ManagerRegistry $doctrine, $ids, $precio, $inicio, $fin): Response
    {
        $entityManager = $doctrine->getManager();
        $repositoryCoche = $doctrine->getRepository(Coche::class);
        $repositoryReserva = $doctrine->getRepository(Reserva::class);
        $repositoryDetalleReserva = $doctrine->getRepository(DetalleReserva::class);
        $repositoryUsuario = $doctrine->getRepository(Usuario::class);

        $correo = $_SESSION['_sf2_attributes']['_security.last_username'];
        $usuario = $repositoryUsuario->findOneBy(['email' => $correo]);
        $ids = json_decode($ids);

        $reserva = new Reserva();
        $reserva->setPrecio($precio);
        $reserva->setUsuario($usuario);
        $reserva->setFechaInicio(new DateTime($inicio));
        $reserva->setFechaFin(new DateTime($fin));
        $entityManager->persist($reserva);
        $entityManager->flush();
        
        $id_reserva = $repositoryReserva->findOneBy([], ['id' => 'desc']);
        for($i=0;$i<count($ids);$i++)
        {
            $detalleReserva = new DetalleReserva();
            $coche = $repositoryCoche->findOneBy(['id' => $ids[$i]]);
            $detalleReserva->setCoche($coche);
            $detalleReserva->setReserva($id_reserva);
            $entityManager->persist($detalleReserva);
            $entityManager->flush();
        }
        
        return new Response("OK");
    }
}
