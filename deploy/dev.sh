#!/bin/bash

# Backend
cd '../laradock'
eval 'docker-compose up -d nginx postgres redis kibana workspace'

# Frontend
cd '../client'
eval 'yarn run dev'
