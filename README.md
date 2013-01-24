# Топ 10 фильмов с сайта http://kinopoisk.ru/

## Тестовое портфолио лаборатории разработки и консалтинга

* Обращается к сайту http://kinopoisk.ru/ и считывает первые 10 записей из
    фильмов кинорейтинга
* Обновление фильмов выполняется с помощью команды:
    _php app/console kino:getsite_
* Обновление возможно лишь один раз в сутки
    для накопления БД рейтингов, необходимо настроить соответствующим образом 
    _cron_ на выполнение соответствующей команды

## Установка на localhost

1. Зайти в локальную папку куда будем клонировать проект (в командной строке 
    gitshell).
2. _git clone https://github.com/mikealexinfo/kinopoisk.git_
3. _cd kinopoisk_
4. Настроить конфигурационный файл _parameters.yml_.
    Скопировать _app/config/parameters.yml.dist_ в файл _app/config/parameters.yml_
    Отредактировать _app/config/parameters.yml_, прописав в него подключение к БД
5. _php composer.phar install_
6. Настраиваем apache и php правильно на исполнение проекта, например:
    _http://kinoarc.local/_
7. Выполняем команду _php app/console doctrine:schema:update --force_
8. Выполняем команду _php app/console kino:getsite_
9. Набираем в браузере команду _http://kinoarc.local/_

## Пример использования

Готовый работающий проект с настроенным _cron_ можно просмотреть здесь:
    _http://symfony2.golddraft.ru/_
