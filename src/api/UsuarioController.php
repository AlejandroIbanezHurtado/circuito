<?php

namespace App\api;

use App\Entity\Usuario;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
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
                return $object->getNombre();
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
    public function editaUsuario(ManagerRegistry $doctrine, ValidatorInterface $validator): Response
    {
        if(empty($_SESSION))
        {
            session_start();
        }
        $correo = $_SESSION['_sf2_attributes']['_security.last_username'];

        $repository = $doctrine->getRepository(Usuario::class);
        $user = $repository->findOneBy(array('email' => $correo));
        $user->setNombre($_POST["nombre"]);
        $user->setApellidos($_POST["apellidos"]);

        if(isset($_FILES['file']))
        {
            $nombre = "images/".time().rand(1,99999).$_FILES['file']['name'];
            move_uploaded_file($_FILES["file"]["tmp_name"], $nombre);
            $imagenAntigua = $user->getImagen();
            $user->setImagen($nombre);
        }

        $errores = $validator->validate($user);
        if(count($errores)==0)
        {
            if(isset($_FILES['file'])) if($imagenAntigua!=null) unlink($imagenAntigua);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        }
        $array = [];
        foreach ($errores as &$valor) {
            $array[] = $valor->getMessage();
        }
        // dd(json_encode($array));
        return new Response(json_encode($array));
        // return $this->render('api/index.html.twig', [
        //     'respuesta' => $errores
        // ]);
    }
}
