<?php

namespace App\Controller;

use App\Entity\Structure;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SalleController extends AbstractController
{


    #[Route('/salle/{id}', name: 'salle')]
    public function index($id ,ManagerRegistry $managerRegistry): Response
    {
        $structure = $managerRegistry->getRepository(Structure::class)->findOneBy(array('id'=>$id));
        $options = $this->getUser()->getOption();
        $name = $this->getUser()->getName();

        if(!$structure){
            return $this->redirectToRoute('franchise');
        }

        return $this->render('salle/index.html.twig',[
            'structure' => $structure,
            'option' => $options,
            'user' => $name
        ]);

    }
}
