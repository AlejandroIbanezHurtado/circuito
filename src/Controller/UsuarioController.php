<?php

namespace App\Controller;

use App\Entity\Usuario;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UsuarioController extends AbstractController
{
    /**
     * @Route("/usuario", name="usuario")
     */
    public function index(ManagerRegistry $doctrine): Response//prueba para json de usuarios
    {
        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getName();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        
        $serializer = new Serializer([$normalizer], [$encoder]);
        $todos = $doctrine->getRepository(Usuario::class)->findAll();
        var_dump($serializer->serialize($todos, 'json'));
        return $this->render('usuario/index.html.twig', [
            'controller_name' => 'UsuarioController',
        ]);
    }

    /**
     * @Route("/api/editaUsuario", name="editaUsuario")
     */
    public function editaUsuario(ManagerRegistry $doctrine): Response
    {
        if(empty($_SESSION))
        {
            session_start();
        }
        $correo = $_SESSION['_sf2_attributes']['_security.last_username'];
        
        // var_dump($_POST["correo"]["value"]);
        $user = new Usuario();
        $user->setEmail($_POST["correo"]["value"]);
        $user->setNombre($_POST["nombre"]["value"]);
        $user->setApellidos($_POST["apellidos"]["value"]);
        // $user->setImagen($_POST["imagen"]["value"]);
        $entityManager = $doctrine->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->render('api/index.html.twig', [
            "respuesta" => $_POST
        ]);
        // return new Response($_SESSION);
    }
}
