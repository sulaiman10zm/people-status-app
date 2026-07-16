# People Status App

A small PHP and MySQL application for adding people, displaying their records, and toggling each person's status between `0` and `1` without reloading the page.

## Features

- Add a person's name and age.
- Store records in a MySQL database.
- Display all records in a table.
- Toggle a record's status using JavaScript and Fetch API.
- Validate input on both the client and server.

## Requirements

- PHP 8.0 or later
- MySQL or MariaDB
- A local web server such as XAMPP

## Setup

1. Place the project folder inside your web server directory, such as `xampp/htdocs`.
2. Create a database named `people_status`.
3. Import `database.sql` into the database.
4. Copy `config_example.php` as `config.php`.
5. Update the database credentials in `config.php`.
6. Open `http://localhost/people-status-app` in your browser.

## Project Files

- `index.php` — displays the form and records.
- `add.php` — validates and adds new records.
- `toggle.php` — changes a record's status.
- `script.js` — handles form submission and status updates.
- `style.css` — contains the page styles.
- `database.sql` — creates the table and sample records.
- `config_example.php` — database configuration template.
