<?php

namespace App\Controller;


use App\Entity\Service;
use App\Entity\Structure;
use App\Entity\User;
use App\Form\OptionsType;
use App\Security\MailModifPermSalle;
use App\Security\MailPermSalle;
use App\Security\MailSalle;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;

class FranchiseController extends AbstractController
{
    #[Route('/franchise/{name}', name: 'franchise')]
    public function show(Request $request, ManagerRegistry $doctrine, $name, User $user, EntityManagerInterface $entityManager): Response
    {
        $fitness = $doctrine->getRepository(User::class)->findOneBy(array('name' => $name));
        /** @var User $getUser */
        $getUser = $this->getUser();
        $structure = $user->getStructures();
        $structurePermission = $user;
        $service = $entityManager->getRepository(Service::class)->findAll();


        //dd($test);
       // dd(  $user->getStructures());
        //formulaire activation desactivation totale d'une franchise

        $activation_form = $this->createFormBuilder()
            ->add( 'activation',SubmitType::class,[

            ])->getForm();

        $activation_form->handleRequest($request);
        if ($activation_form->isSubmitted()&& $activation_form->isValid()){


                $fitness->setIsActive(!$fitness->isIsActive());

            $entityManager->persist($fitness);
            $entityManager->flush();
        }
        //form des permissions

        $form = $this->createFormBuilder()
            ->add('permok', SubmitType::class)
            ->add('permission', EntityType::class, [
                'class' => Service::class,
                'multiple' => true,
                'expanded' => true,
                'data' => $fitness->getPermission($service)
            ])->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            //envoi mail

            $mail = new MailPermSalle();
            $mail->send($fitness->getEmail(),'','Modification des permissions liées à votre contrat','');
              //  dd($structurePermission->getStructures()->getOwner()->getStructures());
           // dd($structure->getStructures());
            $mailModifPermSalle = new MailModifPermSalle();
            $mailModifPermSalle->send($structurePermission->getEmail(),'','Modification des permissions accordées à votre salle','');


            //mes services sont ajoutés à mes structure
            foreach ($form->getData()['permission'] as $serviceId) {
                $service = $entityManager->getRepository(Service::class)->find($serviceId);
                $fitness->addPermission($service);
            };
            $entityManager->persist($fitness);
            $entityManager->flush();
        }


        if ($getUser->getRoles() == ['ROLE_ADMIN'] && $name == $getUser->getName()) {
            return $this->redirectToRoute('franchise', ['name' => $getUser->getName()]);
        }



        return $this->render('franchise/index.html.twig', [
            'form' => $form->createView(),
            'structure' => $structure,
            'fitness' => $fitness,
            'user' => $getUser,
            'activation_form'=>$activation_form->createView()
        ]);
    }

}








