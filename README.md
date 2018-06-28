# Features

- Add an event to your calendar

- Update to event on your calendar

- Export your calendar in format csv

# Database

  CREATE DATABASE tutocalendar;

  CREATE TABLE events
  (
    id          int auto_increment primary key,
    name        varchar(255) not null,
    description varchar(255) not null,
    start       datetime     null,
    end         datetime     null
  );
  

# Composer 

composer install

# Php internal server

php -S localhost:8000 -d display_errors=1 -t public
