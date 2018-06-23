#!/usr/bin/env bash

sudo /etc/init.d/mysql start

sudo mysql mysql -e "CREATE USER 'vagrant'@'localhost' IDENTIFIED BY 'vagrant';"

sudo mysql mysql -e "GRANT ALL PRIVILEGES ON *.* TO 'vagrant'@'localhost' WITH GRANT OPTION"