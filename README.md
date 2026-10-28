Inventory Management System
1. Deskripsi Project
Inventory Management System adalah aplikasi web berbasis Laravel dan MySQL untuk mengelola kategori, produk, supplier, pembelian, stok masuk, stok keluar, penjualan, dan laporan persediaan. Aplikasi juga memiliki fitur tambahan Inventory Store untuk Pembeli (Buyer), berupa katalog produk, pemesanan, dan riwayat pesanan.

Project ini dibuat untuk tugas UTS Web Programming 2 dengan menerapkan Laravel MVC, autentikasi, role-based access control, database relasional, validasi server-side, dan pengelolaan transaksi.
2. Role dan Fitur
Admin
- Login dan logout.
- Melihat dashboard ringkasan persediaan dan transaksi.
- Mengelola kategori, produk, supplier, dan pengguna sesuai fitur aplikasi.
- Mengakses pembelian dan mengonfirmasi atau membatalkannya sesuai aturan sistem.
- Melihat transaksi penjualan dan melakukan pembatalan sesuai izin.
- Mengakses stok masuk, stok keluar, laporan persediaan, dan laporan transaksi.
- Mengelola pesanan pembeli sesuai fitur yang tersedia.
Staff
- Login dan logout.
- Melihat dashboard sesuai hak akses.
- Melihat data produk.
- Mencatat stok masuk dan stok keluar.
- Mengakses pembelian, penjualan, pesanan pembeli, dan laporan sesuai izin yang diterapkan pada route/middleware.
- Tidak memiliki seluruh izin Admin untuk mengelola master data dan pengguna.
Pembeli (Buyer)
- Login dan logout serta memiliki dashboard pembeli.
- Melihat katalog dan detail produk.
- Membuat pesanan dengan mengisi nomor telepon, alamat pengiriman, catatan, dan metode pembayaran yang tersedia.
- Melihat daftar dan detail pesanan miliknya sendiri.
- Membatalkan pesanan yang masih menunggu konfirmasi, sesuai aturan aplikasi.
Metode pembayaran yang tersedia merupakan pilihan pencatatan pesanan; README ini tidak menyatakan bahwa payment gateway telah diintegrasikan.
3. Teknologi yang Digunakan
- Laravel 13 (versi pengembangan: 13.37.0)
- PHP (versi pengembangan: 8.5.10)
- MySQL/MariaDB
- Blade Template Engine, HTML, CSS, dan JavaScript
- Eloquent ORM
- Composer
- XAMPP untuk lingkungan pengembangan lokal
- Node.js/npm jika asset frontend menggunakan Vite
4. Persyaratan Instalasi
Pastikan perangkat memiliki:
1. XAMPP atau server lokal sejenis.
2. Versi PHP dan ekstensi yang kompatibel dengan project, termasuk pdo_mysql.
3. Composer.
4. MySQL atau MariaDB.
5. Node.js dan npm apabila project menggunakan Vite untuk asset frontend.
5. Cara Menginstal dan Menjalankan Aplikasi
Langkah 1 — Jalankan layanan XAMPP
Buka XAMPP Control Panel, lalu jalankan Apache dan MySQL.
Langkah 2 — Buka direktori project
Jalankan PowerShell atau terminal VS Code:
cd C:\xampp\htdocs\inventory-laravel
Langkah 3 — Instal dependency Laravel
composer install
Langkah 4 — Siapkan file environment
Laravel membaca konfigurasi lokal dari file .env. Jika .env belum ada, buat dari file contoh:
Copy-Item .env.example .env
Jika .env sudah tersedia dan konfigurasi benar, jangan menimpanya.
Langkah 5 — Buat database
Buka http://localhost/phpmyadmin, lalu buat database dengan nama inventory_db untuk instalasi baru. Jika database project yang sudah ada hendak digunakan, pastikan database tersebut dipertahankan dan tidak dihapus.
Langkah 6 — Sesuaikan koneksi database
Periksa konfigurasi di .env. Contoh untuk XAMPP dengan MySQL tanpa password:
APP_NAME="Inventory Management System"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8001

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventory_db
DB_USERNAME=root
DB_PASSWORD=
Sesuaikan username dan password dengan konfigurasi MySQL lokal. Jangan membagikan file .env, karena berisi konfigurasi lokal.
Langkah 7 — Siapkan application key
php artisan key:generate
Jalankan jika application key belum tersedia atau instalasi baru sedang disiapkan.
Langkah 8 — Periksa dan jalankan database migrations
Migration menyimpan definisi tabel, kolom, index, dan foreign key. File migration project berada di database/migrations/ dan perlu disertakan saat project dikumpulkan.

