
FROM php:7.3.3-apache
RUN apt-get update
#RUN apt-get update && apt-get upgrade -y
RUN docker-php-ext-install mysqli
#RUN /bin/bash -c "/usr/bin/mysqld_safe --skip-grant-tables &" && \
#	sleep 5 && \
#	mysql -u root -e "CREATE DATABASE nachweis_db" && \
#	mysql -u root nachweis_db < ./ausbildungsnachweis/nachweis.sql
EXPOSE 80
