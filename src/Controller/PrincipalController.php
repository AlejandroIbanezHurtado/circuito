<?php

namespace App\Controller;

use App\Entity\Modelo;
use App\Entity\Usuario;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PrincipalController extends AbstractController
{
    /**
     * @Route("/conocenos", name="conocenos")
     */
    public function conocenos(): Response
    {
        return $this->render('conocenos.html.twig', [
        ]);
    }

    /**
     * @Route("/error", name="error")
     */
    public function error(): Response
    {
        return $this->render('bundles/TwigBundle/Exception/error.html.twig', [
        ]);
    }

    /**
     * @Route("/index", name="index")
     */
    public function index(): Response
    {
        return $this->render('index.html.twig', [
        ]);
    }

    /**
     * @Route("/servicios", name="servicios")
     */
    public function servicios(): Response
    {
        return $this->render('servicios.html.twig', [
        ]);
    }

    /**
     * @Route("/vehiculos", name="vehiculos")
     */
    public function vehiculos(): Response
    {
        return $this->render('vehiculos.html.twig', [
        ]);
    }

    /**
     * @Route("/ranking", name="ranking")
     */
    public function ranking(): Response
    {
        return $this->render('ranking.html.twig', [
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/perfil", name="perfil")
     */
    public function perfil(): Response
    {
        return $this->render('editar-perfil.html.twig', [
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/misreservas", name="misreservas")
     */
    public function misreservas(): Response
    {
        return $this->render('mis_reservas.html.twig', [
        ]);
    }
}
