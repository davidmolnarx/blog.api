I developed a RESTful API using Laravel for the backend, along with a React + Next.js-based frontend application for the user interface.

## Local setup

Steps you need to take to make your project work in a local environment:

- clone the blog.api repository
- clone the blog-frontend repository next to blog.api
- copy the contents of the .env.example inside blog.api to an .env file in the blog.api directory
- copy the content of .env.local.example to .env.local file within blog-frontend
- run a `composer install` in the blog.api directory on the host machine
- run `npm install` in the blog-frontend directory on the host machine
- Dockerfiles are included in the repository for simplicity
- docker-compose.yml should be next to the blog.api and blog-frontend directories, create the file here and copy the contents you find in the README here
- run a command from the root folder of the project where the compose file is located: `docker compose up -d`
- run two commands in the blog-day container to prepare the database:
- 1. `php artisan migrate`
- 2. `php artisan migrate:fresh --seed`
- there is a fixed test user with email address: `test@example.com` password: `password`, all other users in the `users` table have password: `password`

A docker-compose.yml tartalma:
```
services:
  blog-api:
    container_name: blog-api
    build:
      context: ./blog.api
      dockerfile: Dockerfile
    ports:
      - "8000:8000"
    volumes:
      - ./blog.api:/var/www
    environment:
      - DB_HOST=blog-mysql-db
      - DB_PORT=3306
      - DB_DATABASE=blog-db
      - DB_USERNAME=root
      - DB_PASSWORD=Test1234
    depends_on:
      - blog-mysql-db
    command: php artisan serve --host=0.0.0.0 --port=8000

  blog-mysql-db:
    container_name: blog-mysql-db
    image: mysql:8.0
    environment:
      - MYSQL_ROOT_PASSWORD=Test1234
      - MYSQL_DATABASE=blog-db
    ports:
      - "3306:3306"
    volumes:
      - mysql_data:/var/lib/mysql
      
  blog-frontend:
    container_name: blog-frontend
    build:
      context: ./blog-frontend
      dockerfile: Dockerfile
    ports:
      - "3000:3000"
    volumes:
      - ./blog-frontend:/app
    environment:
      - NODE_ENV=development
    depends_on:
      - blog-api

volumes:
  mysql_data:
```
![Screenshot from 2025-06-02 02-11-11](https://github.com/user-attachments/assets/60285645-fb3a-4384-9090-adf40344fa63)
![Screenshot from 2025-06-02 03-21-25](https://github.com/user-attachments/assets/60ca4393-1b75-402f-a5de-c8b51d441a63)
