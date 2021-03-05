#! /bin/sh
docker build -t lumen lumen
docker stop $(docker ps -qa)
docker-compose rm -f
docker-compose up