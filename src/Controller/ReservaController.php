<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReservaController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/reserva", name="reserva")
     */
    public function index(): Response
    {
        return $this->render('reserva/index.html.twig', [
            'controller_name' => 'ReservaController',
        ]);
    }
}
