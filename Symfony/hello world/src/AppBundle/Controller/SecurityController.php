<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class SecurityController extends Controller
{
  /**
    * @Route("/login", name="login")
    */
   public function loginAction(Request $request, AuthenticationUtils $authUtils)
   {
    $error = $authUtils->getLastAuthenticationError();
    $lastUsername = $authUtils->getLastUsername();

    return $this->render('security/login.html.twig', array(
        'last_username' => $lastUsername,
        'error'         => $error,
    ));
   }

   /**
     * @Route("/registration", name="registration")
     */
    public function registrationAction(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
      $user = new User();
      $form = $this->createFormBuilder($user)
          ->add('username', TextType::class)
          ->add('email', EmailType::class)
          ->add('password', TextType::class)
          ->add('save', SubmitType::class, ['label' => 'Add'])
          ->getForm();
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $user = $form->getData();
        $encoded = $encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($encoded);
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute('index');
      }

      return $this->render('product/create.html.twig', [
          'form' => $form->createView(),
      ]);
    }
}
