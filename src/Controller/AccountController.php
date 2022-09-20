<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    #[Route('/mon-compte', name: 'mon-compte')]
    public function index(): Response
    {

        $getUser = $this->getUser();


        return $this->render('account/index.html.twig',[
            'user'=>$getUser,


        ]);


    }
}
