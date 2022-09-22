<?php

// src/Controller/ProductController.php
namespace App\Controller;


use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// ...

class AdminController extends AbstractController
{
    #[Route('/administration', name: 'administration')]
    public function show(ManagerRegistry $doctrine): Response
    {
        $users = $doctrine->getRepository(User::class)->findAll();


        return $this->render('admin/index.html.twig', [
            'user' => $users

        ]);

    }


}