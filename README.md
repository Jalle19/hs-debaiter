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
docker compose up
```

## Production

Same as development, but copy `compose.prod.yaml` instead and modify it.

To deploy the thing after pulling in the latest changes, run:

```bash
docker compose down && docker compose build app && docker compose up -d
```

## Running without Docker Compose

Something like this, you'll figure it out:

```bash
docker build -t hs-debaiter .
docker run -p 8080:80 -p 2466:2466 -v $PWD:/app -it --rm hs-debaiter
docker run -v $PWD:/app -it --rm hs-debaiter php src/Console.php import-rss-feed
```
