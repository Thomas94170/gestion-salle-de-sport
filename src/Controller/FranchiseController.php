<?php

namespace App\Controller;


use App\Entity\Service;
use App\Entity\User;
use App\Form\OptionsType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FranchiseController extends AbstractController
{




    #[Route('/franchise/{name}', name: 'franchise')]
    public function show(Request $request,ManagerRegistry $doctrine,$name, User $user, EntityManagerInterface $entityManager): Response
    {
        $fitness = $doctrine->getRepository(User::class)->findOneBy(array('name'=>$name));
        $getUser = $this->getUser();
        $structure = $user->getStructures();


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

            for ($i=0;$i<=count($data)-1;$i++){
                $id = $data[$i];
                $service = $doctrine->getRepository(Service::class)->findOneBy(array('id'=>$id));
                $fitness->addPermission($service);
                $entityManager->persist($fitness);
                $entityManager->persist($service);
                $entityManager->flush();

            }



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


        ]);



    }
}