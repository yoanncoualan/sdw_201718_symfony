<?php

namespace SportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Equipe
 *
 * @ORM\Table(name="equipe")
 * @ORM\Entity(repositoryClass="SportBundle\Repository\EquipeRepository")
 */
class Equipe
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="Joueur", mappedBy="equipe", cascade={"persist", "remove"})
     */
    private $joueurs;

    /**
     * @ORM\OneToMany(targetEntity="Vs", mappedBy="equipe1")
     */
    private $vs1;

    /**
     * @ORM\OneToMany(targetEntity="Vs", mappedBy="equipe2")
     */
    private $vs2;


    public function __construct() {
      $this->joueurs = new ArrayCollection();
      $this->vs1 = new ArrayCollection();
      $this->vs2 = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Equipe
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Get joueurs
     *
     * @return Joueurs
     */
    public function getJoueurs()
    {
        return $this->joueurs;
    }

    /**
     * Get vs1
     *
     * @return Vs
     */
    public function getVs1()
    {
        return $this->vs1;
    }

    /**
     * Get vs2
     *
     * @return Vs
     */
    public function getVs2()
    {
        return $this->vs2;
    }
}
