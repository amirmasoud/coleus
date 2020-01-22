#!/bin/bash

source $(dirname $0)/main.sh

CRT=/nginx/certs/$1.crt
KEY=/nginx/certs/$1.key
if [ ! -f "$CRT" ]; then
    echo "$CRT exist"
    exit 1
fi
if [ ! -f "$KEY" ]; then
    echo "$KEY exist"
    exit 1
fi

eval openssl req -x509 \
    -out nginx/certs/$1.crt \
    -keyout nginx/certs/$1.key \
    -newkey rsa:2048 \
    -nodes -sha256 \
    -subj '/CN=$1' \
    -extensions EXT -config <(
        printf "[dn]\nCN=$1\n[req]\ndistinguished_name = dn\n[EXT]\nsubjectAltName=DNS:$1\nkeyUsage=digitalSignature\nextendedKeyUsage=serverAuth"
    )
