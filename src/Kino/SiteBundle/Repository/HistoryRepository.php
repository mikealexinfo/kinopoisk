<?php

namespace Kino\SiteBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Kino\SiteBundle\Entity\Film;
use Kino\SiteBundle\Entity\History;

class HistoryRepository extends EntityRepository
{
    /**
     * Метод формирует массив фильтра/сортировки для запроса по входным
     * параметрам с сайта
     * 
     * @param type $field
     * @param type $ord
     * @return string
     */
    public function getOrder($field, $ord)
    {
        $order = array('field'=>'h.historyPosition', 'order'=>'ASC');
        switch ($field) {
            case 'rating':
                $order['field'] = "h.historyRating";
                break;
            case 'voices':
                $order['field'] = "h.historyVotes";
                break;
            case 'name':
                $order['field'] = "f.filmName";
                break;
        }
        switch ($ord) {
            case 'asc':
                $order['order'] = " asc";
                break;
            case 'desc':
                $order['order'] = " desc";
                break;
        }

        return $order;
    }

    // Метод выполняет следующие действия: Получает список фильмов из базы данных
    public function getFilm($getDates, $orders = array('SortField'=>'', 'SortOrder'=>''))
    {
        $repository = $this
                        ->getEntityManager();
        $ord = $this->getOrder($orders['SortField'], $orders['SortOrder']);
        $query = $repository->createQueryBuilder('h')
                            ->select(array('h.historyPosition',
                                           'h.historyVotes',
                                           'h.historyRating',
                                           'f.filmName',
                                           'f.filmYear',
                                           'f.id'
                                          )
                                    )
                            ->from('KinoSiteBundle:History', 'h')
                            ->innerJoin('KinoSiteBundle:Film', 'f')
                            ->where("h.film = f.id")
                            ->andWhere("h.historyDate = :historyDate")
                            ->setParameter('historyDate', $getDates)
                            ->addOrderBy($ord['field'], $ord['order'])
                            ->getQuery()
                            ->useResultCache(true, 300)
                            ;
        return $query->getResult();
    }

    //Метод выполняет следующие действия: Проверяет наличие фильма в базе, ID фильма по передаваемым параметрам (название и год выпуска)
    public function getFilmIdAsMas($data)
    {
        $repository = $this
                        ->getEntityManager()
                        ->getRepository('KinoSiteBundle:Film');
        $query = $repository->createQueryBuilder('f')
                            ->select(array('count(f.id)',
                                           'f.id'
                                          )
                                    )
                            ->where("f.filmName = :films")
                            ->andWhere("f.filmYear = :year")
                            ->setParameter('films', $data['film_name'])
                            ->setParameter('year', $data['film_year'])
                            ->setMaxResults(1)
                            ->getQuery()
                            ->useResultCache(true, 300)
                            ;

        return $query->setMaxResults(1)->getSingleResult();
    }

    //Метод выполняет следующие действия: Проверяет наличие истории для конкретного фильма на заданную дату, ID фильма по передаваемым параметрам (фильм ID и ДатаИстории)
    public function getHistoryIdAsMas($data)
    {
        $repository = $this
                        ->getEntityManager()
                        ->getRepository('KinoSiteBundle:History');
        $query = $repository->createQueryBuilder('h')
                            ->select(array('count(h.id)',
                                           'h.id'
                                          )
                                    )
                            ->where("h.film = :films")
                            ->andWhere("h.historyDate = :date")
                            ->setParameter('films', $data['films_id'])
                            ->setParameter('date', $data['date_history'])
                            ->setMaxResults(1)
                            ->getQuery()
                            ->useResultCache(true, 300)
                            ;

        return $query->setMaxResults(1)->getSingleResult();
    }
}
