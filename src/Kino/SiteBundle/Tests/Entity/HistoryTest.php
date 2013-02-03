<?php

namespace Acme\DemoBundle\Tests\Controller;

require_once 'PHPUnit/Framework/Assert/Functions.php';

use PHPUnit_Framework_TestCase;

use Kino\SiteBundle\Entity\History;
use Kino\SiteBundle\Entity\Film;

class HistoryTest extends PHPUnit_Framework_TestCase
{
    private $history;

    protected function setUp()
    {
        $this->history = new History();
    }

    public function testHistoryPosition()
    {
        $history = $this->history;

        assertSame($history, $history->setHistoryPosition(10) );
        
        assertEquals(10, $history->getHistoryPosition());
    }

    public function testHistoryRating()
    {
        $history = $this->history;

        assertSame($history, $history->setHistoryRating(3.58) );
        
        assertEquals(3.58, $history->getHistoryRating() );
    }

    public function testHistoryVotes()
    {
        $history = $this->history;

        assertSame($history, $history->setHistoryVotes(100000) );
        
        assertEquals(100000, $history->getHistoryVotes());
    }

    public function testHistoryDate()
    {
        $history = $this->history;

        assertSame($history, $history->setHistoryDate('2013-01-01') );
        
        assertEquals('2013-01-01', $history->getHistoryDate());
    }

    public function testHistoryFilm()
    {
        $history = $this->history;
        $film = new Film();

        assertSame($history, $history->setHistoryDate($film) );
        
        assertEquals($film, $history->getHistoryDate());
    }
}
