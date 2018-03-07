<?php

namespace IntroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use IntroBundle\Entity\Category;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


class DefaultController extends Controller
{
  /**
   * @Route("/")
   * @Template()
   */
  public function indexAction(Request $request)
  {
    $bdd = $this->getDoctrine()->getManager();

    $category = new Category();
    $form = $this->createFormBuilder($category)
            ->add('name', TextType::class)
            ->add('description', TextareaType::class, array(
              'required' => false
            ))
            ->add('save', SubmitType::class, array(
              'label' => 'Ajouter une catégorie'
            ))
            ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      // Formulaire envoyé et valide

      $bdd->persist($category);
      $bdd->flush();

      $this->get('session')->getFlashBag()->add('success', 'Catégorie ajoutée');
    }

    $categories = $bdd->getRepository('IntroBundle:Category')->findAll();

    return array(
      'prenom' => 'Yoann',
      'categories' => $categories,
      'form' => $form->createView()
    );
  }
}
