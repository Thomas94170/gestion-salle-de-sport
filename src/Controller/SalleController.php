<?php


namespace App\Controller;

use App\Entity\Service;
use App\Entity\Structure;

use App\Entity\User;
use App\Form\OptionsType;
use App\Security\MailPermSalle;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SalleController extends AbstractController
{


    #[Route('/salle/{id}', name: 'salle', methods: ['GET'])]
    public function index($id, ManagerRegistry $managerRegistry, Request $request, EntityManagerInterface $entityManager): Response
    {
        $fitness = $managerRegistry->getRepository(User::class)->findAll();

        $structure = $managerRegistry->getRepository(Structure::class)->findOneBy(array('id' => $id));

       // $serviceSalle =  $managerRegistry->getRepository(Service::class)->findAll();

        $serviceAll =  $managerRegistry->getRepository(Service::class)->findAll();
        $service = $structure->getProprietaire()->getPermission($serviceAll);

        //formulaire permission
       // $form = $this->createFormBuilder()
        //    ->add('permok', SubmitType::class)
       //     ->add('permission', EntityType::class, [
       //         'class' => Service::class,
       //         'multiple' => true,
       //         'expanded' => true,
       //         'data' => $fitness->getPermission()
       //     ])->getForm();

       // $form->handleRequest($request);
       // if ($form->isSubmitted() && $form->isValid()) {

            //envoi mail

       //     $mail = new MailPermSalle();
       //     $mail->send($fitness->getEmail(), '', 'Modification des permissions liées à votre contrat', '');

            //  $mailModifPermSalle = new MailModifPermSalle();
            //  $mailModifPermSalle->send($structure->getEmail(),'','Modification des permissions accordées à votre salle','');
       // }


        //mes services sont ajoutés à mes structure
       // foreach ($form->getData()['permission'] as $serviceId) {
       //     $service = $entityManager->getRepository(Service::class)->find($serviceId);
       //     $fitness->addPermission($service);
       // };
       // $entityManager->persist($fitness);
       // $entityManager->flush();





            $user = $this->getUser();

            if ($this->getUser()->getRoles() == ['ROLE_ADMIN']) {
                $options = (new \App\Entity\User)->getOption();
            } else {
                $options = $this->getUser()->getOption();
            }

            if (!$fitness) {
                return $this->redirectToRoute('connexion');
            }

            return $this->render('salle/index.html.twig', [
          //      'form' => $form->createView(),
                'structure' => $structure,
                'option' => $options,
                 'user' => $user,
                'service'=>$service


            ]);

        }

}





