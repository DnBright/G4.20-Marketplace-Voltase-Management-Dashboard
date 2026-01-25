# Bab D: Metode/Teknik yang Digunakan

Pada bab ini, dijelaskan secara rinci metode dan teknik yang diterapkan dalam sistem, khususnya pada taha akuisisi dan pemrosesan data untuk menjamin validitas hasil visualisasi.

---

## 1. Perolehan Data (Data Acquisition)

Data diperoleh dari platform marketplace (seperti Tokopedia/Shopee) melalui dua tahap utama untuk memastikan dataset yang digunakan berkualitas tinggi.

### A. Crawling (Navigasi Dataset)
**Crawling** adalah tahap navigasi otomatis. Sistem melakukan penelusuran pada halaman kategori produk (misal: *Aksesoris Mobil*) untuk mengumpulkan URL setiap produk yang sesuai dengan parameter pencarian.

*   **Teknik**: Menggunakan simulasi browser untuk menangani konten dinamis (*lazy loading*).
*   **Landasan**: Teknik ini dipilih karena marketplace modern menggunakan JavaScript berat yang tidak bisa diakses hanya dengan *HTTP Request* biasa.
*   **Hasil**: Kumpulan URL unik yang akan menjadi input bagi proses scraping.

### B. Scraping (Ekstraksi Data)
**Scraping** adalah tahap pengambilan data spesifik dari setiap URL yang sudah ditemukan.

*   **Elemen yang Diambil**: Nama produk, Harga, Kategori, Lokasi (Kota), serta Rating dan Jumlah Review.
*   **Landasan**: Pengambilan data secara langsung (*direct scraping*) memberikan data yang lebih *real-time* dan granular dibandingkan dataset sekunder yang seringkali sudah kadaluarsa.
*   **Hasil**: Sebuah dataset mentah berformat CSV (`filtered_products.csv`).

---

## 2. Pra-pemrosesan Data & Filtering Cerdas (Python Processing)

Dataset mentah dari marketplace seringkali memiliki judul yang "berisik" (banyak kata kunci promosi) sehingga sulit dikelompokkan secara visual. Tahap ini menggunakan **Python** untuk melakukan filtering dan ekstraksi fitur.

### A. Ekstraksi Spesifikasi dengan Regular Expression (Regex)
**Landasan Teori**:
Penggunaan *Regular Expression* (Regex) dipilih karena pola teks spesifikasi (seperti "30W", "2.4A") memiliki struktur yang pasti namun posisinya acak dalam kalimat. Regex jauh lebih efisien dan akurat untuk kasus ini dibandingkan *String Matching* biasa.

**Kode Implementasi:**
```python
import re

def extract_specs(name):
    """
    Mengekstraksi Watt dan Ampere dari nama produk menggunakan Regex.
    """
    # Mencari pola angka yang diikuti oleh Watt/W (Case Insensitive)
    # Pola r'(\d+)\s*[Ww]att' menangkap angka sebelum kata 'Watt'
    watts = re.findall(r'(\d+)\s*[Ww]att|(\d+)[Ww]', name, re.IGNORECASE)
    
    watt_str = ""
    if watts:
        # Mengambil match pertama yang valid
        w = next((x for x in watts[0] if x), "")
        if w: watt_str = f"{w}W"
            
    # Mencari pola angka yang diikuti oleh Amp/A (Contoh: "2.4A")
    amps = re.findall(r'(\d+\.?\d*)\s*[Aa]mp|(\d+\.?\d*)[Aa]', name, re.IGNORECASE)
    
    amp_str = ""
    if amps:
        a = next((x for x in amps[0] if x), "")
        if a: amp_str = f"{a}A"
            
    return watt_str, amp_str
```

### B. Identifikasi Brand (Filtering)
**Landasan Teori**:
Metode *Dictionary-based Lookup* (pencocokan berbasis kamus) digunakan untuk memisahkan entitas brand. Karena jumlah brand ternama dalam kategori elektronik relatif terbatas, metode ini memberikan akurasi 100% untuk brand yang terdaftar tanpa perlu model *Machine Learning* yang berat.

**Kode Implementasi:**
```python
def clean_brand_name(name):
    # Daftar Brand Whitelist (Target Analisis)
    brands = ['Baseus', 'Anker', 'Aukey', 'ACMIC', 'Xiaomi', 'Samsung', 'Vivan']
    
    name_lower = name.lower()
    for brand in brands:
        # Jika nama brand ditemukan dalam judul
        if brand.lower() in name_lower:
            return brand
            
    return "Generic" # Default jika bukan brand ternama
```

### C. Semantic Title Optimization (Rekonstruksi Judul)
**Landasan Teori**:
Visualisasi data membutuhkan label yang bersih dan seragam. Judul asli marketplace yang panjang (70+ karakter) akan merusak tampilan grafik. Oleh karena itu, dilakukan rekonstruksi judul semantik dengan format standar.

**Kode Implementasi:**
```python
def generate_title(row):
    # Alur: Ambil Data Asli -> Ekstraksi Fitur -> Susun Ulang
    original_name = row['name']
    brand = clean_brand_name(original_name)
    watt, amp = extract_specs(original_name)
    
    # Keyword inti berdasarkan kategori agar label seragam
    core_keywords = ""
    if row['product_category'] == 'Car Charger Adapter':
        core_keywords = "Car Charger Mobil Fast Charging"
    elif row['product_category'] == 'Kabel Data':
        core_keywords = "Kabel Data Charger"
    
    # Gabungkan menjadi Judul Baru: "[Brand] [Keyword] [Specs]"
    specs = watt if watt else amp
    new_title = f"{brand} {core_keywords} {specs}"
    
    return new_title.strip()
```
**Analisis Hasil**: Judul yang awalnya *"PROMO Muraaah Baseus Charger Mobil 30W QC3.0"* berhasil diubah menjadi **"Baseus Car Charger Mobil Fast Charging 30W"**, yang siap ditampilkan di dashboard.

---

## 3. Integrasi Sistem Visualisasi

Data yang telah bersih (`optimized_titles.csv`) diimpor ke **MySQL** dan divisualisasikan menggunakan **Chart.js**.

*   **Line Chart**: Untuk melihat tren pertumbuhan pendapatan (*Growth Dynamics*).
*   **Polar Area Chart**: Untuk memetakan distribusi geografis kota (*Geographic Pulse*).

Penggunaan pustaka Chart.js dipilih karena kemampuannya merender grafik interaktif berbasis Canvas HTML5 yang ringan dan responsif pada browser modern.
