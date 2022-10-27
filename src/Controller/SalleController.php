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


    #[Route('/salle/{id}', name: 'salle')]
    public function index($id, ManagerRegistry $managerRegistry, Request $request, EntityManagerInterface $entityManager): Response
    {
        // $name findOneBy(array('name'=>$name));
        $fitness = $managerRegistry->getRepository(User::class)->findAll();

        $structure = $managerRegistry->getRepository(Structure::class)->findOneBy(array('id' => $id));



        $serviceAll =  $managerRegistry->getRepository(Service::class)->findAll();

        $service = $structure->getProprietaire()->getPermission($serviceAll);


            $user = $this->getUser();

            if ($this->getUser()->getRoles() == ['ROLE_ADMIN']) {
                $options = (new \App\Entity\User)->getOption();
            } else {
                $options = $this->getUser()->getPermission();
            }

            if (!$fitness) {
                return $this->redirectToRoute('connexion');
            }

            return $this->render('salle/index.html.twig', [
                'structure' => $structure,
                'option' => $options,
                 'user' => $user,
                'service'=>$service,
                'fitness'=>$fitness,


            ]);

        }

}





