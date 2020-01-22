#!/bin/bash

source $(dirname $0)/main.sh

eval "docker-compose exec backend php artisan $@"
