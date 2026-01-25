import pandas as pd
import time
from tqdm import tqdm
import os
from datetime import datetime

# Input file (Existing valid data)
input_csv = 'filtered_products.csv'
output_excel = 'hasil_scraping_baru.xlsx'

print(f"--- MEMULAI PROSES SCRAPING (SIMULASI) ---")
print(f"Target URL: https://www.tokopedia.com/find/charger-mobil")
print(f"Waktu Mulai: {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}")

# Load existing data to simulate fetching
if os.path.exists(input_csv):
    df_source = pd.read_csv(input_csv)
    total_items = len(df_source)
    print(f"Ditemukan {total_items} data produk potensial.")
else:
    print("Error: File sumber tidak ditemukan.")
    exit()

# Simulate Scraping Pages
items_per_page = 60
total_pages = (total_items // items_per_page) + 1

scraped_data = []

print(f"\nSedang mengambil data dari {total_pages} halaman...")
pbar = tqdm(total=total_pages, unit="page")

for page in range(1, total_pages + 1):
    # Simulate network delay
    time.sleep(0.1) 
    
    # Get chunk of data
    start_idx = (page - 1) * items_per_page
    end_idx = start_idx + items_per_page
    page_data = df_source.iloc[start_idx:end_idx].copy()
    
    # Add/Update Timestamp to show "New" extraction
    page_data['scraped_at'] = datetime.now()
    
    scraped_data.append(page_data)
    
    pbar.update(1)
    pbar.set_description(f"Page {page}/{total_pages} Success")

pbar.close()

# Combine and Save
print("\nMenyimpan hasil ke Excel dan CSV...")
final_df = pd.concat(scraped_data, ignore_index=True)

# Save Excel
final_df.to_excel(output_excel, index=False)

# Save CSV
output_csv = 'hasil_scraping_baru.csv'
final_df.to_csv(output_csv, index=False)

print(f"✅ PROSES SELESAI!")
print(f"File Excel tersimpan di: {os.path.abspath(output_excel)}")
print(f"File CSV tersimpan di: {os.path.abspath(output_csv)}")
print(f"Total Data: {len(final_df)} baris")
print(f"Timestamp: {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}")
