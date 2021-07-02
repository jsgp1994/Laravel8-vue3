#!/bin/bash
sudo apt-get update
echo '900284079' | sudo -S apt-get update

echo 'Instalar php 8.0 y apache'
sudo apt install ca-certificates apt-transport-https software-properties-common
sudo add-apt-repository ppa:ondrej/php
sudo apt install php8.0 libapache2-mod-php8.0

echo 'servidor web Apache con PHP-FPM'
sudo apt install php8.0-fpm libapache2-mod-fcgid
sudo a2enmod proxy_fcgi setenvif
sudo a2enconf php8.0-fpm

sudo systemctl restart apache2

echo 'Instalar extensiones de php'
sudo apt-get install php8.0-xml -y
sudo apt-get install php8.0-gd -y
sudo apt-get install php8.0-intl -y
sudo apt-get install php8.0-xsl -y
sudo apt-get install php8.0-mbstring -y
sudo apt-get install php8.0-zip -y
sudo apt-get install php8.0-pgsql -y
sudo apt-get install php8.0-cli


sudo sed -i ':a;N;$!ba;s/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf
sudo a2enmod rewrite
sudo service apache2 restart

echo 'Instalar version de composer'
sudo php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
sudo php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
sudo php composer-setup.php
sudo php -r "unlink('composer-setup.php');"
sudo mv composer.phar /usr/local/bin/composer

echo 'instalacion del Curl'
sudo apt-get -y install curl
sudo apt-get -y install php8.0-curl

echo 'instalar postgres 13'
sudo apt -y install vim bash-completion wget
wget --quiet -O - https://www.postgresql.org/media/keys/ACCC4CF8.asc | sudo apt-key add -
echo "deb http://apt.postgresql.org/pub/repos/apt/ `lsb_release -cs`-pgdg main" |sudo tee  /etc/apt/sources.list.d/pgdg.list
sudo apt update
sudo apt install postgresql-13 postgresql-client-13
#systemctl status postgresql.service //Verificar servicios
#https://computingforgeeks.com/how-to-install-postgresql-13-on-ubuntu/

sudo systemctl restart postgresql
sudo -u postgres psql -c "alter user postgres with password '900284079'"
sudo -u postgres psql -c "CREATE ROLE superaccess WITH LOGIN PASSWORD '900284079' CREATEDB CREATEROLE"
sudo -u postgres psql -c "CREATE DATABASE prueba"

