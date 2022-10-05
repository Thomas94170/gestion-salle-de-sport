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
///salle/{name}/{id}

    #[Route('/salle/{id}', name: 'salle')]
    public function index($id, ManagerRegistry $managerRegistry, Request $request, EntityManagerInterface $entityManager): Response
    {
        // $name findOneBy(array('name'=>$name));
        $fitness = $managerRegistry->getRepository(User::class)->findAll();

        $structure = $managerRegistry->getRepository(Structure::class)->findOneBy(array('id' => $id));

       // $serviceSalle =  $managerRegistry->getRepository(Service::class)->findAll();

        $serviceAll =  $managerRegistry->getRepository(Service::class)->findAll();

        $service = $structure->getProprietaire()->getPermission($serviceAll);
       // dd($structure);
        //formulaire permission

     ////////////       ->add('permok', SubmitType::class)
     //////       ->add('permission', EntityType::class, [
     //////           'class' => Service::class,
     //////           'choices'=>$fitness->getPermission(),
     //////           'multiple' => true,
     //////           'expanded' => true,
     //////           'data' => $structure->getPermission()
     //////       ])->getForm();

     //////   $form->handleRequest($request);
     //////   if ($form->isSubmitted() && $form->isValid()) {

            //envoi mail
    ////    $mail = new MailPermSalle();
    ////    $mail->send($fitness->getEmail(),'','Modification des permissions liées à votre contrat','');

    ////          $mailModifPermSalle = new MailModifPermSalle();
    ////          $mailModifPermSalle->send($structure->getEmail(),'','Modification des permissions accordées à votre salle','');
    ////    }

        //mes services sont ajoutés à mes structure
    //    foreach ($form->getData()['permission'] as $serviceId) {
    //        $service = $entityManager->getRepository(Service::class)->find($serviceId);
    //        $fitness->addPermission($service);
    //    };
    //    $entityManager->persist($fitness);
     //   $entityManager->flush();

    //    if ($this->getUser()->getRoles() == ['ROLE_ADMIN']) {
    //        $id = $managerRegistry->getRepository(User::class)->findUser($name);
    //        $user = $managerRegistry->getRepository(User::class)->findPermissions($id);
    //        if (isset($user[0])) {
    //            $permission = $user[0]->getPermission();

    //        } else {
    //            $permission = '';
    //        }
    //    } else {
     //       $permission = $this->getUser()->getPermission();
     //   }



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
               // 'form' => $form->createView(),
                'structure' => $structure,
                'option' => $options,
                 'user' => $user,
                'service'=>$service,
                'fitness'=>$fitness,
             //   'permission'=>$permission


            ]);

        }

}





