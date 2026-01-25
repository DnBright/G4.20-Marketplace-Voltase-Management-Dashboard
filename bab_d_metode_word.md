BAB D. METODE/TEKNIK YANG DIGUNAKAN

Bab ini menjelaskan teknik-teknik yang diterapkan dalam pengembangan sistem, mulai dari tahap pengambilan data mentah (pra-pemrosesan) hingga tahap penyajian informasi secara visual (visualisasi data).

1. Teknik Pra-Pemrosesan Data (Data Pre-processing)

Sebelum data dapat divisualisasikan, serangkaian teknik pra-pemrosesan dilakukan untuk memastikan data bersih, terstruktur, dan relevan.

a. Web Scraping (Pengambilan Data)
Teknik *Web Scraping* digunakan untuk mengumpulkan data produk (Nama, Harga, Rating, Toko, Kota) secara otomatis dari situs *e-commerce* (Tokopedia). Kami menggunakan bahasa pemrograman **Python** dengan teknik simulasi *request* ke API GraphQL Tokopedia untuk mendapatkan data JSON yang lengkap.

Alat & Pustaka Python 3.13, `requests` (untuk HTTP request), `pandas` (untuk manipulasi data).

Berikut adalah potongan kode utama yang digunakan untuk mengambil data dan menyimpannya ke format mentah:

```python
import requests
import pandas as pd

url = 'https://gql.tokopedia.com/graphql/SearchProductQueryV5'
headers = {
    'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)...'
}

data_payload = [{
    "operationName": "SearchProductQueryV5",
    "query": "query SearchProductQueryV5($params: String!) { ... }"
}]

response = requests.post(url, headers=headers, json=data_payload)
products = response.json()[0]['data']['organic']['data']['products']

data_list = []
for item in products:
    data_list.append({
        'id': item['id'],
        'name': item['name'],
        'price': item['price']['number'],
        'rating': item['rating'],
        'city': item['shop']['city']
    })

df = pd.DataFrame(data_list)
df.to_csv('filtered_products.csv', index=False)
```

b. Data Cleaning & Transformation (Optimasi Judul)
Data hasil scraping seringkali memiliki judul produk yang tidak konsisten atau terlalu panjang ("spammy keyword"). Teknik **Regular Expression (Regex)** digunakan untuk mengekstrak spesifikasi teknis (Watt, Ampere) dan menstandarisasi nama produk.

Alat & Pustaka: Python, `re` (Regex), `pandas`.

Logika Kode (Snippet):
Kode berikut menunjukkan bagaimana sistem membersihkan nama brand dan mengekstrak spesifikasi teknis:

```python

import re
import pandas as pd

def clean_brand_name(name):

    brands = ['Baseus', 'Anker', 'Aukey', 'Xiaomi', 'Samsung']
    for brand in brands:
        if brand.lower() in name.lower():
            return brand
    return "Generic"

def generate_title(row):
    original_name = row['name']
    
    brand = clean_brand_name(original_name)
    
    watt_match = re.search(r'(\d+)\s*[Ww]att', original_name)
    specs = watt_match.group(0) if watt_match else ""
    
    new_title = f"{brand} {row['product_category']} {specs}"
    return new_title.strip()

df = pd.read_csv('hasil_scraping_baru.csv')
df['optimized_title'] = df.apply(generate_title, axis=1)
df.to_csv('optimized_titles.csv', index=False)
```

2. Teknik Visualisasi Data

Setelah data bersih, teknik visualisasi diterapkan untuk mengubah data angka menjadi grafik yang informatif dan interaktif.

a. Backend Data Processing (Laravel)
Di sisi server, Framework **Laravel 10** digunakan untuk mengelompokkan data (Grouping) sebelum dikirim ke grafik. Contohnya adalah menghitung total pendapatan per kota.

Kode Controller (PHP):
```php
// File: ProductController.php
public function dashboard() {
    // Mengelompokkan pendapatan berdasarkan kota
    $incomeData = Order::select('city', DB::raw('SUM(price) as total_income'))
        ->groupBy('city')
        ->orderByDesc('total_income')
        ->limit(5)
        ->get();
        
    return view('admin.dashboard', compact('incomeData'));
}
```

### b. Frontend Visualization (Chart.js)
Di sisi antarmuka, library **Chart.js** digunakan untuk merender grafik batang (Bar Chart) dan grafik garis (Line Chart) yang responsif.

**Kode Visualisasi (JavaScript):**
```javascript
// File: dashboard.blade.php
const ctx = document.getElementById('incomeChart').getContext('2d');
new Chart(ctx, {
    type: 'bar', // Jenis Grafik Batang
    data: {
        labels: ['Jakarta', 'Surabaya', 'Bandung', 'Medan', 'Semarang'],
        datasets: [{
            label: 'Total Pendapatan (Rp)',
            data: [5000000, 3500000, 2000000, 1500000, 1000000],
            backgroundColor: '#4ade80', // Warna Hijau Visual
            borderRadius: 5
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        }
    }
});
```

## 3. Alur Kerja Sistem (System Workflow)

Berikut adalah diagram alur (Flowchart) yang menggambarkan proses dari awal hingga akhir:

1.  **Mulai (Start)**
2.  **Web Scraping**: Sistem melakukan request ke Tokopedia dan mengambil data mentah produk.
3.  **Data Mentah (Raw Data)**: Data disimpan dalam format CSV/Excel.
4.  **Pre-processing (Cleaning)**:
    *   Sistem membaca file CSV.
    *   Melakukan filtering kategori.
    *   Mengekstrak spesifikasi (Watt, Ampere).
    *   Menstandarisasi Judul Produk.
5.  **Database Storage**: Data bersih (Clean Data) diimpor ke database aplikasi (MySQL).
6.  **Data Analysis**: Server menghitung statistik (Total penjualan, Tren harga).
7.  **Visualisasi**: Data ditampilkan dalam bentuk Dashboard Grafik kepada pengguna.
8.  **Selesai (End)**

*(Anda bisa menyalin teks di atas ke Word. Untuk gambar flowchart, Anda bisa menggunakan fitur "SmartArt" di Word dengan urutan langkah di atas).*
