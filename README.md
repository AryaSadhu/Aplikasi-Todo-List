# Aplikasi Todo List

## Deskripsi Singkat
Aplikasi web untuk manajemen tugas yang memungkinkan pengguna untuk menambah, mengedit, dan menghapus tugas-tugas pribadi mereka. Aplikasi ini dibangun dengan PHP native tanpa framework, menggunakan database MySQL/MariaDB, dan dilengkapi dengan sistem autentikasi yang aman.

## Daftar Anggota
| Nama | NIM | Username GitHub | Peran/Tugas |
|------|-----|-----------------|-------------|
| [I Made Arya Sadhu Harta Wijaya] | [230030398] | [https://github.com/AryaSadhu/] | Backend Developer & Database Design |
| [ALEXANDER JEREMIAH NGANTUNG] | [240030399] | [https://github.com/Alexndr23] | Frontend Developer & UI/UX Design |
| [GUSTI NGURAH ANANDA MAHESYA SUPUTRA] | [240030046] | [https://github.com/Gungandaa06] | Security & Testing |
| [I KADEK ARIANTA] | [240030104] | [https://github.com/kadek46ari-droid/I-KADEK-ARIANTA] | Documentation & Integration |

## Lingkungan Pengembangan
- **Bahasa Pemrograman:** PHP 7.4 atau lebih tinggi
- **Database:** MySQL 5.7+ / MariaDB 10.3+
- **Web Server:** Apache 2.4+ dengan mod_rewrite
- **Frontend Framework:** Bootstrap 5.3 (CSS), Vanilla JavaScript
- **Text Editor/IDE:** Visual Studio Code / PHPStorm
- **Version Control:** Git & GitHub
- **Local Development:** XAMPP / WAMP / MAMP

## Hasil Pengembangan

### 1. Modul Autentikasi
- **Registrasi Pengguna:** Form pendaftaran dengan validasi email dan password
- **Login Pengguna:** Sistem login dengan session management
- **Logout:** Penghapusan session dan redirect ke halaman login
- **Keamanan:** Password hashing menggunakan `password_hash()` dengan algoritma bcrypt dan salt otomatis

### 2. Modul Manajemen Tugas
- **Tambah Tugas:** Form untuk membuat tugas baru dengan judul, deskripsi, dan tanggal jatuh tempo
- **Lihat Tugas:** Tampilan daftar tugas dalam bentuk card/list dengan informasi lengkap
- **Edit Tugas:** Update informasi tugas yang sudah ada
- **Hapus Tugas:** Menghapus tugas dengan konfirmasi
- **Status Tugas:** Toggle status selesai/belum selesai

### 3. Modul Session Management
- Session timeout setelah 30 menit inaktivitas
- Validasi session pada setiap halaman yang memerlukan autentikasi
- Regenerasi session ID setelah login untuk mencegah session fixation

### 4. Fitur Opsional
- **Filter Tugas:** Filter berdasarkan status (semua, selesai, belum selesai)
- **Pencarian:** Pencarian real-time berdasarkan judul atau deskripsi tugas
- **Sorting:** Urutkan tugas berdasarkan tanggal jatuh tempo

## Struktur Folder

```
APLIKASI TODO LIST/
│
├── config/
│   └── database.php          # Konfigurasi koneksi database
│
├── includes/
│   ├── auth.php              # Fungsi autentikasi dan validasi
│   ├── functions.php         # Fungsi-fungsi helper umum
│   └── session.php           # Manajemen session
│
├── assets/
│   ├── css/
│   │   └── style.css         # Styling kustom aplikasi
│   └── js/
│       └── script.js         # JavaScript untuk interaktivitas
│
├── pages/
│   ├── register.php          # Halaman registrasi
│   ├── login.php             # Halaman login
│   ├── dashboard.php         # Halaman utama (daftar tugas)
│   ├── add_task.php          # Halaman tambah tugas
│   ├── edit_task.php         # Halaman edit tugas
│   ├── delete_task.php       # Proses hapus tugas
│   └── logout.php            # Proses logout
│
├── api/
│   ├── register_process.php  # Proses registrasi
│   ├── login_process.php     # Proses login
│   ├── task_process.php      # Proses CRUD tugas
│   └── search_task.php       # API pencarian tugas
│
├── sql/
│   └── database.sql          # Script SQL untuk membuat database dan tabel
│
├── index.php                 # Landing page / redirect
└── README.md                 # Dokumentasi project
```

## Cara Instalasi dan Menjalankan Aplikasi

### Prasyarat
- XAMPP terinstall
- PHP versi 7.4 atau lebih tinggi
- MySQL
- Web browser modern (Chrome, Firefox, Edge)

### Langkah Instalasi

1. **Clone atau Download Repository**
   ```bash
   git clone https://github.com/AryaSadhu/Aplikasi-Todo-List.git
   ```

2. **Pindahkan ke Direktori Web Server**
   - Untuk XAMPP: pindahkan folder ke `C:\xampp\htdocs\`
   
   

3. **Buat Database**
   - Buka phpMyAdmin di browser: `http://localhost/phpmyadmin`
   - Buat database baru dengan nama `todolist_db`
   - Import file SQL:
     - Klik tab "Import"
     - Pilih file `sql/database.sql`
     - Klik "Go"

4. **Konfigurasi Database**
   - Buka file `config/database.php`
   - Sesuaikan kredensial database jika diperlukan:
     ```php
     $db_host = "localhost";
     $db_user = "root";
     $db_pass = "";
     $db_name = "todolist_db";
     ```

5. **Jalankan Aplikasi**
   - Start Apache dan MySQL di XAMPP Control Panel
   - Buka browser dan akses: `http://localhost/todo-list-app`
   - Atau langsung ke: `http://localhost/todo-list-app/pages/register.php`

### Akun Testing (Opsional)
Setelah registrasi pertama kali, Anda dapat menggunakan akun yang dibuat untuk testing. Atau gunakan akun demo jika sudah dibuatkan:
- **Email:** demo@example.com
- **Password:** Demo123!

### Troubleshooting

**Error: Connection refused**
- Pastikan MySQL service sudah running
- Cek kredensial database di `config/database.php`

**Error: Session error**
- Pastikan folder `session.save_path` dapat ditulis
- Cek permission folder di server

**Halaman blank/error 500**
- Aktifkan error reporting di PHP
- Cek error log di `php_error.log`
- Pastikan semua file PHP memiliki syntax yang benar

## Fitur Keamanan
- Password hashing dengan bcrypt
- Prepared statements untuk mencegah SQL Injection
- Input validation dan sanitization
- Session regeneration
- CSRF protection (dapat ditambahkan)
- XSS protection dengan htmlspecialchars()

## Pengembangan Lebih Lanjut
- [ ] Implementasi AJAX untuk operasi CRUD tanpa reload
- [ ] Notifikasi untuk tugas yang mendekati deadline
- [ ] Kategori/tag untuk tugas
- [ ] Export tugas ke PDF/CSV
- [ ] API RESTful untuk integrasi mobile app
- [ ] Dark mode theme

## Lisensi
Project ini dibuat untuk keperluan akademik mata kuliah Back-End Web Development.

## Kontak
Untuk pertanyaan atau saran, silakan hubungi anggota tim melalui GitHub.