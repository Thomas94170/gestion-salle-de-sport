<?php

namespace App\Controller;

use App\Entity\Service;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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



        //    $franchise = $doctrine->getRepository(User::class)->findOneBy(array('name'=>$name));
      //  $getUser = $this->getUser();
      //  $structure =$user->getStructures();
      //  $service = $doctrine->getRepository(Service::class)->findOneBy(array('name'=>$name));


      //  return $this->render('account/index.html.twig',[
      //      'user'=>$getUser,
      //      'structure'=>$structure,
      //      'franchise'=>$franchise,
      //      'service'=>$service


        ]);


    }
}
