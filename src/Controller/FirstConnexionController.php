<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class FirstConnexionController extends AbstractController
{
    #[Route('/first/connexion', name: 'app_first_connexion')]


    public function index(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        /** @var  $user User */
        $user = $this->getUser();

        if ($user->getRoles() == ['ROLE_ADMIN']) {
            return $this->redirectToRoute('administration');
        } elseif ($user->isVerified()) {
            if ($user->getRoles() == ['ROLE_USER']) {
                return $this->redirectToRoute("mon-compte");
            } else {
                return $this->redirectToRoute("salle", ['id' =>  $user->getId()]);
            }
        }





        $form = $this->createFormBuilder()
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux champs doivent être identiques',
                'required' => true,
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Répétez le mot de passe'],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Sauvegarder le changement'
            ])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );



            $user->setIsVerified(true);
            $entityManager->persist($user);
            $entityManager->flush();

           


                if ($user->getRoles()== ['ROLE_USER']) {
                    return $this->redirectToRoute("mon-compte");
                } else {
                    return $this->redirectToRoute("app_first_connexion");
                   // return $this->redirectToRoute("salle", ['id' =>  $user->getId()]);
                }



        }
        return $this->render('first_connexion/index.html.twig', [
            'formFirst' => $form->createView()
        ]);
    }
}
