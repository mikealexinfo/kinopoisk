<?php

namespace Kino\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * @ORM\Entity
 * @ORM\Table(name="film",
 *           uniqueConstraints={@UniqueConstraint(name="films_name_uniq",columns={"filmName","filmYear"})}
 * )
 * 
 * Kino\SiteBundle\Entity\Film
 */
class Film
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
     * @ORM\Column(type="string", length=100)
     * 
     * @var string $filmName
     */
    private $filmName;
    
    /**
     * @ORM\Column(type="integer")
     * 
     * @var integer $filmYear
     */
    private $filmYear;
    
    /**
    * @OneToMany(targetEntity="History", mappedBy="film_id")
    */
    private $history;
   
    /**
     * 
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set filmName
     *
     * @param string $filmName
     * @return Film
     */
    public function setFilmName($filmName)
    {
        $this->filmName = $filmName;

        return $this;
    }

    /**
     * Get filmName
     *
     * @return string 
     */
    public function getFilmName()
    {
        return $this->filmName;
    }

    /**
     * Set filmYear
     *
     * @param integer $filmYear
     * @return Film
     */
    public function setFilmYear($filmYear)
    {
        $this->filmYear = $filmYear;

        return $this;
    }

    /**
     * Get filmYear
     *
     * @return integer 
     */
    public function getFilmYear()
    {
        return $this->filmYear;
    }

}