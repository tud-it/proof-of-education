#!/bin/bash

sudo apt-get install whiptail

CHOSEN_OPTIONS=$(whiptail --title "Nervzettel-Skript-Installer" --checklist \
"Install these things:" 20 78 10 \
"git" "git" ON \
"mariadb" "MariaDB" ON \
"php" "php" ON \
"apache2" "Apache" ON \
"nervzettel" "Nervzettel" ON \
3>&1 1>&2 2>&3);

sudo apt-get install mariadb-client mariadb-server apache2 php

PASSWORD=$(whiptail --passwordbox "MySQL passwort?" 8 78 --title "MySQL-Password" 3>&1 1>&2 2>&3)

echo "echo $PASSWORD > /etc/dbpw" | sudo sh

sudo chmod 0755 /etc/dbpw

if [[ $CHOSEN_OPTIONS == *"git"* ]]; then
    sudo apt-get install git
fi

if [[ $CHOSEN_OPTIONS == *"mariadb"* ]]; then
    sudo apt-get install mariadb-client mariadb-server
    sudo service mysqld stop
    sudo /usr/sbin/mysqld --skip-grant-tables --skip-networking &
    sleep 10
    mysql -hlocalhost -uroot -p$PASSWORD -Bse "FLUSH PRIVILEGES; SET PASSWORD FOR 'root'@'localhost' = PASSWORD(${PASSWORD}');"
fi

if [[ $CHOSEN_OPTIONS == *"apache2"* ]]; then
    sudo apt-get install apache2 php-mysqlnd
fi

if [[ $CHOSEN_OPTIONS == *"php"* ]]; then
    sudo apt-get install php php-mysqlnd
fi

if [[ $CHOSEN_OPTIONS == *"nervzettel"* ]]; then
    INSTALL_DIRECTORY=$(whiptail --inputbox "Where to install Nervzettel to?" 8 39 "/var/www/html/ausbildungszettel" --title "Nervzettel Installer" 3>&1 1>&2 2>&3)
    sudo mkdir -p $INSTALL_DIRECTORY
    cd $INSTALL_DIRECTORY
    
    sudo chown $USER:$USER $INSTALL_DIRECTORY
    
    git clone --depth 1 https://github.com/cloud1160/ausbildungsnachweis.git .
fi

sudo mkdir /var/lib/mysql
sudo chown $USER /var/lib/mysql

mv /var/lib/mysql/ib_logfile0 /var/lib/mysql/ib_logfile0_ORIGINAL
mv /var/lib/mysql/ib_logfile1 /var/lib/mysql/ib_logfile1_ORIGINAL

mv /var/lib/mysql_BACKUP/ib_logfile1 /var/lib/mysql/ib_logfile1_ORIGINAL
mv /var/lib/mysql_BACKUP/ib_logfile0 /var/lib/mysql/ib_logfile0_ORIGINAL

sudo service apache2 restart
sudo service mysqld restart
