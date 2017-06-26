<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Role;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RoleController extends Controller
{
    /**
     * @Route("/admin/roles/", name="roles_index")
     */
    public function indexAction(EntityManagerInterface $em)
    {
      $roles = $em->getRepository('AppBundle:Role')
        ->findAll();

      return $this->render('/admin/roles/index.html.twig', [
        'roles' => $roles,
      ]);
    }

    /**
     * @Route("/admin/roles/add/", name="roles_add")
     */
    public function addRoleAction(Request $request, EntityManagerInterface $em)
    {
        $role = new Role();
        $form = $this->createFormBuilder($role)
            ->add('name', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Add'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          $role = $form->getData();
          $em->persist($role);
          $em->flush();
          return $this->redirectToRoute('roles_index');
        }

        return $this->render('/admin/roles/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/roles/delete/{id}", name="roles_delete")
     */
    public function deleteRoleAction($id, EntityManagerInterface $em)
    {
        $role = $em->getRepository('AppBundle:Role')->findOneById($id);
        $role->remove($user);
        $em->flush();

        return $this->redirectToRoute('roles_index');
    }

    /**
     * @Route("/admin/roles/update/{id}", name="roles_update")
     */
    public function updateRoleAction($id, Request $request, EntityManagerInterface $em)
    {
      $role = $em->getRepository('AppBundle:User')->findOneById($id);

      $form = $this->createFormBuilder($role)
          ->add('name', TextType::class)
          ->add('save', SubmitType::class, ['label' => 'Save'])
          ->getForm();

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $role = $form->getData();
        $em->persist($role);
        $em->flush();
        return $this->redirectToRoute('roles_index');
      }

      return $this->render('/admin/roles/add.html.twig', [
          'form' => $form->createView(),
      ]);
    }
}
