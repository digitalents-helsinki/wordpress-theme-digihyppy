#!/usr/bin/env bash

GREEN='\033[1;32m'
RED='\033[0;31m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

blue_text_func() {
  echo -e "\n${BLUE}$1${NC}\n"
}

. ./scripts/check_deps.sh

blue_text_func 'Installing php dependencies...'
composer install


blue_text_func 'Setting up docker containers...'
docker-compose up -d --build
docker-compose exec wordpress sh -c "chown -R www-data:www-data /var/www/html/*"

if [[ "$OSTYPE" == "linux-gnu" ]]; then
  blue_text_func 'Linux detected, trying to fix permission issues'
  getent group www-data || groupadd www-data
  sudo chown -R $USER:www-data ../
fi


blue_text_func 'All Done!'
read -p "Do you want to start webpack dev server? [y/N]" -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
  blue_text_func 'Starting webpack on both plugins and theme directories...'
  yarn run dev
else
  exit 0
fi