## Epic-movie-quotes

The Movie-Quotes app is a website where users can sign up and access various features related to movies and their quotes. Once registered, users can log in to the app and do the following functionalities:

News Feed: Upon logging in, users are taken to the news feed page. Here, they can see a continuous stream of quotes posted by other users. They can like and leave the comments to quotes.

Movie List: The app also has movie list page where Users can add the movies see there collection of movies. They can view information about each movie, including its title, description, and other details. By selecting a specific movie from the Movie List, users can access movie with quotes associated with that movie. and they can manage that quotes by edit or create methods, Similarly, users can also manage movies within the app. They have the ability to edit the details of an existing movie or delete it.

Profile page:user also can manage there profile and update the information about themselves ad needed.

## Table of Contents

-   Prerequisites
-   Tech Stack
-   Getting Started
-   Migration
-   Development
-   Database diagram

## Prerequisites

-   PHP@8.2 and up
-   MYSQL@8 and up
-   npm@9 and up
-   composer@2 and up

## Teck stack

-   Laravel@10.5 - back-end framework
-   Spatie Translatable - package for translation
-   Laravel Socialite - provides an expressive, fluent interface to OAuth authentication
-   Laravel Sanctum - provides a featherweight authentication system for SPAs and simple APIs
-   Pusher - real-time communication layer between the server and the client

## Getting started

1. First you need to clone Coronatime repository from github

```bash
https://github.com/RedberryInternship/mariam-revia-epic-movie-quotes-api.git
```

2. Next run composer install in order to install all the dependencies.

```bash
composer install
```

3. Install all the JS dependencies:

```bash
npm install
```

and also

```bash
npm run dev
```

4. Now we need to set our env file. Go to the root of your project and execute this command.

```bash
cp .env.example .env
```

should also provide .env file all the necessary environment variables:

## MYSQL

> DB_CONNECTION=mysql

> DB_HOST=127.0.0.1

> DB_PORT=3306

> DB_DATABASE=**\***

> DB_USERNAME=**\***

> DB_PASSWORD=**\***

## Gmail SMTP

> MAIL_DRIVER=smtp

> MAIL_HOST=smtp.gmail.com

> MAIL_PORT=465

> MAIL_USERNAME=Enter your Gmail address

> MAIL_PASSWORD=**\***

> MAIL_ENCRYPTION=ssl

> MAIL_FROM_NAME=Newsletter

## Pusher

> PUSHER_APP_ID=**\***

> PUSHER_APP_KEY=**\***

> PUSHER_APP_SECRET=**\***

> PUSHER_HOST=

> PUSHER_PORT=443

> PUSHER_SCHEME=https

> PUSHER_APP_CLUSTER=

5. Execute following in root of your project

```bash
  php artisan key:generate
```

this generates auth key

## Migration

Then migrating database

```bash
php artisan migrate
```

## Development

Run Laravel's built-in development server by executing:

```bash
 php artisan serve
```

On JS you may run:

```bash
 npm run dev
```

## Database diagram

![diagram](https://i.ibb.co/dfTcLqm/draw-SQL-epic-movie-quotes-export-2023-07-19.png)
