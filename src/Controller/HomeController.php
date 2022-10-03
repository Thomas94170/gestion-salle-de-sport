<?php

namespace App\Controller;


use App\Security\Mail;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {



        if($this->getUser() && $this->getUser()->getRoles()== ['ROLE_ADMIN']){
            return $this->redirectToRoute('administration');
        }else if($this->getUser() && $this->getUser()->getRoles()== ['ROLE_USER']){
            return $this->redirectToRoute('mon-compte');
        }else if ($this->getUser() && $this->getUser()->getRoles()== ['ROLE_STRUCTURE']){
            return $this->redirectToRoute('salle' , ['id'=>$this->getUser()->getId()]);
        }else{
            return $this->render('home/index.html.twig',[

                ]


                );

        }


    }
}