Periksa status migration:
php artisan migrate:status
Jalankan migration yang belum diterapkan:
php artisan migrate
Untuk instalasi baru dengan database kosong, migration dapat dijalankan sebelum menyiapkan data demo. Jangan menjalankan php artisan migrate:fresh pada database yang berisi data penting karena perintah itu menghapus seluruh tabel beserta datanya.
Langkah 9 — Jalankan seeder akun demo
File seeder akun demo yang digunakan adalah database/seeders/DemoAccountsSeeder.php. Untuk membuat atau memperbarui akun demo, jalankan:
php artisan db:seed --class=DemoAccountsSeeder
Seeder ini menyiapkan tiga akun demo di bagian Akun Demo. Jika email akun sudah ada, nama, role, dan password akun tersebut disetel sesuai isi seeder; data produk dan transaksi tidak dihapus.

Seeder data awal lain, misalnya kategori, produk, atau supplier, dijalankan melalui DatabaseSeeder hanya jika telah dikonfigurasi pada project. Jangan mengganti DatabaseSeeder.php yang sudah ada tanpa memeriksa isinya.
Langkah 10 — Siapkan penyimpanan gambar
Jika link storage belum tersedia, jalankan:
php artisan storage:link
Perintah ini memungkinkan gambar produk yang disimpan melalui storage ditampilkan oleh aplikasi.
Langkah 11 — Siapkan asset frontend jika diperlukan
Jika project menggunakan Vite, jalankan:
npm install
npm run build
Lewati langkah ini jika project tidak menggunakan Vite atau asset sudah disiapkan.
Langkah 12 — Bersihkan cache aplikasi
php artisan optimize:clear
Langkah 13 — Jalankan server Laravel
php artisan serve --host=127.0.0.1 --port=8001
Biarkan terminal tetap terbuka selama aplikasi digunakan. Buka alamat berikut di browser:

http://127.0.0.1:8001

Halaman login dapat dibuka melalui http://127.0.0.1:8001/login.
6. Akun Demo
Akun berikut disiapkan menggunakan DemoAccountsSeeder yang telah dijalankan pada project:
Role	Email	Password
Admin	admin@inventory.test	Admin123!
Staff	staff@inventory.test	Staff123!
Pembeli (Buyer)	pembeli1@example.com	Buyer123!


Akun tersebut diperuntukkan untuk demonstrasi lokal oleh dosen. Pastikan login untuk setiap role berhasil sebelum presentasi. Gunakan akun demo saja, bukan akun pribadi. Jangan menggunakan password demo ini pada aplikasi produksi.
7. Database Migrations dan Seeders
Migrations
- Lokasi: database/migrations/.
- Migration membuat dan memperbarui struktur tabel database secara terkontrol.
- Sertakan seluruh migration yang digunakan project saat menyerahkan source code.
- Untuk memeriksa migration yang sudah dijalankan, gunakan php artisan migrate:status.
- Untuk menjalankan migration yang belum diterapkan, gunakan php artisan migrate.
Seeders
- Lokasi: database/seeders/.
- Seeder digunakan untuk menyiapkan data awal atau akun demo.
- Seeder akun demo: DemoAccountsSeeder.php.
- Perintah menjalankan seeder akun demo: php artisan db:seed --class=DemoAccountsSeeder.
- DatabaseSeeder.php dapat digunakan untuk memanggil seeder lain yang benar-benar sudah tersedia dan dikonfigurasi dalam project.
Catatan: README ini menjelaskan cara menjalankan migration dan seeder yang ada. File migration dan seeder asli dari project tetap harus ikut diserahkan; README tidak menggantikan file-file tersebut.
8. ERD dan Penjelasan Relasi
Simpan dokumentasi ERD di folder docs/, misalnya:
docs/
├── ERD_inventory.png
├── ERD_inventory.drawio
└── ERD_RELATIONS.txt
- ERD_inventory.png merupakan gambar diagram untuk laporan.
- ERD_inventory.drawio merupakan diagram yang bisa dibuka dan diedit di https://app.diagrams.net/.
- ERD_RELATIONS.txt berisi keterangan tentang hubungan tabel.
Tabel inti
Tabel	Fungsi
users	Akun pengguna dan role.
categories	Kategori produk.
products	SKU, nama, kategori, harga, stok, dan stok minimum.
suppliers	Data pemasok.
purchases	Header transaksi pembelian.
purchase_items	Rincian produk pada pembelian.
sales	Header transaksi penjualan.
sale_items	Rincian produk pada penjualan.
stock_ins	Riwayat stok masuk.
stock_outs	Riwayat stok keluar.
orders dan tabel detailnya	Pesanan dari Buyer; nama tabel/kolom harus cocok dengan migration aktual.


