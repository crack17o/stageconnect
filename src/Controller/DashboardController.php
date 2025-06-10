<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    #[Route('/superadmin/dashboard', name: 'superadmin_dashboard')]
    public function superadmin(): Response
    {
        return $this->render('super/index.html.twig');
    }

    #[Route('/entreprise/dashboard', name: 'company_dashboard')]
    public function company(): Response
    {
        return $this->render('entreprise/index.html.twig');
    }

    #[Route('/superviseur/dashboard', name: 'supervisor_dashboard')]
    public function supervisor(): Response
    {
        return $this->render('superviseur/index.html.twig');
    }

    #[Route('/etudiant/dashboard', name: 'student_dashboard')]
    public function student(): Response
    {
        return $this->render('etudiant/index.html.twig');
    }
}