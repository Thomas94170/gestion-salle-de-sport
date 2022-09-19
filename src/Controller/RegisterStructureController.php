<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterStructureController extends AbstractController
{
    #[Route('/register/structure', name: 'app_register_structure')]
    public function index(): Response
    {
        return $this->render('register_structure/index.html.twig');
    }
}
