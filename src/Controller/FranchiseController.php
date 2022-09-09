<?php

namespace App\Controller;


use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FranchiseController extends AbstractController
{


    #[Route('/franchise/{name}', name: 'franchise')]
    public function show(ManagerRegistry $doctrine,$name, User $user): Response
    {
        $fitness = $doctrine->getRepository(User::class)->findOneBy(array('name'=>$name));

        $getName = $this->getUser()->getName();


        $structures = $user->getStructures();
        $options = $user->getOption();
        if($name != $getName){
            return $this->redirectToRoute('administration', ['name' => $getName]);
        }

        if (!$fitness) {
            return $this->redirectToRoute('connexion',);
        }


        return $this->render('franchise/index.html.twig', [
        'structures' => $structures,
        'fitness' => $fitness,
            'options' => $options,

        ]);



    }
}