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


    #[Route('/search', name: 'ajax_search')]
    public function searchAction(Request $request, ManagerRegistry $managerRegistry): Response
    {

        $requestString = $request->get('q');

        $entities =  $managerRegistry->getRepository(User::class)->findEntitiesByString($requestString);

        if(!$entities) {
            $result['entities']['error'] = "Aucun élément trouvé";
        } else {
            $result['entities'] = $this->getRealEntities($entities);
        }

        return new Response(json_encode($result));
    }

    public function getRealEntities($entities){

        foreach ($entities as $entity){
            $realEntities[$entity->getId()] = $entity->getName();
        }

        return $realEntities;
    }


    #[Route('/administration', name: 'administration')]
    public function show(ManagerRegistry $doctrine): Response
    {
        $users = $doctrine->getRepository(User::class)->findAll();


        return $this->render('admin/index.html.twig', [
            'user' => $users

        ]);

    }


}