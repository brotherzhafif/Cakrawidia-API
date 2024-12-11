# Cakrawidia  
**Platform Diskusi Pelajaran Berbasis Website**  

## Deskripsi  
Cakrawidia adalah platform berbasis website yang menyediakan ruang diskusi untuk tanya jawab terkait pelajaran. Platform ini juga menyediakan fitur berbagi materi belajar gratis, sehingga mempermudah siswa dan pelajar dalam memahami materi.  

## Fitur Utama  
1. **Register dan Login**  
   - Pengguna dapat mendaftar dan login untuk akses penuh.  
   - Pengguna anonim hanya dapat melihat konten tanpa interaksi.  

2. **Diskusi (Tanya Jawab)**  
   - Fasilitas untuk bertanya dan menjawab pertanyaan terkait pelajaran.  

3. **Sistem Poin**  
   - Pengguna mendapatkan poin berdasarkan jumlah like pada jawaban mereka.  

4. **Leaderboard**  
   - Daftar peringkat pengguna dengan jumlah like terbanyak pada pertanyaan dan jawaban.  

5. **Kategorisasi Topik**  
   - Pertanyaan dikelompokkan berdasarkan topik untuk mempermudah pencarian.  

## Fitur Tambahan  
1. **Komentar**  
   - Pengguna dapat memberikan komentar pada setiap pembahasan.  

2. **Berbagi Materi**  
   - Fitur untuk membagikan modul atau materi belajar.  

3. **Sistem Like pada Materi**  
   - Materi dengan jumlah like terbanyak akan tampil di leaderboard.  

4. **Topik Hangat**  
   - Menampilkan topik diskusi dan materi yang paling banyak dikunjungi di beranda.  

## Persyaratan Sistem  
- **C++ Redistributable Latest**  
- **Node.js 22.11.0**  
- **npm 10.9.0**  
- **Composer Latest**  
- **Apache Latest**
- **PHP 8.2.12**

## Cara Menjalankan Aplikasi  

1. Pastikan semua persyaratan sistem telah terinstal.  
2. Clone repository ini ke direktori lokal Anda.  
3. Jalankan perintah berikut untuk memulai:  
   - **Clone**
   - ```bash
     git clone https://github.com/brotherzhafif/Cakrawidia.git
     cd Cakrawidia
     ```  
   - **Inisiasi**  
     ```bash
     npm i
     composer install
     ```
    - **Inisiasi Env**
       > buat file .env isi filenya sesuai .env_example lalu jalankan dibawah ini
         ```bash
         php artisan key:generate
         php artisan migrate
         ```   
   - **Frontend**  
     ```bash
     npm run dev
     ```  
   - **Backend**  
     ```bash
     php artisan serve
     ```  

4. Akses aplikasi melalui browser pada alamat `http://localhost:8000`.  

---

**Dibuat untuk mendukung kolaborasi dan pembelajaran digital.**  
