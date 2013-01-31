<?php

namespace Kino\SiteBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Kino\SiteBundle\Entity\Film;
use Kino\SiteBundle\Entity\History;
use Kino\SiteBundle\Grabber;

class HistoryRepository extends EntityRepository
{
    public function getOrder($field, $ord)
    {
        $order = "order by ";
        switch ($field) {
            case 'rating':
                $order .= "h.historyRating";
                break;
            case 'voices':
                $order .= "h.historyVotes";
                break;
            case 'name':
                $order .= "f.filmName";
                break;
            default: $order .= "h.historyPosition";
        }
        switch ($ord) {
            case 'asc':
                $order .= " asc";
                break;
            case 'desc':
                $order .= " desc";
                break;
            default: $order .= " asc";
        }
        return $order;
    }

    // Метод выполняет следующие действия: Получает список фильмов из базы данных
    public function getFilm($getDates, $orders = array())
    {
        $order = $this
                  ->getOrder($orders['SortField'], $orders['SortOrder']);
        return $this
                ->getEntityManager()
                ->createQuery("SELECT 
                                    h.historyPosition,
                                    h.historyVotes,
                                    h.historyRating,
                                    f.filmName,
                                    f.filmYear,
                                    f.id 
                                 FROM KinoSiteBundle:History h JOIN  h.film f 
                                WHERE h.historyDate = :Getdates " . $order)
                ->setParameter('Getdates', $getDates)
                ->getResult();
    }

    //Метод выполняет следующие действия: Проверяет наличие фильма в базе, ID фильма по передаваемым параметрам (название и год выпуска)
    public function getFilmIdAsMas($mas)
    {
/*
        $repository = $this->getDoctrine()
                           ->getRepository('KinoSiteBundle:Film');
        $query = $repository->createQueryBuilder('f')
                            ->where('p.price > :price')
                            ->setParameter('price', '19.99')
                            ->orderBy('p.price', 'ASC')
                            ->getQuery();

        $film = $query->getResult();
*/        
        return $this
                ->getEntityManager()
                ->createQuery("SELECT 
                                    count(f.id),
                                    f.id
                                 FROM KinoSiteBundle:Film f 
                                WHERE f.filmName = :films
                                        AND f.filmYear = :year ")
                ->setParameters(array(
                            'films' => $mas['film_name'],
                            'year' => $mas['film_year']
                        )
                   )
                ->setMaxResults(1)
                ->getSingleResult();
    }

    //Метод выполняет следующие действия: Проверяет наличие истории для конкретного фильма на заданную дату, ID фильма по передаваемым параметрам (фильм ID и ДатаИстории)
    public function getHistoryIdAsMas($mas)
    {

        return $this
                ->getEntityManager()
                ->createQuery("SELECT 
                                    count(h.id), 
                                    h.id 
                                 FROM KinoSiteBundle:History h 
                                WHERE h.film = :films 
                                        AND h.historyDate = :date ")
                ->setParameters(array('films' => $mas['films_id'],
                                      'date' => $mas['date_history']))
                ->setMaxResults(1)
                ->getSingleResult();
    }
}