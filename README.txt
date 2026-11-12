VOTINGKS - PEMILIHAN KAKANG SENDUK PONOROGO
============================================

KEBUTUHAN:
- XAMPP (Apache, MySQL, PHP 8.0+ direkomendasikan)
- Browser
- Koneksi internet untuk Bootstrap CDN dan Google Fonts (opsional untuk tampilan)

CARA INSTALASI:
1. Extract folder votingks ke C:\xampp\htdocs\
2. Buka XAMPP Control Panel, Start Apache dan MySQL.
3. Buka http://localhost/phpmyadmin
4. Pilih menu Import, pilih database/db_votingks.sql, lalu klik Import.
   File SQL membuat database db_votingks dan tabel-tabel yang diperlukan.
5. Buka http://localhost/votingks/

LOGIN ADMIN:
Email: admin@votingks.local
Password: AdminKS123!

FITUR:
- Landing page publik
- Daftar dan detail kontestan
- Role admin dan pemilih
- Admin tambah/edit/hapus kontestan dan upload foto
- Pemilih satu suara per kategori (1 Kakang dan 1 Senduk)
- Pengaturan periode per kategori
- Papan peringkat Kakang dan Senduk
- Rekap suara dan data pemilih

STRUKTUR DATABASE:
1. users: akun admin dan pemilih
2. kontestan: profil finalis, kategori, foto, visi, misi, asal instansi
3. voting: suara pemilih, dengan UNIQUE(user_id, kategori)
4. periode_voting: jadwal dan status voting tiap kategori

CATATAN:
- Database tidak mengisi data finalis contoh secara otomatis. Login admin lalu tambah 2 Kakang dan 2 Senduk beserta foto, visi, misi, dan asal instansi.
- Atur jadwal periode voting di menu Periode Voting. Status awal adalah TUTUP.
- Pastikan folder uploads dapat ditulisi oleh Apache.
- Untuk pemilihan resmi, lakukan pengujian keamanan, backup database, verifikasi pemilih, dan uji beban terlebih dahulu.
- Hasil voting dihitung dari data tabel voting saat halaman hasil dimuat (refresh untuk melihat perubahan terbaru).
- Penghapusan kontestan yang sudah memiliki suara dicegah oleh foreign key; ubah status menjadi nonaktif.
