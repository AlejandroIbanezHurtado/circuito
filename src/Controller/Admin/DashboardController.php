<?php

namespace App\Controller\Admin;

use App\Entity\Coche;
use App\Entity\Marca;
use App\Entity\Modelo;
use App\Entity\Reserva;
use App\Entity\Usuario;
use App\Entity\Circuito;
use App\Entity\DetalleReserva;
use App\Entity\ValoracionCoche;
use App\Entity\ValoracionCircuito;
use App\Controller\Admin\MarcaCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        // return parent::index();
        // redirect to some CRUD controller
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(CocheCrudController::class)->generateUrl());

        // you can also redirect to different pages depending on the current user
        /*if ('jane' === $this->getUser()->getUsername()) {
            return $this->redirect('...');
        }*/

        // you can also render some template to display a proper Dashboard
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Circuito');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Marcas', 'fas fa-list', Marca::class);
        yield MenuItem::linkToCrud('Modelos', 'fas fa-list', Modelo::class);
        yield MenuItem::linkToCrud('Coches', 'fas fa-list', Coche::class);
        yield MenuItem::linkToCrud('Usuarios', 'fas fa-list', Usuario::class);
        yield MenuItem::linkToCrud('Circuito', 'fas fa-list', Circuito::class);
        yield MenuItem::linkToCrud('Reservas', 'fas fa-list', Reserva::class);
        yield MenuItem::linkToCrud('Valoracion circuito', 'fas fa-list', ValoracionCircuito::class);
        yield MenuItem::linkToCrud('Valoracion coche', 'fas fa-list', ValoracionCoche::class);
    }
}
