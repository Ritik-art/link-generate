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
- Frontend build tool
- SQLite database

## Requirements

Before running the project, make sure you have:

- PHP 8.3 or higher
- Laravel 13.8 or higher
- Composer
- Frontend tools
- SQLite

## Project Setup

### 1. Clone the project

```bash
git clone <your-repo-link>
cd link_generate
```

### 2. Fast setup

If you want to install everything quickly, run:

```bash
composer run setup
```

This command will:

- install PHP packages
- create the `.env` file if it does not exist
- generate the app key
- run the database migration
- install frontend tools
- build the frontend files

### 3. If you want to do it step by step

If you prefer manual setup, use these steps:

```bash
composer install
```

```bash
npm install
```

If `.env` is not created yet, copy it from `.env.example`.

```bash
copy .env.example .env
```

Then generate the app key:

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

Then run migrations:

```bash
php artisan migrate
```

### 5. Build frontend files

```bash
npm run build
```

### 6. Run the project

Use these two commands in separate terminals:

```bash
php artisan serve
```

```bash
npm run dev
```

If you use the fast setup command, you usually only need this step after that.

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
- The easiest install is `composer run setup`

## Useful Commands

```bash
php artisan migrate
php artisan serve
npm run dev
```

## License

This project is open source and can be used for learning or personal work.
