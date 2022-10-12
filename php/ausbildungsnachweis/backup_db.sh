#!/bin/bash

SCRIPT_DIR=$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )

cd $SCRIPT_DIR

mysqldump -hlocalhost -uroot -p$(cat /etc/dbpw | tr -d '\n') nachweis_db | grep -v 'Dump completed' > nachweisdb_backup.sql

if [[ -e "nachweisdb_backup.sql" ]]; then
    if diff -q <(cat nachweisdb_backup.sql.md5) <(md5sum nachweisdb_backup.sql); then
        echo "same"
    else 
        openssl aes-256-cbc -a -salt -pbkdf2 -in nachweisdb_backup.sql -out nachweisdb_backup.sql.aes256 -pass pass:$(cat /etc/bupw | tr -d '\n')
        md5sum nachweisdb_backup.sql > nachweisdb_backup.sql.md5
        git add nachweisdb_backup.sql.aes256
        git commit -m "backup $(date '+%Y-%m-%d') nachweisdb_backup.sql.aes256"
    fi
else
    echo "nachweisdb_backup.sql not found"
fi

# file nachweisdb_backup.sql.aes256
# openssl aes-256-cbc -d -a -pbkdf2 -in nachweisdb_backup.sql.aes256 -out nachweisdb_backup.sql
