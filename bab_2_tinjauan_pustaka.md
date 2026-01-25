2. Tinjauan Pustaka

2.1 Alur Penelitian

Alur penelitian yang dilakukan dalam pengembangan sistem ini dirancang secara sistematis mulai dari pengumpulan data hingga visualisasi akhir. Berikut adalah gambar alur penelitian yang digunakan:

![Gambar Alur Penelitian](flowchart.mermaid)
(Catatan: Gambar di atas merepresentasikan logika alur sistem)

Keterangan Alur Penelitian:
1.  Mulai: Proses inisialisasi sistem.
2.  Jalankan Script Scraping: Sistem menjalankan algoritma scraping menggunakan Python untuk mengambil data dari marketplace (Tokopedia).
3.  Data Mentah Diperoleh: Hasil scraping disimpan sementara dalam bentuk raw data.
4.  Validasi Data: Pengecekan apakah data yang diperoleh lengkap dan valid (tidak kosong).
5.  Pre-processing & Cleaning: Tahap pembersihan data yang meliputi penggunaan Regex untuk ekstraksi spesifikasi dan standarisasi penulisan judul produk.
6.  Data Bersih CSV: Data yang telah diproses disimpan dalam format CSV yang siap digunakan (optimized_titles.csv).
7.  Import ke Database: Data CSV diimpor ke dalam database MySQL melalui seeder Laravel.
8.  Pemrosesan Backend: Sistem rekomendasi (User-Based Collaborative Filtering) dijalankan pada sisi server.
9.  Visualisasi Dashboard: Hasil analisis dan rekomendasi ditampilkan dalam bentuk grafik interaktif pada dashboard.
10. Selesai: Proses berakhir.

2.2 Dataset

Dataset yang digunakan dalam laporan ini bersumber dari data publik yang diambil dari marketplace Tokopedia pada kategori aksesoris otomotif dan gadget kendaraan. Data ini diperoleh melalui teknik web scraping yang dilakukan pada tanggal 15 Januari 2026.

Dataset ini (filtered_products.csv / optimized_titles.csv) mencakup atribut-atribut berikut:
-   Name: Nama judul produk asli dari penjual.
-   Product Category: Kategori produk (contoh: Car Charger, Kabel Data, FM Transmitter).
-   Price: Harga produk dalam Rupiah.
-   Rating: Penilaian pengguna (skala 0-5).
-   Shop Location: Kota lokasi toko penjual.
-   Count Review: Jumlah ulasan yang diterima produk.

Data ini merepresentasikan transaksi dan preferensi pasar nyata terhadap aksesoris kendaraan yang sedang tren.

2.3 Teori: User-Based Collaborative Filtering

Sistem rekomendasi yang dibangun menggunakan pendekatan User-Based Collaborative Filtering. Konsep ini bekerja dengan mencari kesamaan pola preferensi antara satu pengguna dengan pengguna lain (tetangga/ neighbors). Jika Pengguna A dan Pengguna B memiliki sejarah penilaian yang mirip pada beberapa item, maka kemungkinan besar Pengguna A akan menyukai item yang disukai oleh Pengguna B tetapi belum pernah dilihatnya.

Langkah-langkah pembentukan sistem rekomendasi:
1.  Pembentukan Matriks User-Item: Mengubah data transaksi menjadi matriks di mana baris merepresentasikan User dan kolom merepresentasikan Item (Produk). Nilai sel berisi rating atau interaksi.
2.  Perhitungan Kemiripan (Similarity): Menghitung tingkat kesamaan antar semua pasangan user.
3.  Prediksi Rating: Memprediksi nilai ketertarikan pengguna target terhadap item baru berdasarkan bobot kemiripan tetangganya.

Untuk mengukur tingkat kemiripan, digunakan rumus Cosine Similarity. Rumus ini mengukur kosinus sudut antara dua vektor profil pengguna. Nilainya berkisar antara -1 hingga 1 (atau 0 hingga 1 dalam konteks rating positif), di mana nilai mendekati 1 menunjukkan kemiripan yang sangat tinggi.

Persamaan Cosine Similarity:

$$ Similarity(A, B) = \cos(\theta) = \frac{A \cdot B}{\|A\| \|B\|} = \frac{\sum_{i=1}^{n} (R_{Ai} \times R_{Bi})}{\sqrt{\sum_{i=1}^{n} (R_{Ai})^2} \times \sqrt{\sum_{i=1}^{n} (R_{Bi})^2}} $$

Keterangan:
-   R_{Ai}: Rating user A terhadap item i.
-   R_{Bi}: Rating user B terhadap item i.

2.4 Pre Processing

Tahap Pre-processing dilakukan untuk menjamin kualitas data sebelum masuk ke dalam algoritma rekomendasi. Berdasarkan skrip generate_titles_csv.py, proses ini meliputi:

1.  Pembersihan Nama Brand (Brand Cleaning)
    Mengekstraksi nama brand resmi (seperti Baseus, Anker, Vivan) dari judul produk yang berantakan. Jika tidak ditemukan brand populer, produk dilabeli sebagai "Generic". Hal ini penting untuk mengelompokkan produk berdasarkan reputasi merek.

