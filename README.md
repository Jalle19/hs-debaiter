[![Latest tag](https://ghcr-badge.egpl.dev/jalle19/hs-debaiter-app/latest_tag?color=%2344cc11&ignore=latest&label=version&trim=)](https://github.com/Jalle19/hs-debaiter/pkgs/container/hs-debaiter-app)

# hs-debaiter

A service that keeps track of hs.fi articles and their titles, allowing people to see any previous titles an article 
has had.

## Development

You can use Docker Compose to spin up a development environment. This is used mainly for the app itself and the 
database - the frontend is best developed locally.

```bash
cp .env.example .env
cp webui/.env.example webui/.env
cp compose.dev.yaml compose.override.yaml
docker compose run --rm app composer install
docker compose run --rm app php src/Console.php import-rss-feed
docker compose run --rm app php src/Console.php update-headline-test-titles
docker compose up
```

## Production

Same as development, but copy `compose.prod.yaml` instead and modify it.

Unlike in development, a `frontend` container is started that runs the frontend.

To deploy the thing after pulling in the latest changes, run:

```bash
docker compose down && docker compose build && docker compose up -d
```

## License

GNU General Public License v2.0 or later
