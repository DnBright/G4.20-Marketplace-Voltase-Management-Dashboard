# Bab D: Metode/Teknik yang Digunakan

Pada bab ini, akan dijelaskan secara rinci metode dan teknik yang digunakan dalam pengembangan sistem, mulai dari akuisisi data mentah hingga pemrosesan data cerdas untuk kebutuhan visualisasi dan rekomendasi.

---

## 1. Perolehan Data (Data Acquisition)

Untuk mendapatkan dataset yang relevan dan mencerminkan kondisi pasar terkini, digunakan dua teknik utama dalam pengumpulan data.

### A. Web Crawling & Scraping
**Definisi & Landasan:**
*Web Scraping* adalah teknik ekstraksi data secara otomatis dari situs web. Teknik ini dipilih karena data transaksi *real-time* marketplace tidak tersedia secara publik (Open API). Dengan scraping, kita dapat membangun dataset primer yang memiliki tingkat kebaruan (*recency*) tinggi.

**Proses Teknis:**
1.  **Crawling (Penjelajahan):** Sistem bot menavigasi halaman kategori "Aksesoris Mobil" untuk mengumpulkan URL unik setiap produk.
2.  **Scraping (Ekstraksi):** Mengambil elemen HTML tertentu (Title, Price, Rating, Location) dan menyimpannya ke dalam format CSV (`filtered_products.csv`).

---

## 2. Pra-pemrosesan Data (Data Pre-processing)

Data mentah hasil scraping memiliki format teks yang tidak terstruktur (*unstructured text*), khususnya pada bagian judul produk yang seringkali mengandung "spam keywords". Oleh karena itu, diterapkan teknik pemrosesan teks menggunakan **Python**.

### A. Ekstraksi Fitur Berbasis Pola (Regex)
**Landasan Pemilihan Teknik:**
Penggunaan *Regular Expressions* (Regex) dipilih karena kemampuannya mendeteksi pola teks yang kompleks (seperti angka yang diikuti satuan listrik) dengan presisi tinggi dan performa komputasi yang cepat dibandingkan metode *Natural Language Processing* (NLP) yang berat.

**Implementasi Kode & Penjelasan:**
Kode berikut bertugas "membaca" judul produk dan mengambil spesifikasi teknis (Watt dan Ampere) secara otomatis.

```python
import re

def extract_specs(name):
    """
    Fungsi untuk mengekstraksi informasi teknis (Watt & Ampere)
    menggunakan pola Regular Expression.
    """
    # 1. Ekstraksi Wattage
    # Regex Pattern: Mencari angka (\d+) yang diikuti 'W' atau 'Watt'
    # re.IGNORECASE membuat pencarian tidak peduli huruf besar/kecil
    watts = re.findall(r'(\d+)\s*[Ww]att|(\d+)[Ww]', name, re.IGNORECASE)
    
    watt_str = ""
    if watts:
        # Mengambil hasil match pertama yang valid
        w = next((x for x in watts[0] if x), "")
        if w: watt_str = f"{w}W"
            
    # 2. Ekstraksi Amperage
    # Regex Pattern: Mencari angka (bisa desimal) diikuti 'A' atau 'Amp'
    amps = re.findall(r'(\d+\.?\d*)\s*[Aa]mp|(\d+\.?\d*)[Aa]', name, re.IGNORECASE)
    
    amp_str = ""
    if amps:
        a = next((x for x in amps[0] if x), "")
        if a: amp_str = f"{a}A"
            
    return watt_str, amp_str
```

**Hasil Pemrosesan:**
- *Input:* "Charger Mobil **30W** Fast Charging" $\rightarrow$ *Output:* Watt: **30W**
- *Input:* "Adapter Lighter **3.4A** Dual USB" $\rightarrow$ *Output:* Ampere: **3.4A**

### B. Identifikasi Entitas Brand (Named Entity Recognition Sederhana)
**Landasan Pemilihan Teknik:**
Metode *Dictionary-based Lookup* (pencocokan kamus) digunakan untuk mengidentifikasi nama brand. Teknik ini dipilih karena daftar brand populer dalam kategori elektronik relatif terbatas dan statis, sehingga metode pencocokan string langsung jauh lebih efisien daripada model *Machine Learning*.

**Implementasi Kode & Penjelasan:**
```python
def clean_brand_name(name):
    # Daftar Brand Whitelist (Entitas yang valid)
    brands = ['Baseus', 'Anker', 'Aukey', 'ACMIC', 'UNEED', 'KIIP', 
              'JOYSEUS', 'Vivan', 'Robot', 'Usams', 'Xiaomi', 'Samsung']
    
    name_lower = name.lower()
    
    # Melakukan iterasi cek apakah brand ada di dalam judul produk
    for brand in brands:
        if brand.lower() in name_lower:
            return brand  # Kembalikan nama brand jika ditemukan
            
    return "Generic"  # Label default jika tidak ada brand ternama
```

### C. Standardisasi Judul Semantik (Semantic Title Optimization)
**Landasan Pemilihan Teknik:**
Untuk kebutuhan visualisasi data (*Data Visualization*), label data harus seragam dan bersih. Teknik *Template Construction* digunakan untuk menyusun ulang judul produk agar memiliki struktur yang konsisten, sehingga memudahkan pembacaan grafik pada dashboard.

**Implementasi Kode & Penjelasan:**
```python
def generate_title(row):
    # Mengambil atribut hasil ekstraksi sebelumnya
    brand = clean_brand_name(row['name'])
    watt, amp = extract_specs(row['name'])
    
    # Menentukan Keyword Inti Berdasarkan Kategori
    # Tujuannya agar semua produk sejenis memiliki nama dasar yang sama
    core_keywords = ""
    if row['product_category'] == 'Car Charger Adapter':
        core_keywords = "Car Charger Mobil Fast Charging"
    elif row['product_category'] == 'Kabel Data':
        core_keywords = "Kabel Data Charger Braided"
    
    # Menyusun Judul Baru (Template Construction)
    # Formula: BRAND + KATA KUNCI + SPESIFIKASI
    specs = watt if watt else amp
    new_title = f"{brand} {core_keywords} {specs}"
    
    # Membersihkan spasi berlebih
    return re.sub(r'\s+', ' ', new_title).strip()
```

---

## 3. Integrasi Sistem & Visualisasi

Data yang telah melalui tahap pra-pemrosesan di atas (`optimized_titles.csv`) memiliki kualitas tinggi (*high-fidelity*), yang kemudian diimpor ke dalam Database MySQL untuk diolah lebih lanjut oleh backend sistem.

1.  **Database Storage**: Menyimpan data terstruktur hasil Python.
2.  **Chart.js Visualization**: Merender grafik statistik berdasarkan atribut bersih (Brand/Specs) hasil ekstraksi.

**Kesimpulan Metode:**
Kombinasi teknik *Scraping* untuk akuisisi data dan *Regex Filtering* untuk pembersihan data terbukti mampu mengubah data teks mentah yang "kotor" menjadi informasi terstruktur yang bernilai tinggi untuk analisis bisnis.
