<?php

namespace Kino\SiteBundle\Tests\Controller;

require_once 'PHPUnit/Framework/Assert/Functions.php';

use PHPUnit_Framework_TestCase;

use Kino\SiteBundle\Entity\Film;

class FilmTest extends PHPUnit_Framework_TestCase
{
    private $film;

    protected function setUp()
    {
        $this->film = new Film();
    }

    public function testFilmName()
    {
        $film = $this->film;

        assertSame($film, $film->setFilmName('Test'));

        assertEquals('Test', $film->getFilmName());
    }

    public function testFilmYear()
    {
        $film = $this->film;

        assertSame($film, $film->setFilmYear(2012));

        assertEquals(2012, $film->getFilmYear());
    }
}
