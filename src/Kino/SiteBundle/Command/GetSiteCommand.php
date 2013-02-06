<?php

namespace Kino\SiteBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Kino\SiteBundle\Grabber;

/**
 * Модуль консольной команды. Формирует консольную команду kino:getsite, которая позволяет вызвать функцию обращения к
 * сайту кинопоиска из консоли.
 *
 * Возможно выполнение команды через скрипт, а как следствие, можно настроить cron на выполнение скрипта.
 */
class GetSiteCommand extends ContainerAwareCommand
{
    /*
     * Конфигуратор выполняемой команды kino:getsite.
     *
     * Команда не имеет параметров.
     */
    protected function configure()
    {
        $this
                ->setName('kino:getsite')
                ->setDescription('Скачать и обработать топ 10 с кинопоиска')
        ;
    }

    /*
     * Функция исполнения команды kino:getsite
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $mas = Grabber::getSite();
        $em = $this->getContainer()->get('doctrine')->getEntityManager('default');
        $histManager = new \Kino\SiteBundle\HistoryManager($em);

        $repos = $em->getRepository('KinoSiteBundle:History');
// /*
        foreach ($mas as $item) {
            $ms = $repos
                    ->getFilmIdAsMas($item);
            $film_id = 0;

            if ($ms[1] < 1) {
                $film_id = $histManager
                        ->createFilm(array(
                            'films_name' => $item['film_name'],
                            'films_year' => $item['film_year']
                        )
                );
            } else {
                $film_id = $ms['id'];
            }

            copy($item['film_imgthumb'], $item['local'] . $film_id . '.jpg');
            copy($item['film_img'], $item['local'] . $film_id . '_big.jpg');

            $ms_h = $repos
                    ->getHistoryIdAsMas(array('films_id' => $film_id,
                                              'date_history' => date("Y-m-d")));

            if ($ms_h[1] < 1) {
                $dt = new \DateTime("now");
                $hist_id = $histManager
                        ->createHistory(array(
                    'films_id' => $film_id,
                    'historyPosition' => $item['film_pos'],
                    'historyRating' => $item['film_rate'],
                    'historyVotes' => $item['film_voic'],
                    'historyDate' => $dt
                        )
                );
            }
        }
//  */

//        $arr = $repos->getHistoryIdAsMas(array( 'films_id'=>'11', 'date_history'=>'2013-02-01'));
//        $arr = $repos->getFilm('2013-02-01');
//        $output->writeln('-' . $arr . '-');
//        $output->writeln('');
//        foreach ($arr as $k=>$v) {
//            $output->writeln($k . '-' . $v . '-');
//        }
        $output->writeln('Ok');
    }
}
