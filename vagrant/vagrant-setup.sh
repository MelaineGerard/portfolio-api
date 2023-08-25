#!/bin/sh

# Update and install php and caddy and mysql
apt update
apt install -y debian-keyring debian-archive-keyring apt-transport-https curl
curl -1sLf 'https://dl.cloudsmith.io/public/caddy/stable/gpg.key' | gpg --dearmor -o /usr/share/keyrings/caddy-stable-archive-keyring.gpg
curl -1sLf 'https://dl.cloudsmith.io/public/caddy/stable/debian.deb.txt' | tee /etc/apt/sources.list.d/caddy-stable.list
apt update
apt install -y caddy php-fpm php-curl php-bcmath php-json php-mysql php-mbstring php-xml php-tokenizer php-zip mariadb-server

# Setup Caddy
cp /home/vagrant/portfolio-api/vagrant/Caddyfile /etc/caddy/Caddyfile
systemctl restart caddy

# Setup Mysql
echo "create database development" | mysql 
echo "CREATE USER 'development'@'%' IDENTIFIED BY 'development'" | mysql 
echo "GRANT ALL PRIVILEGES ON development.* TO 'development'@'%';" | mysql 
echo "flush privileges" | mysql 

# Setup Composer
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# Setup Symfony
cd /home/vagrant/portfolio-api
composer install
php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration
php bin/console cache:clear