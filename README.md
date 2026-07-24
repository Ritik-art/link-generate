# Link Generation System

A simple Laravel project for role based login, invitation, and short URL generation.

## Features

- Login and register
- SuperAdmin, Admin, and Member roles
- Invite new users
- Create short URLs
- Redirect short links to the original URL
- Profile update and account delete

## Tech Stack

- PHP 8.3
- Laravel 13
- Blade
- Simple CSS
- Simple JavaScript
- SQLite database

## Requirements

Before running the project, make sure you have:

- PHP 8.3 or higher
- Laravel 13.8 or higher
- Composer
- SQLite

## Project Setup

### 1. Clone the project

```bash
git clone <your-repo-link>
cd link_generate
```

### 2. setup
 use these steps:

```bash
composer install
```

If you are on Windows and Composer reports a temporary lock on `vendor/composer/installed.php`, run the setup command again after closing any other Composer/PHP process. The project now retries that specific lock automatically during `composer run setup`.

If `.env` is not created yet, copy it from `.env.example`.

```bash
copy .env.example .env
```

### 3. Then generate the app key:

```bash
php artisan key:generate
```

### 4. Set the database

This project uses SQLite by default.

Make sure this file exists:

```bash
database/database.sqlite
```

If it does not exist, create it manually.

Create a MySQL database in localhost phpMyAdmin and update the database name in the `.env` file.

Make sure `SESSION_DRIVER=file` in `.env`, otherwise the browser may show an error.

Then run migrations:

```bash
php artisan migrate
```
Then run seeder command:

```bash
 php artisan db:seed
```
Super Admin Login Credentials

username - superadmin@mail.com
password - password

### 5. Build frontend files
This project does not need a frontend build step.

### 6. Run the project

Use this command to run the project:

```bash
php artisan serve
```

## Default Login Flow

- User opens the login page
- User enters email and password
- After login, user goes to dashboard

## Invitation Flow

- SuperAdmin or Admin sends an invitation
- Invitation link is created
- New user opens the link and registers
- After registration, the invitation status becomes accepted

## Short URL Flow

- User creates a short URL
- System generates a short code
- Short link is saved in the database
- Public users can open the short link and get redirected

## Notes

- Password reset and email verification are not used in this project
- The code is kept simple on purpose

## Useful Commands

```bash
php artisan migrate
php artisan serve
```

## License

This project is open source and can be used for learning or personal work.
