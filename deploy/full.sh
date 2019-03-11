#!/bin/bash

# Backend
cd '../laradock'
eval 'docker-compose -f production-docker-compose.yml up -d nginx postgres redis kibana workspace'
eval 'docker-compose exec workspace php artisan migrate'

pg_dumpall -c -U postgres | gzip > /var/data/postgres/backups/dump_date +%d-%m-%Y"_"%H_%M_%S.gz

# Frontend
cd '../client'
eval 'docker-compose up --build -d'
