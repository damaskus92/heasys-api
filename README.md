# Sistem Kesehatan (HeaSys)

Proyek ini dibangun dengan Laravel 11, yang menyediakan API untuk mengelola pasien, janji temu, diagnosis, layanan, dan progress pemeriksaan.

Lihat [Dokumentasi](http://127.0.0.1:8000/api/documentation) untuk daftar endpoint API.

> Note: Jalankan server terlebih dahulu sebelum mengakses link dokumentasi

## Requirements

- PHP (>= 8.1)
- Composer
- Laravel 11
- MySQL

## Daftar Isi

- [Instalasi](#instalasi)
- [Konfigurasi](#konfigurasi)
- [Menjalankan Aplikasi](#menjalankan-aplikasi)

## Instalasi

1. Ekstrak file ZIP
2. Masuk ke direktori proyek

    ```bash
    cd nama_direktori
    ```

3. Install dependensi Composer dengan menjalankan perintah berikut

    ```bash
    composer install
    ```

## Konfigurasi

1. Salin file `.env.example` dan ganti namanya menjadi `.env`

    ```bash
    cp .env.example .env
    ```

2. Generate aplikasi key dengan perintah:

    ```bash
    php artisan key:generate
    ```

3. Buka file `.env` dan atur koneksi database

    ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=heasys
    DB_USERNAME=root
    DB_PASSWORD=
    ```

4. Jalankan migrasi dan juga seeder untuk menghasilkan data default

    ```bash
    php artisan migrate
    php artisan db:seed
    ```

## Menjalankan Aplikasi

1. Setelah semua konfigurasi selesai, Anda dapat menjalankan server pengembangan Laravel dengan perintah:

    ```bash
    php artisan serve
    ```

    Aplikasi akan berjalan di `http://127.0.0.1:8000` atau `http://localhost:8000`.

2. Jalankan Queue Worker untuk memproses job di background

    ```bash
    php artisan queue:work
    ```

## Pengujian

```bash
php artisan test
```
