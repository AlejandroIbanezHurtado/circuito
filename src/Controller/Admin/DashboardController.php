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
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
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
        yield MenuItem::linkToCrud('Marcas', 'fa fa-circle-thin', Marca::class);
        yield MenuItem::linkToCrud('Modelos', 'fa fa-circle-thin', Modelo::class);
        yield MenuItem::linkToCrud('Coches', 'fa fa-car', Coche::class);
        yield MenuItem::linkToCrud('Usuarios', 'fas fa-user', Usuario::class);
        yield MenuItem::linkToCrud('Circuito', 'fas fa-list', Circuito::class);
        yield MenuItem::linkToCrud('Reservas', 'fa fa-clock-o', Reserva::class);
        yield MenuItem::linkToCrud('Detalle reservas', 'fa fa-clock-o', DetalleReserva::class);
        yield MenuItem::linkToCrud('Valoracion circuito', '	fa fa-comment-o', ValoracionCircuito::class);
        yield MenuItem::linkToCrud('Valoracion coche', '	fa fa-comment-o', ValoracionCoche::class);
    }
}
