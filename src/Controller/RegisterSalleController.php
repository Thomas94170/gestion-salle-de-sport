<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterSalleController extends AbstractController
{
    #[Route('/register/salle', name: 'app_register_salle')]
    public function index(): Response
    {
        return $this->render('register_salle/index.html.twig', [
            'controller_name' => 'RegisterSalleController',
        ]);
    }
}
