<?php

namespace App\Controller\Admin;

use App\Controller\Admin\UserCrudController;
use App\Entity\Actor;
use App\Entity\Movie;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(MovieCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Movies')
            ->disableDarkMode();
            // ->setTextDirection('rtl');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Movies', 'fas fa-video', Movie::class);
        yield MenuItem::linkToCrud('Actors', 'fas fa-user-secret', Actor::class);
        yield MenuItem::subMenu('Blog', 'fa fa-newspaper')->setSubItems([
            MenuItem::linkToCrud('Categories', 'fa fa-tags', Movie::class),
            MenuItem::linkToCrud('Posts', 'fa fa-file-text', Movie::class),
            MenuItem::linkToCrud('Comments', 'fa fa-comment', Movie::class),
        ]);
        yield MenuItem::section('Setting');
        yield MenuItem::linkToCrud('Users', 'fas fa-users', User::class);
        yield MenuItem::linkToRoute('Api', 'fa fa-file-code', 'api');
        yield MenuItem::linkToLogout('Logout', 'fa fa-arrow-right-from-bracket');

        yield MenuItem::section('FrontEnd');
        yield MenuItem::linkToRoute('Movies List', 'fa fa-video', 'movies');
    }
}
