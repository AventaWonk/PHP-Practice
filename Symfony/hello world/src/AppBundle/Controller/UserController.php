<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserController extends Controller
{
    /**
     * @Route("/admin/users/", name="users_index")
     */
    public function indexAction(EntityManagerInterface $em)
    {
      $users = $em->getRepository('AppBundle:User')
        ->findAll();

      return $this->render('/admin/users/index.html.twig', [
        'users' => $users,
      ]);
    }

    /**
     * @Route("/admin/users/add/", name="users_add")
     */
    public function addUserAction(Request $request, EntityManagerInterface $em)
    {
        $product = new User();
        $form = $this->createFormBuilder($product)
            ->add('username', TextType::class)
            ->add('email', EmailType::class)
            ->add('password', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Add'])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          $user = $form->getData();
          $em->persist($user);
          $em->flush();
          return $this->redirectToRoute('users_index');
        }

        return $this->render('/admin/users/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/users/delete/{id}", name="users_delete")
     */
    public function deleteUserAction($id, EntityManagerInterface $em)
    {
        $user = $em->getRepository('AppBundle:User')->findOneById($id);
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('users_index');
    }

    /**
     * @Route("/admin/users/update/{id}", name="users_update")
     */
    public function updateUserAction($id, Request $request, EntityManagerInterface $em)
    {
      $user = $em->getRepository('AppBundle:User')->findOneById($id);
      $user->setPassword('');
      $form = $this->createFormBuilder($user)
          ->add('username', TextType::class)
          ->add('email', EmailType::class)
          ->add('password', TextType::class)
          ->add('save', SubmitType::class, ['label' => 'Save'])
          ->getForm();
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $user = $form->getData();
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute('users_index');
      }

      return $this->render('/admin/users/add.html.twig', [
          'form' => $form->createView(),
      ]);
    }


}
