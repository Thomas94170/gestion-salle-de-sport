<?php

namespace App\Controller;

use App\Entity\Structure;
use App\Entity\User;
use App\Form\RegisterSalleFormType;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationSalleController extends AbstractController
{
    private $emailVerifier;

    #[Route('/registration/salle', name: 'app_registration_salle')]
    public function index(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $structure = new Structure();
        $form = $this->createForm(RegisterSalleFormType::class, $structure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $structure->setPassword(
                $userPasswordHasher->hashPassword(
                    $structure,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($structure);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $structure,
                (new TemplatedEmail())
                    ->from(new Address('thomas.devweb94@gmail.com', 'Admin'))
                    ->to($structure->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email_salle.html.twig')
            );
            // do anything else you need here, like send an email

            //return $userAuthenticator->authenticateUser(
            //  $user,
            //   $authenticator,
            //  $request
            //  );
            return $this->redirectToRoute('administration');
        }

        return $this->render('registration/registerSalle.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }



    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_registration_salle');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->render('registration_salle/index.html.twig');
    }
}
