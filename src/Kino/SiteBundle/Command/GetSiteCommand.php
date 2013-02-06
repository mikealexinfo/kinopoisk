<?php

namespace Kino\SiteBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Модуль консольной команды. Формирует консольную команду kino:getsite, которая позволяет вызвать функцию обращения к
 * сайту кинопоиска из консоли.
 *
 * Возможно выполнение команды через скрипт, а как следствие, можно настроить cron на выполнение скрипта.
 */
class GetSiteCommand extends ContainerAwareCommand
{
    /**
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

    /**
     * Функция исполнения команды kino:getsite
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $grabber           = $this->getContainer()->get('kino.grabber');
        $entityManager     = $this->getContainer()->get('doctrine')->getEntityManager('default');
        // TODO To DIC.
        $historyManager    = new \Kino\SiteBundle\HistoryManager($entityManager);
        $historyRepository = $entityManager->getRepository('KinoSiteBundle:History');

        $films = $grabber->getSite();

        foreach ($films as $item) {
            $film = $historyRepository->getFilmIdAsMas($item);

            $filmId = 0;

            if ($film[1] < 1) {
                $filmId = $historyManager
                        ->createFilm(array(
                            'films_name' => $item['film_name'],
                            'films_year' => $item['film_year']
                        )
                );
            } else {
                $filmId = $film['id'];
            }

            copy($item['film_imgthumb'], $item['local'] . $filmId . '.jpg');
            copy($item['film_img'], $item['local'] . $filmId . '_big.jpg');

            // TODO Внутри getSingleResult(), нужен catch на исключение!
            $history = $historyRepository->getHistoryIdAsMas(
                array(
                    'films_id' => $filmId,
                    'date_history' => date("Y-m-d")
                )
            );

            if ($history[1] < 1) {
                $historyId = $historyManager->createHistory(
                    array(
                        'films_id'        => $filmId,
                        'historyPosition' => $item['film_pos'],
                        'historyRating'   => $item['film_rate'],
                        'historyVotes'    => $item['film_voic'],
                        'historyDate'     => (new \DateTime("now"))
                    )
                );
            }
        }

        // TODO Debug output.
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
