#!/bin/bash

# Backend
cd '../laradock'
eval 'docker-compose -f production-docker-compose.yml up -d nginx postgres redis kibana workspace'

# Frontend
cd '../client'
eval 'docker-compose up --build -d'
