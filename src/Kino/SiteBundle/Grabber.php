<?php

namespace Kino\SiteBundle;

use Symfony\Component\DomCrawler\Crawler;

use Buzz\Browser;

use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service("kino.grabber")
 */
class Grabber
{
    /**
     * @var \Kino\SiteBundle\CrawlerFactory
     */
    private $crawlerFactory;

    /**
     * @var \Buzz\Browser
     */
    private $browser;

    /**
     * @DI\InjectParams({
     *     "browser"        = @DI\Inject("buzz"),
     *     "crawlerFactory" = @DI\Inject("kino.crawler_factory")
     * })
     *
     * @param \Buzz\Browser                   $browser
     * @param \Kino\SiteBundle\CrawlerFactory $crawlerFactory
     */
    public function __construct(Browser $browser = null, CrawlerFactory $crawlerFactory = null)
    {
        $this->browser        = ($browser ?: new Browser());
        $this->crawlerFactory = ($crawlerFactory ?: new CrawlerFactory());
    }

    /**
     * Функция закачки странички кинопоиска и парсинга данных этой страницы.
     *
     * Возвращает массив данных следующего вида:
     *
     * <code>
     * array(
     * [0] => array(
     * 'film_pos'      => Номер по порядку (место) в рейтинге
     * , 'film_name'     => Наименование фильма
     * , 'film_year'     => Год выпуска фильма
     * , 'film_rate'     => Рейтинг фильма
     * , 'film_voic'     => Количество отданых голосов
     * , 'film_sitename' => Адрес сайта
     * , 'film_link'     => Ссылка на детальные данные
     * , 'film_img'      => Изображение фильма
     * , 'film_imgthumb' => Малое изображение фильма
     * , 'local'         => Локальный каталог для картинок
     * )
     * // ... и т.д.
     * )
     * </code>
     */
    public function getSite()
    {
        $site = 'http://kinopoisk.ru';

        $response = $this->browser->get($site . '/level/20/');

        if ($response->isOk()) {
            $file = $response->getContent();
        } else {
            throw new \RuntimeException('Something was wrong while communicating with kinopoisk.ru.');
        }

        // TODO Extract to separate class (ThumbnailManager).
        $localPath = realpath(dirname(__FILE__)) . '/../../../';
        if (!is_dir($localPath . 'web/tmp')) {
            mkdir($localPath . 'web/tmp');
        }
        if (!is_dir($localPath . 'web/bundles/kinosite/img_site/')) {
            mkdir($localPath . 'web/bundles/kinosite/img_site/');
        }

        $crawler = $this->crawlerFactory->createCrawlerFor($file);
        $films   = array();
        $matches = null;
        $voices  = null;
        $year    = null;

        for ($i = 1; $i <= 10; $i++) {
            $tr[$i] = $crawler->filter('#top250_place_' . $i);

            preg_match('/.*(?=(\.))/', $tr[$i]->children()->eq(0)->text(), $matches);
            $title = $tr[$i]->filter('a.all')->eq(0)->text();
            $link  = $tr[$i]->filter('a.all')->attr('href');

            preg_match('/[^(]*.(?=(\)))/', $tr[$i]->children()->eq(2)->filter('span')->text(), $voices);
            $voices = (int) trim(preg_replace('/(?!(\d))./', '', $voices[0]));
            $rating = $tr[$i]->filter('a.continue')->eq(0)->text();

            preg_match('/[^(]*.(?=(\)))/', $title, $year);
            preg_match('/^.*(?=\()/', $title, $name);

            $string = trim($name[0]);
            $string = iconv('utf-8', 'cp1252', $string);
            $string = iconv('cp1251', 'utf-8', $string);

            $linkParts = preg_split('/\//', $link);
            $imageThumbnailUrl = 'http://st.kinopoisk.ru/images/film/' . $linkParts[2] . '.jpg';

            $thumbFile = $this->browser->get($imageThumbnailUrl);
            if ($thumbFile->isOk()) {
                if ( file_put_contents($localPath . 'web/tmp/temp' . $linkParts[2] . '.jpg', $thumbFile->getContent()) > 0 ) {
                    echo 'File "'.$imageThumbnailUrl.'" downloaded.' .chr(10);
                } else {
                    throw new \RuntimeException('Error file write "'.$imageThumbnailUrl.'" in site kinopoisk.ru.');
                }
            } else {
                throw new \RuntimeException('No such file "'.$imageThumbnailUrl.'" in site kinopoisk.ru.');
            }
            
            $imageUrl = 'http://st.kinopoisk.ru/images/film_big/' . $linkParts[2] . '.jpg';
            $bigFile = $this->browser->get($imageUrl);
            if ($bigFile->isOk()) {
                if ( file_put_contents($localPath . 'web/tmp/temp_big' . $linkParts[2] . '.jpg', $bigFile->getContent()) > 0 ) {
                    echo 'File "'.$imageUrl.'" downloaded.' .chr(10);
                } else {
                    throw new \RuntimeException('Error file write "'.$imageUrl.'" in site kinopoisk.ru.');
                }
            } else {
                throw new \RuntimeException('No such file "'.$imageUrl.'" in site kinopoisk.ru.');
            }

            $films[$i - 1] = array(
                'film_pos'        => trim($matches[0])
                , 'film_name'     => $string
                , 'film_year'     => trim($year[0])
                , 'film_rate'     => $rating
                , 'film_voic'     => $voices
                , 'film_sitename' => $site
                , 'film_link'     => $link
                , 'film_img'      => $localPath . 'web/tmp/temp_big' . $linkParts[2] . '.jpg'
                , 'film_imgthumb' => $localPath . 'web/tmp/temp' . $linkParts[2] . '.jpg'
                , 'local'         => $localPath . 'web/bundles/kinosite/img_site/'
            );
        }
        
        return $films;
    }
}
