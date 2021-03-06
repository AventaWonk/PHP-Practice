<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProductController extends Controller
{
    /**
     * @Route("/admin/products/", name="index")
     */
    public function indexAction(EntityManagerInterface $em)
    {
      $products = $em->getRepository('AppBundle:Product')
        ->findAll();

      return $this->render('admin/products/index.html.twig', [
        'products' => $products,
      ]);
    }

    /**
     * @Route("/admin/products/create", name="create")
     */
    public function addProduct(Request $request, EntityManagerInterface $em)
    {
        $product = new Product();
        $form = $this->createFormBuilder($product)
            ->add('name', TextType::class)
            ->add('price', NumberType::class)
            ->add('description', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Add'])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          $product = $form->getData();
          $em->persist($product);
          $em->flush();
          return $this->redirectToRoute('index');
        }

        return $this->render('admin/products/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/products/delete/{id}", name="delete")
     */
    public function deleteProduct($id, EntityManagerInterface $em)
    {
        $product = $em->getRepository('AppBundle:Product')->findOneById($id);
        $em->remove($product);
        $em->flush();

        return $this->redirectToRoute('index');
    }

    /**
     * @Route("/admin/products/update/{id}", name="update")
     */
    public function updateProduct($id, Request $request, EntityManagerInterface $em)
    {
      $product = $em->getRepository('AppBundle:Product')->findOneById($id);
      $form = $this->createFormBuilder($product)
          ->add('name', TextType::class)
          ->add('price', NumberType::class)
          ->add('description', TextType::class)
          ->add('save', SubmitType::class, ['label' => 'Save'])
          ->getForm();
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $product = $form->getData();
        $em->persist($product);
        $em->flush();
        return $this->redirectToRoute('index');
      }

      return $this->render('admin/products/add.html.twig', [
          'form' => $form->createView(),
      ]);
    }


}
