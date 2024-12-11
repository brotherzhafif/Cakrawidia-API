# Project Overview

## **Persyaratan Sistem**

Sebelum menjalankan aplikasi, pastikan Anda telah menginstal beberapa perangkat lunak berikut di sistem Anda:

- **Composer** (versi terbaru)
- **PHP 8.2.12 atau lebih baru**
- **Apache** (versi terbaru)

---

## **Cara Menjalankan Aplikasi**

Berikut adalah langkah-langkah untuk menjalankan aplikasi **Cakrawidia API** di sistem lokal Anda:

1. **Clone Repository**

   Pertama, clone repository aplikasi ke direktori lokal Anda.

   ```bash
   git clone https://github.com/brotherzhafif/Cakrawidia_API.git
   cd Cakrawidia_API
   ```

2. **Install Dependensi Backend**

   Instal dependensi backend menggunakan **Composer**:

   ```bash
   composer install
   ```

3. **Konfigurasi Environment**

   Salin file `.env_example` menjadi `.env` dan sesuaikan dengan pengaturan yang diperlukan (seperti database, JWT secret, dll).

   ```bash
   cp .env_example .env
   ```

4. **Generate Key**

   Jalankan perintah untuk menghasilkan `APP_KEY` dan migrasi database Anda:

   ```bash
   php artisan key:generate
   ```

5. **Generate JWT Secret**

   Karena aplikasi ini menggunakan **JWT (JSON Web Token)** untuk autentikasi, Anda perlu menghasilkan JWT secret:

   ```bash
   php artisan jwt:secret
   ```
7. **Migrasi Database**

   Migrasi Setting yang telah dibuat:

   ```bash
   php artisan migrate
   ```

7. **Jalankan Aplikasi**

   Jalankan aplikasi backend menggunakan perintah berikut:

   ```bash
   php artisan serve
   ```

   Aplikasi Anda sekarang dapat diakses melalui browser pada alamat `http://localhost:8000`.

---

## **Dokumentasi Api**


Lebih Lengkap bisa diakses di sini
https://github.com/brotherzhafif/Cakrawidia_API/wiki/API-Documentation