# Sistem Posyandu Flask

Sistem Pencatatan Data Kesehatan Posyandu menggunakan Flask, HTML, CSS, dan JavaScript.

## Fitur

- **Autentikasi**: Login dan logout dengan session management
- **Dashboard**: Statistik dan data terbaru
- **Input Data**: Form lengkap untuk data kesehatan
- **Riwayat Data**: Pencarian, filter, dan pagination
- **Edit Data**: Update informasi kesehatan
- **Hapus Data**: Menghapus data dengan konfirmasi
- **Kalkulasi IMT**: Otomatis menghitung IMT dari BB dan TB
- **Responsive Design**: Bootstrap 5 untuk tampilan mobile-friendly

## Instalasi

1. **Clone atau download project**

2. **Install dependencies**:
   \`\`\`bash
   pip install -r requirements.txt
   \`\`\`

3. **Jalankan aplikasi**:
   \`\`\`bash
   python app.py
   \`\`\`

4. **Akses aplikasi**:
   - Buka browser dan kunjungi: `http://localhost:5000`
   - Login dengan akun default:
     - Username: `admin`
     - Password: `admin123`

## Struktur Project

\`\`\`
flask-posyandu-system/
├── app.py                 # Main Flask application
├── requirements.txt       # Python dependencies
├── README.md             # Documentation
├── posyandu.db           # SQLite database (auto-created)
└── templates/
    ├── base.html         # Base template
    ├── dashboard.html    # Dashboard page
    ├── form.html         # Input form
    ├── riwayat.html      # Data history
    ├── edit.html         # Edit form
    ├── result.html       # Success page
    └── auth/
        ├── login.html    # Login page
        └── register.html # Registration page
\`\`\`

## Teknologi yang Digunakan

- **Backend**: Python Flask
- **Database**: SQLite dengan SQLAlchemy ORM
- **Frontend**: HTML5, CSS3, JavaScript
- **UI Framework**: Bootstrap 5
- **Icons**: Bootstrap Icons
- **Authentication**: Flask Sessions dengan password hashing

## Fitur Keamanan

- Password hashing menggunakan Werkzeug
- Session-based authentication
- CSRF protection
- Input validation dan sanitization
- SQL injection protection melalui SQLAlchemy ORM

## Database Schema

### Users Table
- id (Primary Key)
- username (Unique)
- email (Unique)
- password_hash
- full_name
- role
- created_at

### PosyanduData Table
- id (Primary Key)
- dusun, nama, kategori, jenis_kelamin
- tanggal_lahir, umur, alamat
- nomor_ktp, nomor_bpjs
- berat_badan, tinggi_badan, imt
- lingkar_perut, tekanan_darah
- mental_dan_emosional, keterangan
- created_at, updated_at
- created_by (Foreign Key to Users)

## Penggunaan

1. **Login**: Masuk dengan akun yang sudah terdaftar
2. **Dashboard**: Lihat statistik dan data terbaru
3. **Input Data**: Tambah data kesehatan baru
4. **Riwayat**: Cari dan filter data yang sudah ada
5. **Edit**: Perbarui informasi kesehatan
6. **Logout**: Keluar dari sistem

## Pengembangan

Untuk pengembangan lebih lanjut:

1. **Database Production**: Ganti SQLite dengan PostgreSQL/MySQL
2. **File Upload**: Tambah fitur upload foto/dokumen
3. **Export Data**: Tambah export ke Excel/PDF
4. **Email Notification**: Kirim notifikasi via email
5. **API**: Buat REST API untuk mobile app
6. **Backup**: Implementasi backup otomatis database

## Kontribusi

Silakan buat pull request atau laporkan bug melalui issues.

## Lisensi

MIT License
