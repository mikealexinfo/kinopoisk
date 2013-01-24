<?php

namespace Kino\SiteBundle;

class HistoryManager
{
    private $em;
    public function __construct($em)
    {
        $this->em = $em;
    }

    // Метод выполняет следующие действия: Создает фильм в базе данных
    public function createFilm($mas)
    {
        $films = new Entity\Film();
        if (isset($mas['films_name'])) {
            $films->setFilmName($mas['films_name']);
        }
        if (isset($mas['films_year'])) {
            $films->setFilmYear($mas['films_year']);
        }

        $em = $this->em;
        $em->persist($films);

        $em->flush();

        return $films->getId();
    }

    //Метод выполняет следующие действия: Создает истрию для фильма
    public function createHistory($mas)
    {
        $history = new Entity\History();

        if (isset($mas['historyPosition'])) {
            $history->setHistoryPosition($mas['historyPosition']);
        }
        if (isset($mas['historyVotes'])) {
            $history->setHistoryVotes($mas['historyVotes']);
        }
        if (isset($mas['historyRating'])) {
            $history->setHistoryRating($mas['historyRating']);
        }
        if (isset($mas['historyDate'])) {
            $history->setHistoryDate($mas['historyDate']);
        }

        $em = $this->em;
        if (isset($mas['films_id'])) {
            $films_id = $em
                    ->getRepository('KinoSiteBundle:Film')
                    ->find($mas['films_id']);

            $history->setFilm($films_id);
        }

        $em->persist($history);

        $em->flush();

        return $history->getId();
    }

}
