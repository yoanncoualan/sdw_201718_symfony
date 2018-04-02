<?php

namespace SportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Vs
 *
 * @ORM\Table(name="vs")
 * @ORM\Entity(repositoryClass="SportBundle\Repository\VsRepository")
 */
class Vs
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
     * @var \DateTime
     *
     * @ORM\Column(name="date_match", type="date")
     */
    private $date_match;

    /**
     * @var int
     *
     * @ORM\Column(name="score_equipe1", type="integer")
     */
    private $scoreEquipe1;

    /**
     * @var int
     *
     * @ORM\Column(name="score_equipe2", type="integer")
     */
    private $scoreEquipe2;

    /**
     * @ORM\ManyToOne(targetEntity="Equipe", inversedBy="vs1")
     * @ORM\JoinColumn(name="equipe1", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $equipe1;

    /**
     * @ORM\ManyToOne(targetEntity="Equipe", inversedBy="vs2")
     * @ORM\JoinColumn(name="equipe2", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $equipe2;


    public function __construct() {
      $this->equipes = new ArrayCollection();
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
     * Set date_match
     *
     * @param \DateTime $date_match
     *
     * @return Vs
     */
    public function setDateMatch($date_match)
    {
        $this->date_match = $date_match;

        return $this;
    }

    /**
     * Get date_match
     *
     * @return \DateTime
     */
    public function getDateMatch()
    {
        return $this->date_match;
    }

    /**
     * Set scoreEquipe1
     *
     * @param integer $scoreEquipe1
     *
     * @return Vs
     */
    public function setScoreEquipe1($scoreEquipe1)
    {
        $this->scoreEquipe1 = $scoreEquipe1;

        return $this;
    }

    /**
     * Get scoreEquipe1
     *
     * @return int
     */
    public function getScoreEquipe1()
    {
        return $this->scoreEquipe1;
    }

    /**
     * Set scoreEquipe2
     *
     * @param integer $scoreEquipe2
     *
     * @return Vs
     */
    public function setScoreEquipe2($scoreEquipe2)
    {
        $this->scoreEquipe2 = $scoreEquipe2;

        return $this;
    }

    /**
     * Get scoreEquipe2
     *
     * @return int
     */
    public function getScoreEquipe2()
    {
        return $this->scoreEquipe2;
    }

    /**
     * Set equipe1
     *
     * @param integer $equipe1
     *
     * @return Vs
     */
    public function setEquipe1($equipe1)
    {
        $this->equipe1 = $equipe1;

        return $this;
    }

    /**
     * Get equipe1
     */
    public function getEquipe1()
    {
        return $this->equipe1;
    }

    /**
     * Set equipe2
     *
     * @param integer $equipe2
     *
     * @return Vs
     */
    public function setEquipe2($equipe2)
    {
        $this->equipe2 = $equipe2;

        return $this;
    }

    /**
     * Get equipe2
     */
    public function getEquipe2()
    {
        return $this->equipe2;
    }
}
