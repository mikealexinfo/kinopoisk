<?php

namespace Kino\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @ORM\Entity
 * @ORM\Table(name="history",
 *           uniqueConstraints={@UniqueConstraint(name="hist_film_uniq",columns={"historyDate","filmId"})}
 * )
 * @ORM\Entity(repositoryClass="Kino\SiteBundle\Repository\HistoryRepository") 
 * 
 * Kino\SiteBundle\Entity\History
 */
class History
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     * @var integer $id
     */
    private $id;

    /**
     * @var Users
     *
     * @ManyToOne(targetEntity="Film", inversedBy="history")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="filmId", referencedColumnName="id")
     * })
     */
    private $film;
    
    /**
     * @ORM\Column(type="integer")
     * 
     * @var integer $historyPosition
     */
    private $historyPosition;

    /**
     * @ORM\Column(type="integer")
     * 
     * @var integer $historyVotes
     */
    private $historyVotes;

    /**
     * @ORM\Column(type="float")
     * 
     * @var double $historyRating
     */
    private $historyRating;
    
    /**
     * @ORM\Column(type="date")
     * 
     * @var \DateTime $historyDate
     */
    private $historyDate;
    
    /**
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set historyPosition
     *
     * @param integer $historyPosition
     * @return History
     */
    public function setHistoryPosition($historyPosition)
    {
        $this->historyPosition = $historyPosition;

        return $this;
    }

    /**
     * Get historyPosition
     *
     * @return integer 
     */
    public function getHistoryPosition()
    {
        return $this->historyPosition;
    }

    /**
     * Set historyVotes
     *
     * @param integer $historyVotes
     * @return History
     */
    public function setHistoryVotes($historyVotes)
    {
        $this->historyVotes = $historyVotes;

        return $this;
    }

    /**
     * Get historyVotes
     *
     * @return integer 
     */
    public function getHistoryVotes()
    {
        return $this->historyVotes;
    }

    /**
     * Set historyRating
     *
     * @param double $historyRating
     * @return History
     */
    public function setHistoryRating($historyRating)
    {
        $this->historyRating = $historyRating;

        return $this;
    }

    /**
     * Get historyRating
     *
     * @return double 
     */
    public function getHistoryRating()
    {
        return $this->historyRating;
    }

    /**
     * Set historyDate
     *
     * @param \DateTime $historyDate
     * @return History
     */
    public function setHistoryDate($historyDate)
    {
        $this->historyDate = $historyDate;

        return $this;
    }

    /**
     * Get historyDate
     *
     * @return \DateTime 
     */
    public function getHistoryDate()
    {
        return $this->historyDate;
    }

    /**
     * Set film
     *
     * @param Kino\SiteBundle\Entity\Film $film
     * @return History
     */
    public function setFilm(\Kino\SiteBundle\Entity\Film $film = null)
    {
        $this->film = $film;

        return $this;
    }

    /**
     * Get film
     *
     * @return Kino\SiteBundle\Entity\Film 
     */
    public function getFilm()
    {
        return $this->film;
    }

}