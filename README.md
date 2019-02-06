# Wordpress Theme Digihyppy

## Prerequirements

You need to install these softwares before development.

- Docker CE `^18.09.1`
- Docker Compose `^1.23.2`
- yarn `^1.6.0`
- node.js `LTS 10.15.0`
- Composer `^1.7.1`

## Development

Before getting started, make sure you have `.env` file in the root of this repo.

e.g.

```sh
DB_USER=
DB_PASSWORD=
DB_NAME=
```

### Steps

- run `./scripts/start.sh`. This might take a hot second.
- Once the script has finished and you've started the webpack dev server, navigate to `http://localhost:4000` (this is the proxy for the wordpress instance with hot reloading).
- From the Wordpress admin panel, activate the theme from _Appearence_ tab.
- That's it.

### start.sh

The start.sh script installs php and node dependencies, and starts the WP and MySQL containers. It also can optionally start the development proxy server for you, which enables auto-reloading on filechanges located in src/ directory.

If you wish to do the steps for yourself:

- `$ cd blocks && yarn && cd ..` (installs node deps on the blocks plugins directory)
- `$ yarn` (installs node deps on theme directory)
- `$ docker-compose up -d --build` (Builds and ups the docker containers)
- `$ docker-compose exec wordpress sh -c "chown -R www-data:www-data /var/www/html/*"` (Sets rights for the directory)
- **[FOR LINUX]** `$ getent group www-data || groupadd www-data && sudo chown -R $USER:www-data ../`
- `$ yarn run dev` (starts the dev proxy server.)
