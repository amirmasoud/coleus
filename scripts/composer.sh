#!/bin/bash

cd "$(dirname "$0")"
cd "../deploy"

eval "docker-compose exec backend composer $@"
