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
    public function show(Request $request, ManagerRegistry $doctrine, $name, User $user, EntityManagerInterface $entityManager): Response
    {
        $fitness = $doctrine->getRepository(User::class)->findOneBy(array('name' => $name));
        /** @var User $getUser */
        $getUser = $this->getUser();
        $structure = $user->getStructures();
        $service = $entityManager->getRepository(Service::class)->findAll();

        if (!$fitness) {
            return $this->redirectToRoute('connexion',);
        }

        $form = $this->createFormBuilder()
            ->add('permission', EntityType::class, [
                'class' => Service::class,
                'multiple' => true,
                'expanded' => true,
                'data' => $fitness->getPermission($service)
            ])->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            foreach ($form->getData()['permission'] as $serviceId) {
                $service = $entityManager->getRepository(Service::class)->find($serviceId);
                $fitness->addPermission($service);
            };
            $entityManager->persist($fitness);
            $entityManager->flush();
        }

        if ($getUser->getRoles() != ['ROLE_ADMIN'] && $name != $getUser->getName()) {
            return $this->redirectToRoute('franchise', ['name' => $getUser->getName()]);
        }

        return $this->render('franchise/index.html.twig', [
            'form' => $form->createView(),
            'structure' => $structure,
            'fitness' => $fitness,
            'user' => $getUser,
        ]);
    }
        //gestion des options modifié en bdd
}








