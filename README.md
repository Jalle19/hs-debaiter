# hs-debaiter

sudo apt-get install php-cli php-zip php-mysql php-xml php-json php-curl

docker build -t hs-debaiter .
docker run -p 8080:80 -p 2466:2466 -v $PWD:/app -it --rm hs-debaiter
docker run -v $PWD:/app -it --rm hs-debaiter php app/Console.php import-rss-feed
