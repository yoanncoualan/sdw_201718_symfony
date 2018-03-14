<?php

namespace IntroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use IntroBundle\Entity\Category;
use IntroBundle\Entity\Article;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


class DefaultController extends Controller
{
  /**
   * @Route("/", name="home")
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

      $traduction = $this->get('translator');

      $this->get('session')->getFlashBag()->add(
        'success',
        $traduction->trans('categorie.added')
      );
    }

    $categories = $bdd->getRepository('IntroBundle:Category')->findAll();

    return array(
      'prenom' => 'Yoann',
      'categories' => $categories,
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/articles", name="list_articles")
   * @Template()
   */
  public function articlesAction(Request $request){
    $bdd = $this->getDoctrine()->getManager();

    $article = new Article();
    $form = $this->createFormBuilder($article)
      ->add('titre', TextType::class)
      ->add('contenu', TextareaType::class, array(
        'required' => false
      ))
      ->add('category', EntityType::class, array(
        'class' => 'IntroBundle:Category',
        'choice_label' => 'name'
      ))
      ->add('save', SubmitType::class, array(
        'label' => 'Ajouter un article'
      ))
      ->getForm();

    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()){
      $bdd->persist($article);
      $bdd->flush();

      $traduction = $this->get('translator');

      $this->get('session')->getFlashBag()->add(
        'success',
        $traduction->trans('articles.added')
      );
    }

    $articles = $bdd->getRepository('IntroBundle:Article')->findAll();

    return array(
      'articles' => $articles,
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/category/{id}", name="category")
   */
  public function categoryAction(){
    return array('id' => $id);
  }
}
