<?php

namespace Kino\SiteBundle;

class HistoryManager
{
    private $em;
    public function __construct($em)
    {
        $this->em = $em;
    }

    /**
     * Метод создает в БД запись в таблице Film
     * 
     * @param type $data
     * @return type
     */
    public function createFilm($data)
    {
        $films = new Entity\Film();
        if (isset($data['films_name'])) {
            $films->setFilmName($data['films_name']);
        }
        if (isset($data['films_year'])) {
            $films->setFilmYear($data['films_year']);
        }

        $em = $this->em;
        $em->persist($films);

        $em->flush();

        return $films->getId();
    }

    /**
     * Метод создает запись в таблице истории для фильма
     * 
     * @param type $data
     * @return type
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
            $filmsId = $em
                    ->getRepository('KinoSiteBundle:Film')
                    ->find($data['films_id']);

            $history->setFilm($filmsId);
        }

        $em->persist($history);

        $em->flush();

        return $history->getId();
    }
}
