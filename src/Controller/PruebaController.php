<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class PruebaController extends AbstractController
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
        return $this->render('perfil.html.twig', [
        ]);
    }
}
