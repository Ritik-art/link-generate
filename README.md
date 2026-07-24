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
- Tailwind CSS
- Alpine.js
- Vite
- SQLite database

## Requirements

Before running the project, make sure you have:

- PHP 8.3 or higher
- Composer
- Node.js and npm
- SQLite

## Project Setup

### 1. Clone the project

```bash
git clone <your-repo-link>
cd link_generate
```

### 2. Install PHP packages

```bash
composer install
```

### 3. Install Node packages

```bash
npm install
```

### 4. Create the `.env` file

If `.env` is not created yet, copy it from `.env.example`.

```bash
copy .env.example .env
```

### 5. Generate app key

```bash
php artisan key:generate
```

### 6. Set the database

This project uses SQLite by default.

Make sure this file exists:

```bash
database/database.sqlite
```

If it does not exist, create it manually.

### 7. Run migrations

```bash
php artisan migrate
```

### 8. Build frontend assets

```bash
npm run build
```

### 9. Run the project

Use these two commands in separate terminals:

```bash
php artisan serve
```

```bash
npm run dev
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
- The project is written in a beginner style for easy understanding

## Useful Commands

```bash
php artisan migrate
php artisan serve
npm run dev
```

## License

This project is open source and can be used for learning or personal work.
