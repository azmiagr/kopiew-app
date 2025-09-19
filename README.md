Tentu, ini panduan yang telah diperbarui dengan tag **`shell`** di dalam blok kode.

-----

## Kopiew App

## Prerequisites

Before you begin, ensure that you have the following installed:

  - PHP (^8.2)
  - Node.js (\>= 12)
  - Composer

# Allow your account

1.  Copy `./database/seeders/data/accounts.json.example` to `./database/seeders/data/accounts.json`
2.  Edit with your data
3.  Seeding the database

## Clone the Project

1.  Open your terminal and navigate to the directory where you want to clone the project.
2.  Execute the following command to clone the project from GitHub:

<!-- end list -->

```shell
git clone https://github.com/azmiagr/kopiew-app.git
```

## Project Configuration

1.  Change your current directory to the project's root folder:

<!-- end list -->

```shell
cd kopiew-app
```

2.  Install the required PHP dependencies using Composer:

<!-- end list -->

```shell
composer install
```

3.  Create a copy of the `.env.example` file and rename it to `.env`:

<!-- end list -->

```shell
cp .env.example .env
```

4.  Generate an application key:

<!-- end list -->

```shell
php artisan key:generate
```

5.  Run database migrations:

<!-- end list -->

```shell
php artisan migrate
```

6.  Seed the database with initial data:

<!-- end list -->

```shell
php artisan migrate:seed
```

## Frontend Setup

1.  Install the necessary JavaScript dependencies using NPM:

<!-- end list -->

```shell
npm install
```

2.  Build the frontend assets:

<!-- end list -->

```shell
npm run dev
```

3.  Hot reloading frontend assets

<!-- end list -->

```shell
npm run hot
```

## Start the Application

Once you have completed the setup steps, you can start the Laravel application:

```shell
php artisan serve
```

-----

This will start a development server, and you can access your application by visiting `http://127.0.0.1:8000` in your web browser.

If you have any questions or concerns regarding this project or the instruction provided in this repository, please do not hesitate to contact one or many of the Maintainer of this project 🙂.

Happy coding\!
