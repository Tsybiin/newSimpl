
<h3> Окружение для запуска openvpn c регистрацией клиентов и получением ключей vpn </h3>

<hr>
<h5>Как запустить:</h5>

- `docker-compose build && docker-compose up -d`

<b>composer:<br></b>
зайти в php контенер
- `docker exec -it php-fpm bash`
<p>выполнить</p>

- `cd /usr/share/nginx/html/public/composer/ &&
    composer install`
<hr>
<b>MYSQL:<br></b> dump базы:

- `cat docker/build/mysql/px.sql | docker exec -i mysql /usr/bin/mysql -u bitrix --password=password bitrix`

 настроки бд
- ip mysql <b>172.16.1.15</b>
- Вход в контейнер `docker exec -it mysql bash"`
- MYSQL_USER=bitrix
- MYSQL_PASSWORD=password
- MYSQL_DATABASE=bitrix
- MYSQL_ROOT_USER=root
- MYSQL_ROOT_PASSWORD**=root
<hr>
в дерикторию /var/www/public
 Установить 1С-Битрикс: Управление сайтом
<hr>
**MAIL**

Исходящие письма будут попадать в каталог <a  href="./mail">mail</a> <br>


