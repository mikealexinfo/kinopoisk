<?php

namespace Kino\SiteBundle;

use Symfony\Component\DomCrawler\Crawler;

class Grabber
{
    /*
      Функция закачки странички кинопоиска и парсинга данных этой страницы.
      Возвращает массив данных следующего вида.
      array(
      [0] => array(
      'film_pos'      => Номер по порядку(место) в рейтинге
      , 'film_name'     => Наименование фильма
      , 'film_year'     => Год выпуска фильма
      , 'film_rate'     => Рейтинг фильма
      , 'film_voic'     => Количество отданых голосов
      , 'film_sitename' => Адрес сайта
      , 'film_link'     => Ссылка на детальные данные
      , 'film_img'      => Изображение фильма
      , 'film_imgthumb' => Малое изображение фильма
      , 'local'         => Локальный каталог для картинок
      )
      ... и т.д.
      )
     */
    public static function getSite()
    {
        $sitename = "http://kinopoisk.ru";
        $filename = $sitename . "/level/20/";
        $file = file_get_contents($filename);
        $local_path = realpath(dirname(__FILE__)) . '/../../../';
        if (!is_dir($local_path . 'web/tmp')) {
            mkdir($local_path . 'web/tmp');
        }
        if (!is_dir($local_path . 'web/kinosite/img_site/')) {
            mkdir($local_path . 'web/kinosite/img_site/');
        }


        $crawler = new Crawler($file);
        $films = array();
        $num = 0;
        $voices = null;
        $year = null;

        for ($i = 1; $i <= 10; $i++) {
            $tr[$i] = $crawler->filter('#top250_place_' . $i);

            preg_match('/.*(?=(\.))/', $tr[$i]->children()->eq(0)->text(), $num);
            $nm = $tr[$i]->filter('a.all')->eq(0)->text();
            $link = $tr[$i]->filter('a.all')->attr('href');
            preg_match('/[^(]*.(?=(\)))/', $tr[$i]->children()->eq(2)->filter('span')->text(), $voices);
            $voices = (int) trim(preg_replace('/(?!(\d))./', '', $voices[0]));
            $rating = $tr[$i]->filter('a.continue')->eq(0)->text();

            preg_match('/[^(]*.(?=(\)))/', $nm, $year);
            preg_match('/^.*(?=\()/', $nm, $name);

            $string = trim($name[0]);
            $string = iconv('utf-8', 'cp1252', $string);
            $string = iconv('cp1251', 'utf-8', $string);

            $arr_link = preg_split('/\//', $link);
            $img_path = 'http://st.kinopoisk.ru/images/film_big/' . $arr_link[2] . '.jpg';
            $img_thumb = 'http://st.kinopoisk.ru/images/film/' . $arr_link[2] . '.jpg';
            copy($img_thumb, $local_path . 'web/tmp/temp' . $arr_link[2] . '.jpg');
            copy($img_path, $local_path . 'web/tmp/temp_big' . $arr_link[2] . '.jpg');

            $films[$i - 1] = array(
                'film_pos' => trim($num[0])
                , 'film_name' => $string
                , 'film_year' => trim($year[0])
                , 'film_rate' => $rating
                , 'film_voic' => $voices
                , 'film_sitename' => $sitename
                , 'film_link' => $link
                , 'film_img' => $local_path . 'web/tmp/temp_big' . $arr_link[2] . '.jpg'
                , 'film_imgthumb' => $local_path . 'web/tmp/temp' . $arr_link[2] . '.jpg'
                , 'local' => $local_path . 'web/kinosite/img_site/'
            );
        }

        return $films;
    }

}