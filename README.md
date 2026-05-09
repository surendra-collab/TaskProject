# Project Setup and Run

## Steps

1. Download project.
2. Open terminal in the project folder.
3. Change file name from `.env.example` to `.env`.
4. Create MySQL database with name `taskproject`.
5. Run command:

```bash
composer update
```

6. After that, run:

```bash
php artisan migrate --seed
```
php artisan key:genrate

7. Run:

```bash
php artisan key:generate
```

8. Run:

```bash
php artisan serve
```

9. default credential for SuperAdmin
    user :- superadmin@yopmail.com
    pass :- "password"

The app will start on a local development URL (usually `http://127.0.0.1:8000`).

## Note

In this project, Cursor AI was used for design improvement and to create the basic project structure.
