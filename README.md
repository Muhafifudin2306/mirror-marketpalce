# sinau_print_website

Sebelum memulai, pastikan telah menginstal software berikut:

* **PHP** >= 8.1.10
* **Composer** - [Unduh dan Instal](https://getcomposer.org/download/)
* **Node.js** dan **npm** - [Unduh dan Instal](https://nodejs.org/)
* **Git** - [Unduh dan Instal](https://git-scm.com/downloads)
* **Database Server** 
* **PHP Server** 

Ikuti langkah-langkah di bawah ini untuk menyiapkan project:

1.  **Clone Repository:**

    Gunakan perintah berikut untuk melakukan clone ke direktori lokalmu:

    ```bash
    git clone <URL_REPOSITORY>
    ```

2.  **Instal Dependensi Composer:**

    Setelah masuk ke direktori proyek, instal dependensi PHP dan Node JS menggunakan Composer:

    ```bash
    composer install
    npm install
    ```

3.  **Salin File `.env`:**

    Selanjutnya, salin file `.env.example` menjadi `.env` dan lakukan konfigurasi sesuai dengan lingkungan pengembanganmu:

    ```bash
    cp .env.example .env
    ```

    Buka file `.env` dan sesuaikan pengaturan berikut:

    * `APP_NAME`: Nama aplikasi kamu.
    * `APP_ENV`: Atur menjadi `local` untuk lingkungan pengembangan.
    * `APP_DEBUG`: Atur menjadi `true` untuk menampilkan error selama pengembangan.
    * `APP_KEY`: Hasilkan key aplikasi menggunakan perintah di langkah selanjutnya.
    * `DB_CONNECTION`: Jenis koneksi database (misalnya `mysql`, `pgsql`).
    * `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`: Detail koneksi database kamu.

4.  **Hasilkan Application Key:**

    Jalankan perintah berikut untuk menghasilkan application key:

    ```bash
    php artisan key:generate
    ```

5.  **Konfigurasi Database:**

    Jalankan migrasi database untuk membuat skema database:

    ```bash
    php artisan migrate
    ```

6.  **Jalankan Server Development:**

    Terakhir, jalankan server development Laravel untuk mengakses aplikasi di browser:

    ```bash
    php artisan serve
    ```

    Secara default, aplikasi akan berjalan di `http://127.0.0.1:8000`.