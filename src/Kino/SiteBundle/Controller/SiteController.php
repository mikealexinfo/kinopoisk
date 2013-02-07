<?php

namespace Kino\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SiteController extends Controller
{
    /**
     * @Route("/", name="kino_site_homepage")
     * @Template()
     */
    public function mainAction()
    {
        $dates = $this->getRequest()->get('GetDates', date("Y-m-d"));

        $films = $this
            ->getDoctrine()
            ->getEntityManager()
            ->getRepository('KinoSiteBundle:History')
            ->getFilm($dates, array(
                'SortField' => $this->getRequest()->get('SortField', ''),
                'SortOrder' => $this->getRequest()->get('SortOrder', ''),
            ));

        return array(
            // TODO Code style...
            'name'      => 'Топ 10 лучших фильмов ',
            'films'     => $films,
            'post_date' => $dates,
            'SortField' => $this->getRequest()->get('SortField', ''),
            'SortOrder' => $this->getRequest()->get('SortOrder', ''),
        );
    }

    /**
     * @Route("/ajax/{act}", name="ajax")
     */
    public function ajaxAction($act)
    {
        switch ($act) {
            case 'refresh':
                $dates = $this->getRequest()->get('GetDates', date("Y-m-d"));

                return $this->render('KinoSiteBundle:Site:table_films.html.twig', array(
                    'name' => 'Топ 10 лучших фильмов ',
                    'films' => $this
                        ->getDoctrine()
                        ->getEntityManager()
                        ->getRepository('KinoSiteBundle:History')
                        ->getFilm($dates, array(
                            'SortField' => ($this->getRequest()->get('SortField', '')),
                            'SortOrder' => ($this->getRequest()->get('SortOrder', ''))
                        )),
                    'post_date' => $dates,
                    'SortField' => ($this->getRequest()->get('SortField', '')),
                    'SortOrder' => ($this->getRequest()->get('SortOrder', '')),
                ));
                break;
            default:
                return '';
        }

        return $this->render('KinoSiteBundle:Site:index.html.twig', array('name' => $name));
    }
}
