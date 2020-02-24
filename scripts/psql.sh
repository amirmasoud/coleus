#!/bin/bash

source $(dirname $0)/main.sh

eval "docker-compose exec database bash -c 'psql -U postgres'"
