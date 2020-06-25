#!/bin/bash

source $(dirname $0)/main.sh

eval "cd ../../ && docker-compose -f docker-compose.dev.yml exec backend php artisan $@"
