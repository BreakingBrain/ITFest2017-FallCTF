#!/bin/bash

debconf-set-selections <<< "mysql-server-5.7 mysql-server/root_password password 123"
debconf-set-selections <<< "mysql-server-5.7 mysql-server/root_password_again password 123"
apt-get update && apt-get install -y php php-fpm mysql-server-5.7 nginx php-mysql 

sed -i "s/.*bind-address.*/bind-address = 127.0.0.1/" /etc/mysql/my.cnf
service mysql start
mysql -uroot -p123 <<< "CREATE DATABASE db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -uroot -p123 <<< "CREATE USER user IDENTIFIED BY '123456'"
mysql -uroot -p123 <<< "GRANT ALL PRIVILEGES ON db.* TO 'user'@'%' IDENTIFIED BY '123456'"
mysql -uroot -p123 <<< "CREATE TABLE db.browser_info(id INTEGER NOT NULL AUTO_INCREMENT, fingerprint VARCHAR(100), info VARCHAR(1024) NOT NULL, PRIMARY KEY(id));";
mysql -uroot -p123 <<< "INSERT INTO db.browser_info(info) VALUES('{\'user_agent\': \'ITF{SQL1nj3ct1on1sBAYAN!!1}\'}')";