# Critter Shield - Aplikasi Deteksi Penyakit Hama

Critter Shield adalah aplikasi berbasis website yang bertujuan untuk mendeteksi penyakit hama pada tanaman menggunakan metode **Convolutional Neural Network (CNN)**. Aplikasi ini memungkinkan pengguna untuk mengunggah gambar tanaman yang terinfeksi atau menggunakan kamera untuk mendeteksi tiga jenis penyakit hama: **Blight**, **Blast**, dan **Tungro**. Aplikasi ini dibangun menggunakan PHP dan menggunakan MySQL untuk penyimpanan data.

## Fitur Utama

### Fitur Pengguna
- **Deteksi Penyakit Hama**: 
  - Pengguna dapat mengunggah gambar tanaman yang terinfeksi atau menggunakan kamera untuk mendeteksi penyakit hama.
  - Aplikasi mendeteksi tiga jenis penyakit hama: **Blight**, **Blast**, dan **Tungro**.
  - Hasil deteksi yang akurat berdasarkan model CNN yang telah dilatih.
  
- **Penggantian Nama dan Password**:
  - Pengguna dapat mengganti nama dan password melalui profil pengguna.

- **Artikel Edukasi**:
  - Pengguna dapat mengakses dan membaca artikel terkait hama dan pengendaliannya.

### Fitur Admin
- **Manajemen Pengguna**: 
  - Admin dapat mengelola akun pengguna (CRUD).
  
- **Manajemen Data**:
  - Admin dapat melakukan operasi CRUD (Create, Read, Update, Delete) pada data penyakit hama dan hasil deteksi.

- **Manajemen Artikel**:
  - Admin dapat menambahkan, mengedit, atau menghapus artikel terkait hama dan pengendaliannya.
  
- **Manajemen Model**:
  - Admin dapat melakukan training ulang model CNN menggunakan data yang tersedia untuk meningkatkan akurasi deteksi.

### Manajemen Database
- Penyimpanan informasi hasil deteksi dalam database MySQL.
- Penyimpanan data gambar tanaman yang terdeteksi.
- Penyimpanan artikel yang dapat dibaca oleh pengguna.

## Teknologi
- **Backend**: PHP (tanpa menggunakan framework)
- **Model AI**: Convolutional Neural Network (CNN)
- **Frontend**: HTML, CSS, JavaScript
- **Database**: MySQL

## Instalasi

### Prerequisites
- PHP 8.x
- MySQL atau PostgreSQL

### Langkah-langkah Instalasi
1. Clone repository:
   ```bash
   git clone https://github.com/username/critter-shield.git
