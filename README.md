// Установка image magick (для генерации QR)
sudo apt install imagemagick php8.4-imagick php-dev libmagickwand-dev -y
sudo service apache2 restart

// Установка composer
php composer.phar install

// Настройка прав доступа
sudo chown -R www-data:www-data short-link-service
sudo chmod -R 777 short-link-service

// Создание БД
sudo mysql
create schema short;
create user short@localhost identified by 'short';
grant all privileges on short.* to short@localhost;

// Создание таблиц в БД
php yii migrate
  
