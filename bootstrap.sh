#!/usr/bin/env bash

sudo apt-get -y update
echo "mysql-server-5.5 mysql-server/root_password_again password password" | debconf-set-selections
echo "mysql-server-5.5 mysql-server/root_password password password" | debconf-set-selections
sudo apt-get -y install lamp-server^
sudo apt-get -y install git
sudo apt-get -y install vim
sudo rm -rf /var/www
sudo ln -fs /vagrant /var/www
sudo cp /usr/share/doc/php5-common/examples/php.ini-development /etc/php5/apache2/php.ini
sudo a2enmod rewrite
sudo cp /liis-support/sites-available.default /etc/apache2/sites-available/default
sudo /etc/init.d/apache2 restart

echo "--------------------------------"
echo "Please install the database now."
echo "--------------------------------"
echo "/site_root/install/"
echo "--------------------------------"