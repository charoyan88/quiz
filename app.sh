#!/bin/bash

# Allowed Arguments
start=true
fresh=false
fresh_db=false
stop=false
composer=false
npm=false
npm_watch=false
migrate=false
seed=false
datasets=false
storage=false
restart=false

# Parse command-line arguments
while [[ $# -gt 0 ]]; do
  key="$1"
  case $key in
  --fresh-db)
    fresh_db=true
    migrate=true
    seed=true
    start=false
    shift
    ;;
  --fresh)
    fresh=true
    composer=true
    npm=true
    migrate=true
    seed=true
    stop=true
    storage=true
    shift
    ;;
  --restart)
    start=false
    restart=true
    shift
    ;;
  --composer)
    composer=true
    start=false
    shift
    ;;
  --npm)
    npm=true
    start=false
    shift
    ;;
  --npm-watch)
    npm_watch=true
    start=false
    shift
    ;;
  --migrate)
    migrate=true
    start=false
    shift
    ;;
  --seed)
    seed=true
    start=false
    shift
    ;;
  --start)
    stop=true
    start=true
    storage=true
    shift
    ;;
  --stop)
    stop=true
    start=false
    shift
    ;;
  --storage)
    storage=true
    start=false
    shift
    ;;
  --face-api)
    start=false
    faceapi=true
    shift
    ;;
  *)
    echo "Invalid argument: $1"
    exit 1
    ;;
  esac
done

# Restart
if [[ $restart == true ]]; then
  docker-compose restart
fi

# Remove services if stop provided
if [[ $stop == true ]]; then
  docker-compose down
fi

# Composer
if [[ $composer == true ]]; then
  echo -e '\033[32mRunning composer install...\033[0m'
  docker run -it --rm -u "$(id -u):$(id -g)" -v $(pwd):/app composer install --ignore-platform-reqs
fi

# Node modules
if [[ $npm == true ]]; then
  echo -e '\033[32mRunning npm install...\033[0m'
  docker run -it --rm -v $(pwd):/app -w /app node:latest npm install
  echo -e '\033[32mRunning npm run prod...\033[0m'
  docker run -it --rm -v $(pwd):/app -w /app node:latest npm run prod
fi

# Frontend watch
if [[ $npm_watch == true ]]; then
  echo -e '\033[32mRunning npm run watch...\033[0m'
  docker run -it --rm --init -u "$(id -u):$(id -g)" -v $(pwd):/app -w /app node:latest npm run watch
fi

# Start services
if [[ $start == true ]]; then
  echo -e '\033[32mRunning services...\033[0m'
  UID=$(id -u) GID=$(id -g) docker-compose up -d
fi

# Key generate
if [[ $fresh == true ]]; then
  echo -e '\033[32m Generating Laravel app key...\033[32m'
  docker-compose exec app php artisan key:generate
fi

# Migrations
if [[ $migrate == true ]]; then
  echo -e '\033[32mRunning Migrations...\033[0m'
  if [[ $fresh == true || $fresh_db == true ]]; then
    docker-compose exec app php artisan migrate:fresh
  else
    docker-compose exec app php artisan migrate
  fi
fi

# Seeders
if [[ $seed == true ]]; then
  echo -e '\033[32mRunning seeds...\033[0m'
  docker-compose exec app php artisan db:seed
fi

# Link Storage
if [[ $storage == true ]]; then
  echo -e '\033[32mStorage linking...\033[0m'
  docker-compose exec -T app php artisan storage:link
fi