2.  Ekstraksi Spesifikasi Teknis (Feature Extraction)
    Menggunakan Regular Expression (Regex) untuk mengambil spesifikasi teknis vital dari teks judul, yaitu:
    -   Wattage: Mendeteksi pola angka diikuti 'W' atau 'Watt' (contoh: "30W", "65 Watt").
    -   Amperage: Mendeteksi pola angka diikuti 'A' atau 'Amp' (contoh: "3A", "5 Amp").
    Informasi ini membedakan performa teknis antar produk yang serupa.

3.  Standarisasi Judul (Title Standardization)
    Menulis ulang judul produk dengan format baku: [Brand] + [Kata Kunci Kategori] + [Spesifikasi].
    Contoh: Judul asli "Charger mobil fast 30w murah banget vivan" diubah menjadi "Vivan Car Charger Mobil Fast Charging 30W".

4.  Pemetaan Kategori ke Keyword
    Setiap kategori produk dipetakan ke himpunan kata kunci inti (Core Keywords) yang relevan untuk memastikan konsistensi pencarian dan pengelompokan.

2.5 Cara Kerja Konsep Sistem Rekomendasi (Contoh Kasus Manual)

Berikut adalah simulasi perhitungan manual User-Based Collaborative Filtering menggunakan Cosine Similarity pada sampel data yang diambil dari dataset (filtered_products.csv).

Tabel 2.1: Matriks User-Item (Sampel Rating)

| User | Xiaomi Car Charger 37W | Vention Car Charger Dual USB | Hippo Car Charger PD 38W | UGREEN Fast Charger (Target) |
| :--- | :---: | :---: | :---: | :---: |
| User A | 5 | 3 | 4 | ? |
| User B | 4 | 2 | 5 | 4 |
| User C | 2 | 5 | 2 | 1 |

Target: Memprediksi ketertarikan (rating) User A terhadap produk "UGREEN Fast Charger".

Langkah 1: Menghitung Nilai Similarity

Kita akan menghitung kemiripan antara User A dengan User B, dan User A dengan User C menggunakan persamaan Cosine Similarity.

1.  Similarity antara User A dan User B:

Diketahui vektor A = (5, 3, 4) dan vektor B = (4, 2, 5).

-   Hitung Dot Product (Pembilang):
    $$ A \cdot B = (5 \times 4) + (3 \times 2) + (4 \times 5) $$
    $$ A \cdot B = 20 + 6 + 20 = 46 $$

-   Hitung Magnitude/Panjang Vektor (Penyebut):
    $$ \|A\| = \sqrt{5^2 + 3^2 + 4^2} = \sqrt{25 + 9 + 16} = \sqrt{50} \approx 7.071 $$
    $$ \|B\| = \sqrt{4^2 + 2^2 + 5^2} = \sqrt{16 + 4 + 25} = \sqrt{45} \approx 6.708 $$

-   Hitung Cosine Similarity:
    $$ Sim(A, B) = \frac{46}{7.071 \times 6.708} = \frac{46}{47.432} \approx 0.969 $$

2.  Similarity antara User A dan User C:

Diketahui vektor A = (5, 3, 4) dan vektor C = (2, 5, 2).

-   Hitung Dot Product:
    $$ A \cdot C = (5 \times 2) + (3 \times 5) + (4 \times 2) $$
    $$ A \cdot C = 10 + 15 + 8 = 33 $$

-   Hitung Magnitude User C (Magnitude A sudah diketahui = 7.071):
    $$ \|C\| = \sqrt{2^2 + 5^2 + 2^2} = \sqrt{4 + 25 + 4} = \sqrt{33} \approx 5.745 $$

-   Hitung Cosine Similarity:
    $$ Sim(A, C) = \frac{33}{7.071 \times 5.745} = \frac{33}{40.623} \approx 0.812 $$

Langkah 2: Prediksi Rating User Target

Setelah mendapatkan nilai similarity (User B = 0.969, User C = 0.812), kita menghitung prediksi rating User A untuk "UGREEN Fast Charger" menggunakan metode Weighted Average.

Rumus Prediksi:
$$ P(u, i) = \frac{\sum (Sim(u, n) \times R_{ni})}{\sum |Sim(u, n)|} $$

Dimana:
-   R(B, UGREEN) = 4
-   R(C, UGREEN) = 1

Perhitungan:
$$ Prediksi = \frac{(0.969 \times 4) + (0.812 \times 1)}{0.969 + 0.812} $$
$$ Prediksi = \frac{3.876 + 0.812}{1.781} $$
$$ Prediksi = \frac{4.688}{1.781} \approx 2.63 $$

Analisis Hasil:
Hasil prediksi 2.63 menunjukkan bahwa User A kemungkinan besar kurang tertarik pada produk "UGREEN Fast Charger". Hal ini disebabkan oleh pengaruh User C yang memberikan rating sangat rendah (1) pada produk tersebut, meskipun User B memberikan rating tinggi. Namun, karena User A memiliki kemiripan yang jauh lebih tinggi dengan User B (0.97) dibandingkan User C (0.81), prediksi nilai akhirnya lebih condong mendekati preferensi User B, tetapi tertarik ke bawah oleh User C. Sistem rekomendasi dapat menggunakan ambang batas (threshold), misalnya hanya merekomendasikan produk dengan prediksi > 3.5, sehingga produk ini mungkin tidak akan direkomendasikan kepada User A.
