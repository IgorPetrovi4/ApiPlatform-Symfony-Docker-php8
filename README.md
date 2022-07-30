# Symfony Docker

A [Docker for Symfony API](https://github.com/dunglas/symfony-docker)-All the details on deploying the application server ..

## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/)
2. Run `docker-compose build --pull --no-cache` to build fresh images
3. Run `docker-compose up` (the logs will be displayed in the current shell)
4. Open `https://localhost/api` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
5. Run `docker-compose down --remove-orphans` to stop the Docker containers.
6. Run `php bin/console make:docker:database` Postgre DB
7. `OPTIONAL*` Install [Symfony CLI](https://symfony.com/download) , Run `symfony var:export --multiline` To find out the port on which the database is running if there is no other possibility, for example, when working from under WSL2
8. Fill in `DATABASE_URL` variable in `.env` file
9. Run `bin/console doctrine:database:create`
10. Run `bin/console make:migration`
11. Run `bin/console doctrine:migrations:migrate`

## Features
* Fill in the category and product data on the localhost/api page.

* Execute console command 
  - `bin/console api:import https://localhost/api/categories?page=1`
  - `bin/console api:import https://localhost/api/categories`
  - `bin/console api:import https://localhost/api/products?page=1`
  - `bin/console api:import https://localhost/api/products`

* The execution should end with the message:
`[OK] Your file is ready, click the link  https://localhost/download_files/api/categories.json`
* Click the link
* commands `product:import` and `category:import` to import files to
  categories.json and  products.json  combined into one `api:import` command , but it generates files according to the task condition, depending on the accepted api route.
*The json data record files is stored along the path `public/download_files/api`


[Task description](https://docs.google.com/document/d/1y4C-zTdtCqii-XGFlUp53wkjdSS8lLHVvWDU-Q_GJAw/edit#)

