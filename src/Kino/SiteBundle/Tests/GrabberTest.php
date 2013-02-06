<?php

namespace Kino\SiteBundle\Tests;

require_once 'PHPUnit/Framework/Assert/Functions.php';

use PHPUnit_Framework_TestCase;

use Kino\SiteBundle\Grabber;

class GrabberTest extends PHPUnit_Framework_TestCase
{
    private $grabber;

    protected function setUp()
    {
        $this->grabber = new Grabber();
    }

    /**
     * All good :)
     */
    public function testWithoutErrors()
    {
        $this->markTestIncomplete();
    }

    /**
     * When HTTP errors...
     */
    public function testWithHttpErrors()
    {
        $this->markTestIncomplete();
    }

    /**
     * When kinopoisk.ru change markup.
     */
    public function testWithBrokenVendorHtml()
    {
        $this->markTestIncomplete();
    }

    /**
     * When FS unable to save files (films thumbnails).
     */
    public function testWithSaveErrors()
    {
        $this->markTestIncomplete();
    }
}
