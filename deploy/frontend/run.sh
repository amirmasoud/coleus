#!/bin/bash

if [ ${PRODUCTION} = true ]; then
        yarn start
    else
        yarn dev
;fi
