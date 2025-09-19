## Kopiew App

### Prerequisites

Before you begin, ensure that you have the following installed:

  - PHP (^8.2)
  - Node.js (\>= 12)
  - Composer

### Allow Your Account

1.  Copy `./database/seeders/data/accounts.json.example` to `./database/seeders/data/accounts.json`
2.  Edit with your data
3.  Seeding the database

-----

### Clone and Project Setup

1.  **Clone the Project:** Open your terminal and navigate to the directory where you want to clone the project. Then, execute this command:

<!-- end list -->

```shell
git clone https://github.com/azmiagr/kopiew-app.git
```

2.  **Navigate to Project Directory:**

<!-- end list -->

```shell
cd kopiew-app
```

3.  **Install Dependencies:**

      * Install PHP dependencies:

    <!-- end list -->

    ```shell
    composer install
    ```

      * Install JavaScript dependencies:

    <!-- end list -->

    ```shell
    npm install
    ```

4.  **Configure Environment:**

      * Create a copy of `.env.example` and rename it to `.env`:

    <!-- end list -->

    ```shell
    cp .env.example .env
    ```

      * Generate a unique application key:

    <!-- end list -->

    ```shell
    php artisan key:generate
    ```

5.  **Run Migrations and Seeders:**

      * Run database migrations to create tables:

    <!-- end list -->

    ```shell
    php artisan migrate
    ```

      * Seed the database with initial data:

    <!-- end list -->

    ```shell
    php artisan migrate:seed
    ```

6.  **Build Frontend Assets:**

      * Build assets for development:

    <!-- end list -->

    ```shell
    npm run dev
    ```

      * Untuk *hot reloading*, gunakan:

    <!-- end list -->

    ```shell
    npm run hot
    ```

-----

### Workflow and Branching

Setelah proyek siap, ikuti alur kerja berikut sebelum memulai pekerjaan:

1.  **Create Your Branch:** Buat *branch* baru untuk fitur atau tugas yang kamu kerjakan. Nama *branch* harus deskriptif.

<!-- end list -->

```shell
git checkout -b fitur/nama-fitur-kamu
```

2.  **Stkamurd Operating Procedure (SOP) for Committing:**

      * Tambahkan perubahan yang ingin kamu simpan:

    <!-- end list -->

    ```shell
    git add .
    ```

      * Lakukan *commit* dengan pesan yang jelas dan deskriptif. Formatnya harus singkat dan to the point.

    <!-- end list -->

    ```shell
    git commit -m "feat: Menambahkan fitur login user"
    ```

      * Gunakan format `type: deskripsi`. Contoh `type`:
          * **`feat`**: Menambahkan fitur baru.
          * **`fix`**: Memperbaiki *bug*.
          * **`docs`**: Perubahan pada dokumentasi.
          * **`style`**: Perubahan format kode (tanpa mengubah logika).
          * **`refactor`**: Perubahan kode yang tidak menambah fitur atau memperbaiki *bug*.

3.  **Push to Remote:** Setelah selesai, *push* *branch* kamu ke *remote repository*.

<!-- end list -->

```shell
git push origin fitur/nama-fitur-kamu
```

4.  **Create Pull Request (PR):** Buat PR dari *branch* kamu ke *branch* **`main`**.

5.  **Important:** **Hanya Azmi** yang berhak me-*merge* PR. Pastikan kamu ga me-*merge* PR kamu sendiri.

-----

### Start the Application

Setelah semua *setup* selesai, kamu bisa menjalankan aplikasi:

```shell
php artisan serve
```

Aplikasi akan berjalan di `http://127.0.0.1:8000`.

Jika ada pertanyaan atau masalah, jangan ragu untuk menghubungi salah satu *maintainer* proyek ini 🙂.

Selamat ngoding\!
