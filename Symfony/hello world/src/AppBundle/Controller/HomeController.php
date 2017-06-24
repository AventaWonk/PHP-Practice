<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManagerInterface;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home_index")
     */
    public function indexAction(EntityManagerInterface $em)
    {
      $products = $em->getRepository('AppBundle:Product')
        ->findAll();

      return $this->render('index.html.twig', [
        'products' => $products,
      ]);
    }

}
