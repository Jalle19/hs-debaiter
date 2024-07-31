# hs-debaiter

sudo apt-get install php-cli php-zip php-mysql php-xml php-json php-curl

docker build -t hs-debaiter .
docker run -p 8080:80 -p 2466:2466 -v $PWD:/app -it --rm hs-debaiter
docker run -v $PWD:/app -it --rm hs-debaiter php app/Console.php import-rss-feed

cp .env.example .env
cp webui/.env.example webui/.env
cp compose.dev.yaml compose.override.yaml
docker compose run --rm app composer install
docker compose run --rm app php app/Console.php import-rss-feed
docker compose up
