<?php

namespace Kino\SiteBundle;

use Symfony\Component\DomCrawler\Crawler;

use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service("kino.crawler_factory", public=false)
 *
 * @author Alexy Shockov <alexey@shockov.com>
 */
class CrawlerFactory
{
    /**
     * @param string $content
     *
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    public function createCrawlerFor($content)
    {
        return new Crawler($content);
    }
}
