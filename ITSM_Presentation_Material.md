# Materi Presentasi Pengembangan ITSM-Open Ticket (Campus IT Service Center)

Dokumen ini berisi rangkuman fitur-fitur utama dan pembaruan UI/UX yang telah dikembangkan pada aplikasi ITSM-Open Ticket untuk meningkatkan efisiensi pelayanan IT kampus. Dokumen ini dirancang sebagai materi sumber untuk NotebookLLM.

---

## 1. Perubahan Status Tiket & Penambahan Fitur Eviden (Bukti Penyelesaian)

**Masalah Sebelumnya:**
Staf IT hanya bisa mengubah status tiket melalui *dropdown* biasa tanpa memberikan penjelasan teknis kepada pelapor mengenai apa yang sebenarnya diperbaiki.

**Solusi & Implementasi:**
- **Sistem Modal Interaktif:** Proses pengubahan status tiket kini dialihkan menggunakan *Pop-up Modal* yang lebih profesional.
- **Wajib Eviden:** Jika staf mengubah status tiket menjadi **Resolved (Selesai)**, sistem akan memaksa staf untuk mengisi **Catatan Penyelesaian** dan mengunggah **Eviden/Bukti Penyelesaian** (berupa foto dokumentasi perbaikan atau dokumen PDF).
- **Keuntungan:** Meningkatkan transparansi layanan IT kampus. Pelapor dapat melihat dengan jelas bukti foto bahwa kendalanya telah ditangani dengan baik.

---

## 2. Penyempurnaan Dashboard Staf & Eksekutif (Manajemen Antrean)

**Masalah Sebelumnya:**
Seiring bertambahnya jumlah laporan, tabel *dashboard* menjadi penuh sesak dengan tiket yang sudah lama selesai, dan tidak ada cara mudah untuk memfilter laporan berdasarkan rentang waktu tertentu.

**Solusi & Implementasi:**
- **Filter Tanggal Kustom:** Menambahkan filter rentang tanggal (*Start Date* hingga *End Date*) yang bereaksi secara *real-time* untuk memudahkan Kepala IT / Eksekutif dalam menarik laporan bulanan.
- **Auto-Hide Resolved Tickets:** Sistem kini secara otomatis menyembunyikan tiket dengan status *Resolved* yang sudah melewati hari ini (H+1). Ini memastikan *Dashboard Staf* selalu bersih dan hanya fokus pada antrean masalah yang sedang aktif.
- **Kolom Tanggal Lapor:** Menambahkan kolom spesifik yang menampilkan kapan tiket diajukan secara mendetail (format: Hari Bulan Tahun - Jam).

---

## 3. Fitur Tracking Tiket Publik (Sisi Mahasiswa/Pelapor)

**Masalah Sebelumnya:**
Mahasiswa atau pelapor sering kali tidak mengetahui progres laporan mereka dan terus bertanya kepada staf IT, yang pada akhirnya membuang waktu staf untuk menjawab pertanyaan status.

**Solusi & Implementasi:**
- **Pencarian Berbasis NIM/NIP:** Pelapor tidak perlu menghafal ID Tiket (UUID) yang rumit. Mereka cukup memasukkan NIM/NIP mereka di halaman depan.
- **UI Modal & Timeline Vertical:** Saat NIM dimasukkan, sebuah layar transparan (*Modal*) akan muncul menampilkan daftar riwayat laporan mereka.
- **Garis Waktu (Timeline):** Jika salah satu tiket diklik, pelapor dapat melihat perjalanan laporan mereka dalam bentuk Garis Waktu vertikal: mulai dari **Laporan Diterima** $\rightarrow$ **Sedang Diproses** $\rightarrow$ **Selesai (Resolved)**.
- **Integrasi Eviden:** Pada tahap *Selesai*, pelapor langsung dapat membaca catatan dari Tim IT dan melihat foto bukti perbaikan tanpa harus masuk (*login*) ke dalam sistem.

---

## 4. Redesign Halaman Login (Branding Kampus)

**Masalah Sebelumnya:**
Halaman *login* untuk staf dan eksekutif terlihat sangat generik dan kurang merepresentasikan identitas institusi kampus yang besar dan modern.

**Solusi & Implementasi:**
- **Konsep Split Screen:** Mengubah struktur halaman *login* menjadi konsep "Belah Dua" yang identik dengan standar *software enterprise* kelas dunia.
- **Zona Visual (Kiri):** Menampilkan warna identitas kampus (Biru), logo kampus berukuran besar, latar belakang dengan efek *glassmorphism* melingkar, serta moto pelayanan *"Melayani dengan Cepat dan Tepat"*.
- **Zona Fungsional (Kanan):** Ruang putih bersih, terang, dan tanpa distraksi yang dikhususkan murni untuk *form* pengisian Email dan Password staf. Desain ini sangat responsif (akan menjadi satu kolom saat dibuka di layar *Smartphone*).

---

## 5. Notifikasi Real-Time Tiket Masuk (Sistem Polling & Audio)

**Masalah Sebelumnya:**
Staf IT harus secara manual me-*refresh* (*F5*) halaman *browser* mereka berulang kali hanya untuk mengecek apakah ada laporan baru yang masuk dari mahasiswa. Ini tidak efisien dan menyebabkan respons yang lambat.

**Solusi & Implementasi:**
- **Background Polling (Radar Otomatis):** Dashboard Staf kini dibekali kemampuan untuk secara diam-diam mengecek database (setiap 10 detik) untuk mencari tiket baru, dengan metode pemindaian ID yang sangat ringan agar tidak membebani peladen (*server*).
- **Pop-up Toast Interaktif:** Jika terdeteksi ada laporan masuk, sebuah kotak notifikasi (*Toast*) bergaya transparan elegan akan meluncur turun dari pojok kanan atas layar staf, memberikan informasi judul laporan baru tersebut.
- **Audio Alert:** Bersamaan dengan munculnya kotak visual, sistem akan memutar efek suara alarm (*"Ting!"*) agar staf yang sedang sibuk melihat tab *browser* lain (atau sedang tidak menatap layar) tetap segera mengetahui bahwa ada laporan yang harus segera ditangani. 
- **Auto-Refresh Tabel:** Tabel antrean tiket otomatis menambahkan baris data terbaru secara magis tanpa perlu memuat ulang seluruh halaman.

---

## Ringkasan Eksekutif
Rangkaian pembaruan ini berhasil mengubah aplikasi ITSM-Open Ticket dari sekadar sistem pencatatan masalah dasar menjadi **Platform Layanan IT (*Helpdesk*) Modern yang interaktif, transparan, dan proaktif**. Staf IT dapat bekerja lebih cepat dengan bantuan notifikasi cerdas, dan Mahasiswa mendapatkan pengalaman pengguna (*User Experience*) terbaik dalam melacak kendala mereka secara mandiri.