Penjelasan relasi utama
- categories ke products — 1:N: satu kategori dapat mempunyai banyak produk; FK kategori berada pada tabel produk.
- suppliers ke purchases — 1:N: satu supplier dapat terkait dengan banyak pembelian.
- users ke purchases — 1:N: satu pengguna dapat mencatat beberapa pembelian.
- purchases ke purchase_items — 1:N: satu transaksi pembelian dapat mempunyai banyak baris rincian.
- products ke purchase_items — 1:N: satu produk dapat muncul di banyak rincian pembelian.
- users ke sales — 1:N: satu pengguna dapat mencatat beberapa penjualan.
- sales ke sale_items — 1:N: satu transaksi penjualan dapat mempunyai banyak baris rincian.
- products ke sale_items — 1:N: satu produk dapat muncul di banyak rincian penjualan.
- products ke stock_ins dan stock_outs — 1:N: satu produk dapat memiliki banyak riwayat transaksi stok.
- users ke stock_ins dan stock_outs — 1:N: satu pengguna dapat mencatat banyak transaksi stok.
- Buyer ke pesanan — satu akun Buyer dapat memiliki banyak pesanan sesuai FK yang diterapkan pada model/migration.
PK (Primary Key) adalah identitas unik baris tabel. FK (Foreign Key) menghubungkan baris suatu tabel ke tabel lain. 1:N (one-to-many) berarti satu data induk dapat terkait dengan banyak data pada tabel anak.

Nama tabel, kolom, dan foreign key untuk pesanan Buyer harus dicocokkan dengan file migration dan model yang digunakan pada project sebelum ERD diserahkan sebagai skema final.
9. Aturan Bisnis Utama
1. SKU produk harus unik.
2. Harga dan kuantitas divalidasi di sisi server.
3. Kuantitas transaksi barang harus lebih besar dari nol.
4. Stok keluar tidak boleh melebihi jumlah stok yang tersedia.
5. Stok diperbarui sesuai alur ketika transaksi berhasil diproses.
6. Total transaksi dihitung oleh server berdasarkan produk dan kuantitas.
7. Proses penyimpanan transaksi yang mengubah stok menggunakan database transaction agar kegagalan dapat di-rollback.
8. Pembatalan transaksi mengikuti aturan status dan penyesuaian stok pada aplikasi.
9. Akses halaman dibatasi berdasarkan role Admin, Staff, dan Buyer.
10. Pengujian Aplikasi
Pengujian yang dilakukan atau perlu diperiksa sebelum demo:
- Login dan logout setiap role.
- Akses menu Admin, Staff, dan Buyer.
- Pengelolaan kategori, produk, dan supplier sesuai hak akses.
- Pencarian, filter, pengurutan, dan pagination.
- Pembelian dan perubahan stok saat konfirmasi.
- Stok masuk dan stok keluar.
- Penolakan transaksi jika stok tidak mencukupi.
- Laporan persediaan dan laporan riwayat transaksi.
- Dashboard berdasarkan data aplikasi.
- Katalog, pemesanan, pembatalan yang diizinkan, dan riwayat pesanan Buyer.
Contoh pengujian yang sudah dicoba: ketika stok produk 13 unit dan jumlah stok keluar dimasukkan 14 unit, sistem menolak transaksi dengan pesan stok tidak mencukupi dan stok tetap 13 unit.
11. Struktur Project (ringkas)
inventory-laravel/
├── app/
├── database/
│   ├── migrations/
│   └── seeders/
├── docs/
├── public/
├── resources/
│   └── views/
├── routes/
├── storage/
├── tests/
├── .env.example
├── artisan
├── composer.json
└── README.md
Struktur aktual dapat memiliki file atau folder tambahan. Pertahankan seluruh file aplikasi yang sudah ada.
12. Keamanan
- Jangan membagikan file .env atau kredensial database.
- Gunakan akun demo untuk demonstrasi.
- Jangan memasukkan password pribadi ke repository.
- Jangan menjalankan perintah penghapusan database pada database berisi data penting.
- Untuk produksi, gunakan konfigurasi aman dan nonaktifkan mode debug.
13. Penutup
Inventory Management System membantu pengelolaan persediaan, data master, pembelian, penjualan, transaksi stok, laporan, serta fitur katalog dan pesanan Buyer. README ini menjadi panduan instalasi, pengaturan database, migrations dan seeders, akun demo, serta cara menjalankan aplikasi untuk tugas UTS Web Programming 2.