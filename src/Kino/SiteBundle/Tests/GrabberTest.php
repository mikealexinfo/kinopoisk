<?php

namespace Kino\SiteBundle\Tests;

require_once 'PHPUnit/Framework/Assert/Functions.php';

use PHPUnit_Framework_TestCase;

use Kino\SiteBundle\Grabber;

class GrabberTest extends PHPUnit_Framework_TestCase
{
    /**
     * All good :)
     */
    public function testWithoutErrors()
    {
        $response = $this->getMock('Buzz\\Message\\Response');
        $response
            ->expects($this->any())
            ->method('getContent')
            ->will($this->returnValue(
                file_get_contents(__DIR__ . '/../Resources/fixtures/kinopoisk.html')
            ));

        $response
            ->expects($this->any())
            ->method('isOk')
            ->will($this->returnValue(true));

        $browser = $this->getMock('Buzz\\Browser');
        $browser
            ->expects($this->once())
            ->method('get')
            ->will($this->returnValue($response));

        // Сюда можно подсунуть и фабрику грабберов ещё, но пока это перебор и есть доверие к вендору.
        $grabber = new Grabber($browser);

        $films = $grabber->getSite();

        assertEquals(
            array (
                0 => array(
                    'film_pos' => '1',
                    'film_name' => 'Побег из Шоушенка',
                    'film_year' => '1994',
                    'film_rate' => '9.207',
                    'film_voic' => 198508,
                    'film_sitename' => 'http://kinopoisk.ru',
                    'film_link' => '/film/326/',
                    'film_img' => '/Users/alexeyshockov/vagrant/kinopoisk/src/Kino/SiteBundle/../../../web/tmp/temp_big326.jpg',
                    'film_imgthumb' => '/Users/alexeyshockov/vagrant/kinopoisk/src/Kino/SiteBundle/../../../web/tmp/temp326.jpg',
                    'local' => '/Users/alexeyshockov/vagrant/kinopoisk/src/Kino/SiteBundle/../../../web/bundles/kinosite/img_site/',
                ),
                1 => array(
                    'film_pos' => '2',
                    'film_name' => 'Зеленая миля',
                    'film_year' => '1999',
                    'film_rate' => '9.153',
                    'film_voic' => 190017,
                    'film_sitename' => 'http://kinopoisk.ru',
                    'film_link' => '/film/435/',
                    'film_img' => '/Users/alexeyshockov/vagrant/kinopoisk/src/Kino/SiteBundle/../../../web/tmp/temp_big435.jpg',
                    'film_imgthumb' => '/Users/alexeyshockov/vagrant/kinopoisk/src/Kino/SiteBundle/../../../web/tmp/temp435.jpg',
                    'local' => '/Users/alexeyshockov/vagrant/kinopoisk/src/Kino/SiteBundle/../../../web/bundles/kinosite/img_site/',
                ),
                2 => array(
                    'film_pos' => '3',
                    'film_name' => 'Форрест Гамп',
                    'film_year' => '1994',
                    'film_rate' => '9.031',
                    'film_voic' => 191884,
                    'film_sitename' => 'http://kinopoisk.ru',
                    'film_link' => '/film/448/',
                    'film_img' => '/Users/alexeyshockov/vagrant/kinopoisk/src/Kino/SiteBundle/../../../web/tmp/temp_big448.jpg',
                    'film_imgthumb' => '/Users/alexeyshockov/vagrant/kinopoisk/src/Kino/SiteBundle/../../../web/tmp/temp448.jpg',
                    'local' => '/Users/alexeyshockov/vagrant/kinopoisk/src/Kino/SiteBundle/../../../web/bundles/kinosite/img_site/',
                ),
                3 => array(
                    'film_pos' => '4',
                    'film_name' => '1+1',
                    'film_year' => '2011',
                    'film_rate' => '8.916',
                    'film_voic' => 132098,
                    'film_sitename' => 'http://kinopoisk.ru',
                    'film_link' => '/film/535341/',
                    'film_img' => '/Users/alexeyshockov/vagrant/kinopoisk/src/Kino/SiteBundle/../../../web/tmp/temp_big535341.jpg',
                    'film_imgthumb' => '/Users/alexeyshockov/vagrant/kinopoisk/src/Kino/SiteBundle/../../../web/tmp/temp535341.jpg',
                    'local' => '/Users/alexeyshockov/vagrant/kinopoisk/src/Kino/SiteBundle/../../../web/bundles/kinosite/img_site/',
                ),
                4 => array(
                    'film_pos' => '5',
                    'film_name' => 'Список Шиндлера',
                    'film_year' => '1993',
                    'film_rate' => '8.857',
                    'film_voic' => 93048,
                    'film_sitename' => 'http://kinopoisk.ru',
                    'film_link' => '/film/329/',
                    'film_img' => '/Users/alexeyshockov/vagrant/kinopoisk/src/Kino/SiteBundle/../../../web/tmp/temp_big329.jpg',
                    'film_imgthumb' => '/Users/alexeyshockov/vagrant/kinopoisk/src/Kino/SiteBundle/../../../web/tmp/temp329.jpg',
                    'local' => '/Users/alexeyshockov/vagrant/kinopoisk/src/Kino/SiteBundle/../../../web/bundles/kinosite/img_site/',
                ),
                5 => array(
                    'film_pos' => '6',
                    'film_name' => 'Леон',
                    'film_year' => '1994',
                    'film_rate' => '8.814',
                    'film_voic' => 157248,
                    'film_sitename' => 'http://kinopoisk.ru',
                    'film_link' => '/film/389/',
                    'film_img' => '/Users/alexeyshockov/vagrant/kinopoisk/src/Kino/SiteBundle/../../../web/tmp/temp_big389.jpg',
                    'film_imgthumb' => '/Users/alexeyshockov/vagrant/kinopoisk/src/Kino/SiteBundle/../../../web/tmp/temp389.jpg',
                    'local' => '/Users/alexeyshockov/vagrant/kinopoisk/src/Kino/SiteBundle/../../../web/bundles/kinosite/img_site/',
                ),
                6 => array(
                    'film_pos' => '7',
                    'film_name' => 'Король Лев',
                    'film_year' => '1994',
                    'film_rate' => '8.795',
                    'film_voic' => 132679,
                    'film_sitename' => 'http://kinopoisk.ru',
                    'film_link' => '/film/2360/',
                    'film_img' => '/Users/alexeyshockov/vagrant/kinopoisk/src/Kino/SiteBundle/../../../web/tmp/temp_big2360.jpg',
                    'film_imgthumb' => '/Users/alexeyshockov/vagrant/kinopoisk/src/Kino/SiteBundle/../../../web/tmp/temp2360.jpg',
                    'local' => '/Users/alexeyshockov/vagrant/kinopoisk/src/Kino/SiteBundle/../../../web/bundles/kinosite/img_site/',
                ),
                7 => array(
                    'film_pos' => '8',
                    'film_name' => 'Начало',
                    'film_year' => '2010',
                    'film_rate' => '8.783',
                    'film_voic' => 214015,
                    'film_sitename' => 'http://kinopoisk.ru',
                    'film_link' => '/film/447301/',
                    'film_img' => '/Users/alexeyshockov/vagrant/kinopoisk/src/Kino/SiteBundle/../../../web/tmp/temp_big447301.jpg',
                    'film_imgthumb' => '/Users/alexeyshockov/vagrant/kinopoisk/src/Kino/SiteBundle/../../../web/tmp/temp447301.jpg',
                    'local' => '/Users/alexeyshockov/vagrant/kinopoisk/src/Kino/SiteBundle/../../../web/bundles/kinosite/img_site/',
                ),
                8 => array(
                    'film_pos' => '9',
                    'film_name' => 'Бойцовский клуб',
                    'film_year' => '1999',
                    'film_rate' => '8.740',
                    'film_voic' => 177580,
                    'film_sitename' => 'http://kinopoisk.ru',
                    'film_link' => '/film/361/',
                    'film_img' => '/Users/alexeyshockov/vagrant/kinopoisk/src/Kino/SiteBundle/../../../web/tmp/temp_big361.jpg',
                    'film_imgthumb' => '/Users/alexeyshockov/vagrant/kinopoisk/src/Kino/SiteBundle/../../../web/tmp/temp361.jpg',
                    'local' => '/Users/alexeyshockov/vagrant/kinopoisk/src/Kino/SiteBundle/../../../web/bundles/kinosite/img_site/',
                ),
                9 => array(
                    'film_pos' => '10',
                    'film_name' => 'Джанго освобожденный',
                    'film_year' => '2012',
                    'film_rate' => '8.739',
                    'film_voic' => 42225,
                    'film_sitename' => 'http://kinopoisk.ru',
                    'film_link' => '/film/586397/',
                    'film_img' => '/Users/alexeyshockov/vagrant/kinopoisk/src/Kino/SiteBundle/../../../web/tmp/temp_big586397.jpg',
                    'film_imgthumb' => '/Users/alexeyshockov/vagrant/kinopoisk/src/Kino/SiteBundle/../../../web/tmp/temp586397.jpg',
                    'local' => '/Users/alexeyshockov/vagrant/kinopoisk/src/Kino/SiteBundle/../../../web/bundles/kinosite/img_site/',
                ),
            ),
            $films
        );
    }

    /**
     * When HTTP errors...
     */
    public function testWithHttpErrors()
    {
        $this->setExpectedException('\\RuntimeException');

        $response = $this->getMock('Buzz\\Message\\Response');
        $response
            ->expects($this->any())
            ->method('isOk')
            ->will($this->returnValue(false));

        $browser = $this->getMock('Buzz\\Browser');
        $browser
            ->expects($this->once())
            ->method('get')
            ->will($this->returnValue($response));

        // Сюда можно подсунуть и фабрику грабберов ещё, но пока это перебор, и есть доверие к вендору.
        $grabber = new Grabber($browser);

        $grabber->getSite();
    }

    /**
     * When kinopoisk.ru change markup.
     */
    public function testWithBrokenVendorHtml()
    {
        // TODO Тест с подменённым Crawler'ом или просто другим HTML'ем.

        $this->markTestIncomplete();
    }

    /**
     * When FS unable to save files (films thumbnails).
     */
    public function testWithSaveErrors()
    {
        // Пока работа с файловой системой не вынесена в отдельный класс, данный тест невозможно реализовать (без
        // извращений).

        $this->markTestSkipped();
    }
}
