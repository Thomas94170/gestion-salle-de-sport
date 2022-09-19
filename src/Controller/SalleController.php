<?php


namespace App\Controller;

use App\Entity\Structure;

use App\Entity\User;
use App\Form\OptionsType;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SalleController extends AbstractController
{


    #[Route('/salle/{id}', name: 'salle', methods: ['GET'])]
    public function index($id, ManagerRegistry $managerRegistry, Request $request): Response
    {
        $fitness = $managerRegistry->getRepository(User::class)->findAll();

        $structure = $managerRegistry->getRepository(Structure::class)->findOneBy(array('id' => $id));

       // $form = $this->createForm(OptionsType::class);

         // $form->handleRequest($request);
       // if ($form->isSubmitted() && $form->isValid()) {

          //  return $form->getData();
      //  }
              $name = $this->getUser()->getName();

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
              //  'option' => $options,
                 'user' => $name,


            ]);

        }

}





