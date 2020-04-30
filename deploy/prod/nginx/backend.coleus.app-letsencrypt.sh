#!/bin/bash

read_var() {
  VAR=$(grep $1 ../../../.env | xargs -0)
  IFS="=" read -ra VAR <<<"$VAR"
  echo ${VAR[1]}
}

if ! [ -x "$(command -v docker-compose)" ]; then
  echo 'Error: docker-compose is not installed.' >&2
  exit 1
fi

domains=(backend.coleus.app www.backend.coleus.app)
rsa_key_size=4096
data_path="./certbot"
email=$(read_var CERTBOT_EMAIL) # Adding a valid address is strongly recommended
staging=0                       # Set to 1 if you're testing your setup to avoid hitting request limits

if [ -d "$data_path" ]; then
  read -p "Existing data found for $domains. Continue and replace existing certificate? (y/N) " decision
  if [ "$decision" != "Y" ] && [ "$decision" != "y" ]; then
    exit
  fi
fi

if [ ! -e "$data_path/conf/options-ssl-nginx.conf" ] || [ ! -e "$data_path/conf/ssl-dhparams.pem" ]; then
  echo "### Downloading recommended TLS parameters ..."
  mkdir -p "$data_path/conf"
  curl -s https://raw.githubusercontent.com/certbot/certbot/master/certbot-nginx/certbot_nginx/_internal/tls_configs/options-ssl-nginx.conf >"$data_path/conf/options-ssl-nginx.conf"
  curl -s https://raw.githubusercontent.com/certbot/certbot/master/certbot/certbot/ssl-dhparams.pem >"$data_path/conf/ssl-dhparams.pem"
  echo
fi

echo "### Creating dummy certificate for $domains ..."
path="/etc/letsencrypt/live/$domains"
mkdir -p "$data_path/conf/live/$domains"
docker-compose --env-file ../../../.env -f ../../../docker-compose.yml run --rm --entrypoint "\
  openssl req -x509 -nodes -newkey rsa:1024 -days 1\
    -keyout '$path/privkey.pem' \
    -out '$path/fullchain.pem' \
    -subj '/CN=localhost'" ssl
echo

echo "### Starting nginx ..."
nginx
# docker-compose --env-file ../../../.env -f ../../../docker-compose.yml up --force-recreate -d proxy
echo

echo "### Deleting dummy certificate for $domains ..."
docker-compose --env-file ../../../.env -f ../../../docker-compose.yml run --rm --entrypoint "\
  rm -Rf /etc/letsencrypt/live/$domains && \
  rm -Rf /etc/letsencrypt/archive/$domains && \
  rm -Rf /etc/letsencrypt/renewal/$domains.conf" ssl
echo

echo "### Requesting Let's Encrypt certificate for $domains ..."
#Join $domains to -d args
domain_args=""
for domain in "${domains[@]}"; do
  domain_args="$domain_args -d $domain"
  domain_args="$domain_args -d backend.$domain"
  domain_args="$domain_args -d storage.$domain"
  domain_args="$domain_args -d image.$domain"
  domain_args="$domain_args -d graphql.$domain"
done

# Select appropriate email arg
case "$email" in
"") email_arg="--register-unsafely-without-email" ;;
*) email_arg="--email $email" ;;
esac

# Enable staging mode if needed
if [ $staging != "0" ]; then staging_arg="--staging"; fi

# --webroot -w /var/www/certbot \
docker-compose --env-file ../../../.env -f ../../../docker-compose.yml run --rm --entrypoint "\
  certbot certonly --dns-cloudflare --dns-cloudflare-credentials /etc/letsencrypt/cloudflare.ini \
    --preferred-challenges dns-01 \
    $staging_arg \
    $email_arg \
    $domain_args \
    --rsa-key-size $rsa_key_size \
    --agree-tos \
    --force-renewal" ssl
echo

# echo "### Reloading nginx ..."
# docker-compose --env-file ../../../.env -f ../../../docker-compose.yml exec proxy nginx -s reload
