<?php

namespace App\api;

use DateTime;
use stdClass;
use App\Entity\Coche;
use App\Entity\Reserva;
use App\Entity\Usuario;
use App\Entity\DetalleReserva;
use App\Entity\ValoracionCoche;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
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

    /**
     * @IsGranted("ROLE_USER")
     * @Route("api/hacerReservaCircuito/{precio}/{inicio}/{fin}", name="hacerReservaCircuito")
     */
    public function hacerReservarCircuito(ManagerRegistry $doctrine, $precio, $inicio, $fin): Response
    {
        $entityManager = $doctrine->getManager();
        $repositoryCoche = $doctrine->getRepository(Coche::class);
        $repositoryReserva = $doctrine->getRepository(Reserva::class);
        $repositoryUsuario = $doctrine->getRepository(Usuario::class);

        $correo = $_SESSION['_sf2_attributes']['_security.last_username'];
        $usuario = $repositoryUsuario->findOneBy(['email' => $correo]);

        $reserva = new Reserva();
        $reserva->setPrecio($precio);
        $reserva->setUsuario($usuario);
        $reserva->setFechaInicio(new DateTime($inicio));
        $reserva->setFechaFin(new DateTime($fin));
        $entityManager->persist($reserva);
        $entityManager->flush();
        
        return new Response("OK");
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("api/obtenComentarios/{id}", name="obtenComentarios")
     */
    public function comentarios(ManagerRegistry $doctrine, $id): Response
    {
        // $repositoryDetalleReserva = $doctrine->getRepository(DetalleReserva::class);
        $repositoryValoracion = $doctrine->getRepository(ValoracionCoche::class);

        $comentarios = $repositoryValoracion->valoracionesPorId($id);
        return new Response(json_encode($comentarios));
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("api/insertaComentario", name="insertaComentario")
     */
    public function insertaComentario(ManagerRegistry $doctrine): Response
    {
        $repositoryValoracion = $doctrine->getRepository(ValoracionCoche::class);
        $repositoryUsuario = $doctrine->getRepository(Usuario::class);

        if(empty($_SESSION))
        {
            session_start();
        }
        $correo = $_SESSION['_sf2_attributes']['_security.last_username'];
        
        $user = $repositoryUsuario->findOneBy(array('email' => $correo));
        $valoracion = $_POST['valoracion'];
        $comentario = $_POST['comentario'];
        $coche = $_POST['coche'];

        $comentarios = $repositoryValoracion->crearComentario($user->getId(),$valoracion,$comentario,$coche);
        if($comentarios==NULL) return new Response("NULL");
        return new Response(json_encode($user));
    }

    /**
     * @Route("api/insertaFechaSesion/{fecha}/{marca}", name="insertaFecha")
     */
    public function insertaFechaSesion(ManagerRegistry $doctrine, $fecha, $marca=0): Response
    {
        $session = new Session();
        if(!isset($_SESSION)) $session->start();
        $session->set('fecha', $fecha);
        $session->set('marca', $marca);
        return new Response("OK");
    }

    /**
     * @Route("api/dameFechaSesion", name="dameFechaSesion")
     */
    public function dameFechaSesion(ManagerRegistry $doctrine): Response
    {
        $session = new Session();
        if(!isset($_SESSION)) $session->start();
        $fecha = $session->get('fecha');
        $marca = $session->get('marca');
        $obj = new stdClass;
        $obj->fecha = $fecha;
        $obj->marca = $marca;
        return new Response(json_encode($obj));
    }
}
