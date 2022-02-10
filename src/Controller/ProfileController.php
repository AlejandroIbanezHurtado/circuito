<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    /**
     * @Route("/perfil", name="profile")
     */
    public function editar(): Response
    {
        return $this->render('editar-perfil.html.twig', [
            
        ]);
    }
}
