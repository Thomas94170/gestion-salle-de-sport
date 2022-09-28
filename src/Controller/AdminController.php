<?php

// src/Controller/ProductController.php
namespace App\Controller;


use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// ...

class AdminController extends AbstractController
{
    //barre de recherche dynamique


    #[Route('/administration', name: 'administration')]
    public function show(ManagerRegistry $doctrine, Request $request): Response
    {

        if ($_POST) {
            $result = json_decode($request->request->get('data'), true);
            $result = $result['data'][0]['value'];
            $users = $doctrine->getRepository(User::class)->findBySearch($result);
            dump($users);
        } else {
            $users = $doctrine->getRepository(User::class)->findAll();
        }
        return $this->render('admin/index.html.twig', [
            'user' => $users

        ]);

    }

    #[Route('/administration/actif', name: 'actif')]
    public function actif(ManagerRegistry $doctrine, Request $request): Response
    {

        if ($_POST) {

            $users = $doctrine->getRepository(User::class)->findBy(array('isActive'=>true));
            dump($users);
        } else {
            $users = $doctrine->getRepository(User::class)->findAll();
        }
        return $this->render('admin/index.html.twig', [
            'user' => $users

        ]);

    }

    #[Route('/administration/inactif', name: 'inactif')]
    public function inactif(ManagerRegistry $doctrine, Request $request): Response
    {

        if ($_POST) {
            $users = $doctrine->getRepository(User::class)->findBy(array('isActive'=>false));
            dump($users);
        } else {
            $users = $doctrine->getRepository(User::class)->findAll();
        }
        return $this->render('admin/index.html.twig', [
            'user' => $users

        ]);

    }

    #[Route('/administration/reset', name: 'reset')]
    public function reset(ManagerRegistry $doctrine, Request $request): Response
    {

        if ($_POST) {
            $users = $doctrine->getRepository(User::class)->findAll();
            dump($users);

        }
        return $this->render('admin/index.html.twig', [
            'user' => $users

        ]);

    }

}










