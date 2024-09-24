## Requirements

- PHP >= 8.1.0
- Laravel 11
- PostgreSQL

## Installation

- Clone the repo and `cd` into it
- Run `composer install`
- Rename or copy `.env.example` file to `.env`
- Run `php artisan key:generate`
- Set your database credentials in your `.env` file
- Run migration `php artisan migrate`

## Penjelasan Branch
- Main Branch `main`, merupakan branch utama yang berisi kode atau program yang sudah melewati tahap testing, dan setiap merge ke main harus melalui pull request yang sudah direview dan dites.
- Development Branch `develop`, merupakan branch pengembangan utama yang menggabungkan semua fitur sebelum dirilis ke main.
- Feature Branch `feature/nama-fitur`, merupakan branch untuk mengembangkan fitur spesifik. Fitur ini dibuat dari `develop` dan digabungkan ke `develop`.

## Ketentuan Git Branch
- Dari branch `main`, masuk ke branch `develop`
- Run `git checkout develop`
- Run `git pull origin develop`
- Buat branch untuk fitur dengan perintah `git checkout -b feature/nama-fitur`
- Mulai pengembangan untuk fitur pada branch fitur yang sesuai
- Setelah fitur selesai, merge ke branch `develop`, namun sebelum merge pastikan develop up-to-date
- Run `git checkout develop`
- Run `git pull origin develop`
- Run `git checkout feature/nama-fitur`
- Run `git merge develop`
- Lalu push dan buat pull request



