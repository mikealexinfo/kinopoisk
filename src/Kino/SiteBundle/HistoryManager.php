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

    /**
     * Метод создает истрию для фильма
     */
    public function createHistory($data)
    {
        $history = new Entity\History();

        if (isset($data['historyPosition'])) {
            $history->setHistoryPosition($data['historyPosition']);
        }
        if (isset($data['historyVotes'])) {
            $history->setHistoryVotes($data['historyVotes']);
        }
        if (isset($data['historyRating'])) {
            $history->setHistoryRating($data['historyRating']);
        }
        if (isset($data['historyDate'])) {
            $history->setHistoryDate($data['historyDate']);
        }

        $em = $this->em;
        if (isset($data['films_id'])) {
            $films_id = $em
                    ->getRepository('KinoSiteBundle:Film')
                    ->find($data['films_id']);

            $history->setFilm($films_id);
        }

        $em->persist($history);

        $em->flush();

        return $history->getId();
    }
}
