<?php

namespace SportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use SportBundle\Entity\Equipe;
use SportBundle\Entity\Joueur;
use SportBundle\Entity\Vs;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="matchs")
     * @Template()
     */
    public function indexAction(Request $request)
    {
      $em = $this->getDoctrine()->getManager();

      $match = new Vs();
      $form = $this->createFormBuilder($match)
        ->add('date_match', DateType::class)
        ->add('scoreEquipe1', TextType::class)
        ->add('scoreEquipe2', TextType::class)
        ->add('equipe1', EntityType::class, array(
          'class' => 'SportBundle:Equipe',
          'choice_label' => 'nom'
        ))
        ->add('equipe2', EntityType::class, array(
          'class' => 'SportBundle:Equipe',
          'choice_label' => 'nom'
        ))
        ->add('save', SubmitType::class, array(
          'label' => 'Ajouter un match'
        ))
        ->getForm();

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $em->persist($match);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Match ajouté');
      }

      $matchs = $em->getRepository('SportBundle:Vs')->findAll();

      return array(
        'matchs' => $matchs,
        'form' => $form->createView()
      );
    }

    /**
     * Affichage des équipes
     * @Route("/equipes", name="equipes")
     * @Template()
     */
    public function equipesAction(Request $request){
      $em = $this->getDoctrine()->getManager();

      $equipe = new Equipe();
      $form = $this->createFormBuilder($equipe)
        ->add('nom', TextType::class)
        ->add('save', SubmitType::class, array(
          'label' => 'Ajouter une équipe'
        ))
        ->getForm();

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $em->persist($equipe);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Equipe ajoutée');
      }

      $equipes = $em->getRepository('SportBundle:Equipe')->findAll();

      return array(
        'equipes' => $equipes,
        'form' => $form->createView()
      );
    }

    /**
     * Affichage d'une équipe
     * @Route("/equipe/{id}", name="equipe")
     * @Template()
     */
    public function equipeAction(Request $request, $id){
      $em = $this->getDoctrine()->getManager();

      $equipe = $em->getRepository('SportBundle:Equipe')->findOneById($id);

      if(!empty($equipe)){
        $form = $this->createFormBuilder($equipe)
          ->add('nom', TextType::class)
          ->add('save', SubmitType::class, array(
            'label' => 'Modifier'
          ))
          ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          $em->persist($equipe);
          $em->flush();

          $this->get('session')->getFlashBag()->add('success', 'Equipe modifiée');
        }

        return array(
          'equipe' => $equipe,
          'form' => $form->createView()
        );
      }
      else{
        $this->get('session')->getFlashBag()->add('danger', 'Cette équipe n\'existe pas');

        return $this->redirectToRoute('home');
      }
    }

    /**
     * Suppression d'une équipe
     * @Route("/delete/equipe/{id}", name="delete_equipe")
     */
    public function delete_equipe(Request $request, $id){
      $em = $this->getDoctrine()->getManager();

      $equipe = $em->getRepository('SportBundle:Equipe')->findOneById($id);

      if(!empty($equipe)){
        $em->remove($equipe);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Equipe supprimée');

        return $this->redirectToRoute('equipes');
      }
    }

    /**
     * Affichage des joueurs
     * @Route("/joueurs", name="joueurs")
     * @Template()
     */
    public function joueursAction(Request $request){
      $em = $this->getDoctrine()->getManager();

      $joueur = new Joueur();
      $form = $this->createFormBuilder($joueur)
        ->add('genre', ChoiceType::class, array(
          'choices'  => array(
            'Homme' => 1,
            'Femme' => 2,
            'Autre' => 0,
          ),
        ))
        ->add('nom', TextType::class)
        ->add('prenom', TextType::class)
        ->add('equipe', EntityType::class, array(
          'class' => 'SportBundle:Equipe',
          'choice_label' => 'nom'
        ))
        ->add('save', SubmitType::class, array(
          'label' => 'Ajouter une équipe'
        ))
        ->getForm();

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $em->persist($joueur);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Joueur ajouté');
      }

      $joueurs = $em->getRepository('SportBundle:Joueur')->findAll();

      return array(
        'joueurs' => $joueurs,
        'form' => $form->createView()
      );
    }

    /**
     * Affichage d'un joueur
     * @Route("/joueur/{id}", name="joueur")
     * @Template()
     */
    public function joueurAction(Request $request, $id){
      $em = $this->getDoctrine()->getManager();

      $joueur = $em->getRepository('SportBundle:Joueur')->findOneById($id);

      if(!empty($joueur)){
        $form = $this->createFormBuilder($joueur)
          ->add('genre', ChoiceType::class, array(
            'choices'  => array(
              'Homme' => 1,
              'Femme' => 2,
              'Autre' => 0,
            ),
          ))
          ->add('nom', TextType::class)
          ->add('prenom', TextType::class)
          ->add('equipe', EntityType::class, array(
            'class' => 'SportBundle:Equipe',
            'choice_label' => 'nom'
          ))
          ->add('save', SubmitType::class, array(
            'label' => 'Modifier'
          ))
          ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          $em->persist($joueur);
          $em->flush();

          $this->get('session')->getFlashBag()->add('success', 'Joueur modifié');
        }

        return array(
          'joueur' => $joueur,
          'form' => $form->createView()
        );
      }
      else{
        $this->get('session')->getFlashBag()->add('danger', 'Ce joueur n\'existe pas');

        return $this->redirectToRoute('home');
      }
    }

    /**
     * Suppression d'un joueur
     * @Route("/delete/joueur/{id}", name="delete_joueur")
     */
    public function delete_joueur(Request $request, $id){
      $em = $this->getDoctrine()->getManager();

      $joueur = $em->getRepository('SportBundle:Joueur')->findOneById($id);

      if(!empty($joueur)){
        $em->remove($joueur);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Joueur supprimé');

        return $this->redirectToRoute('joueurs');
      }
    }

    /**
     * Affichage d'un match
     * @Route("/match/{id}", name="match")
     * @Template()
     */
    public function matchAction(Request $request, $id){
      $em = $this->getDoctrine()->getManager();

      $match = $em->getRepository('SportBundle:Vs')->findOneById($id);

      if(!empty($match)){
        $form = $this->createFormBuilder($match)
          ->add('date_match', DateType::class)
          ->add('scoreEquipe1', TextType::class)
          ->add('scoreEquipe2', TextType::class)
          ->add('equipe1', EntityType::class, array(
            'class' => 'SportBundle:Equipe',
            'choice_label' => 'nom'
          ))
          ->add('equipe2', EntityType::class, array(
            'class' => 'SportBundle:Equipe',
            'choice_label' => 'nom'
          ))
          ->add('save', SubmitType::class, array(
            'label' => 'Modifier'
          ))
          ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          $em->persist($match);
          $em->flush();

          $this->get('session')->getFlashBag()->add('success', 'Match modifié');
        }

        return array(
          'match' => $match,
          'form' => $form->createView()
        );
      }
      else{
        $this->get('session')->getFlashBag()->add('danger', 'Ce match n\'existe pas');

        return $this->redirectToRoute('home');
      }
    }

    /**
     * Suppression d'un match
     * @Route("/delete/match/{id}", name="delete_match")
     */
    public function delete_match(Request $request, $id){
      $em = $this->getDoctrine()->getManager();

      $match = $em->getRepository('SportBundle:Vs')->findOneById($id);

      if(!empty($match)){
        $em->remove($match);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Match supprimé');

        return $this->redirectToRoute('matchs');
      }
    }
}
