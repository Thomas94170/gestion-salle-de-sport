<?php


namespace App\Controller;

use App\Entity\Structure;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SalleController extends AbstractController
{


    #[Route('/salle/{id}', name: 'salle' ,methods: ['GET'])]

    public function index($id, ManagerRegistry $managerRegistry): Response
    {
         $fitness = $managerRegistry->getRepository(User::class)->findAll();

        $structure = $managerRegistry->getRepository(Structure::class)->findOneBy(array('id'=>$id));




         $name = $this->getUser()->getName();

        if($this->getUser()->getRoles() == ['ROLE_ADMIN'])
        {
            $options =(new \App\Entity\User)->getOption();
        }else{
            $options = $this->getUser()->getOption();
        }

        if(!$fitness){
            return $this->redirectToRoute('connexion');
        }

        return $this->render('salle/index.html.twig',[
            'structure' => $structure,
            'option' => $options,
            'user' => $name,

        ]);

    }
}





