# Setup

set .env

composer inatall

uncomment DatabaseSeeder.php

php artisan migrate --seed

php artisan admin:import log-viewer

# Deploy on Heroku

heroku login

git add .

git commit -am "make it better"

git push heroku master

heroku buildpacks:set heroku/php

heroku run php artisan migrate

heroku run php artisan db:seed

heroku run php artisan admin:import log-viewer