# docker-compose-laravel
A pretty simplified Docker Compose workflow that sets up a LEMP network of containers for local Laravel development. You can view the full article that inspired this repo [here](https://dev.to/aschmelyun/the-beauty-of-docker-for-local-laravel-development-13c0).


## Usage

To get started, make sure you have [Docker installed] on your system, and then clone this repository.

Next, navigate in your terminal to the directory you cloned this, and spin up the containers for the web server by running `docker-compose up -d --build site`.

Open `Docker Terminal`

Run the following commands

`php artisan migrate`
`php artisan db:seed`

Run test coverage

`./vendor/bin/phpunit --coverage-html tests/coverage`

Coverate report can be view as html from `/test/coverage/index.html`

Admin user
`admin`
`adminpassword`
