<?php

namespace App\Controller;


use App\Entity\Service;
use App\Entity\User;
use App\Form\OptionsType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FranchiseController extends AbstractController
{


    #[Route('/franchise/{name}', name: 'franchise')]
    public function show(Request $request,ManagerRegistry $doctrine,$name, User $user): Response
    {
        $fitness = $doctrine->getRepository(User::class)->findOneBy(array('name'=>$name));
        $getUser = $this->getUser();
        $structure = $user->getStructures();
         $service = $doctrine->getRepository(Service::class)->findAll();

        $form = $this->createFormBuilder()
            ->add('service', EntityType::class,[
                'class'=>Service::class,
                'multiple'=>true,
                'expanded'=>true
            ])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->get('service')->getViewData();


            return $this->redirectToRoute('franchise');
        }


        if($getUser ->getRoles() != ['ROLE_ADMIN'] && $name != $getUser->getName()){
            return $this->redirectToRoute('franchise', ['name' => $getUser->getName()]);
        }

        if (!$fitness) {
            return $this->redirectToRoute('connexion',);
        }


        return $this->render('franchise/index.html.twig', [
            'form' => $form->createView(),
        'structure' => $structure,
        'fitness' => $fitness,
            'user'=>$getUser,
           'service'=>$service

        ]);



    }
}