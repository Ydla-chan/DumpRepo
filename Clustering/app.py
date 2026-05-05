from flask import Flask, render_template
import pandas as pd
import numpy as np
import json
import re
from sklearn.cluster import KMeans

app = Flask(__name__)

# --- 1. DATA BARU (DENGAN LOGIKA JADWAL KERJA NYATA) ---
# Total 38 Rapat. Tidak ada double booking per orang.
json_data_str = """
[
    {"id_rapat":"R1","hari":"1(Senin)","jam":"09.00 Wib","peserta":"Gilang, Supar, Metta"},
    {"id_rapat":"R2","hari":"1(Senin)","jam":"11.00 Wib","peserta":"Supar, Metta, Gilang, Fida"},
    {"id_rapat":"R3","hari":"1(Senin)","jam":"13.00 Wib","peserta":"Metta, Supar, Alena, Budi, Gilang"},
    {"id_rapat":"R4","hari":"1(Senin)","jam":"14.00 Wib","peserta":"Supar, Gilang, Metta"},
    {"id_rapat":"R5","hari":"1(Senin)","jam":"15.00 Wib","peserta":"Metta, Gilang, Fida"},
    {"id_rapat":"R6","hari":"1(Senin)","jam":"15.00 Wib","peserta":"Supar, Alena, Budi, Citra, Sartika"},
    {"id_rapat":"R7","hari":"1(Senin)","jam":"16.00 Wib","peserta":"Metta, Supar, Alena, Fida"},
    {"id_rapat":"R8","hari":"2(Selasa)","jam":"09.00 Wib","peserta":"Supar, Fida, Metta, Gilang, Citra"},
    {"id_rapat":"R9","hari":"2(Selasa)","jam":"10.00 Wib","peserta":"Metta, Gilang"},
    {"id_rapat":"R10","hari":"2(Selasa)","jam":"10.00 Wib","peserta":"Supar, Fida, Budi, Citra, Alena"},
    {"id_rapat":"R11","hari":"2(Selasa)","jam":"11.00 Wib","peserta":"Metta, Gilang, Fida, Supar, Citra"},
    {"id_rapat":"R12","hari":"2(Selasa)","jam":"11.00 Wib","peserta":"Budi, Alena, Sartika, Dian, Eko"},
    {"id_rapat":"R13","hari":"2(Selasa)","jam":"13.00 Wib","peserta":"Supar, Gilang"},
    {"id_rapat":"R14","hari":"2(Selasa)","jam":"13.00 Wib","peserta":"Metta, Fida"},
    {"id_rapat":"R15","hari":"2(Selasa)","jam":"14.00 Wib","peserta":"Supar, Gilang"},
    {"id_rapat":"R16","hari":"2(Selasa)","jam":"14.00 Wib","peserta":"Metta, Fida, Budi, Alena"},
    {"id_rapat":"R17","hari":"2(Selasa)","jam":"15.00 Wib","peserta":"Metta, Supar, Gilang, Fida, Alena"},
    {"id_rapat":"R18","hari":"2(Selasa)","jam":"16.00 Wib","peserta":"Gilang, Supar"},
    {"id_rapat":"R19","hari":"3(Rabu)","jam":"10.00 Wib","peserta":"Metta, Fida, Budi"},
    {"id_rapat":"R20","hari":"3(Rabu)","jam":"11.00 Wib","peserta":"Gilang, Fida, Supar"},
    {"id_rapat":"R21","hari":"3(Rabu)","jam":"11.00 Wib","peserta":"Budi, Alena, Metta"},
    {"id_rapat":"R22","hari":"3(Rabu)","jam":"13.00 Wib","peserta":"Metta, Budi, Supar, Gilang, Fida"},
    {"id_rapat":"R23","hari":"3(Rabu)","jam":"14.00 Wib","peserta":"Metta, Alena, Fida, Gilang, Budi"},
    {"id_rapat":"R24","hari":"3(Rabu)","jam":"15.00 Wib","peserta":"Metta, Supar, Gilang"},
    {"id_rapat":"R25","hari":"3(Rabu)","jam":"16.00 Wib","peserta":"Fida, Budi, Gilang"},
    {"id_rapat":"R26","hari":"4(Kamis)","jam":"09.00 Wib","peserta":"Gilang, Supar, Alena, Metta"},
    {"id_rapat":"R27","hari":"4(Kamis)","jam":"10.00 Wib","peserta":"Supar, Metta"},
    {"id_rapat":"R28","hari":"4(Kamis)","jam":"10.00 Wib","peserta":"Gilang, Fida, Alena, Budi"},
    {"id_rapat":"R29","hari":"4(Kamis)","jam":"11.00 Wib","peserta":"Metta, Alena"},
    {"id_rapat":"R30","hari":"4(Kamis)","jam":"13.00 Wib","peserta":"Gilang, Supar, Fida"},
    {"id_rapat":"R31","hari":"4(Kamis)","jam":"14.00 Wib","peserta":"Gilang, Alena, Fida"},
    {"id_rapat":"R32","hari":"4(Kamis)","jam":"15.00 Wib","peserta":"Metta, Gilang, Supar, Alena, Citra"},
    {"id_rapat":"R33","hari":"5(Jumat)","jam":"09.00 Wib","peserta":"Metta, Supar, Gilang, Budi"},
    {"id_rapat":"R34","hari":"5(Jumat)","jam":"09.00 Wib","peserta":"Alena, Fida, Sartika, Dian, Citra"},
    {"id_rapat":"R35","hari":"5(Jumat)","jam":"10.00 Wib","peserta":"Metta, Supar, Alena, Fida"},
    {"id_rapat":"R36","hari":"5(Jumat)","jam":"11.00 Wib","peserta":"Supar, Gilang, Budi, Metta"},
    {"id_rapat":"R37","hari":"5(Jumat)","jam":"13.00 Wib","peserta":"Supar, Alena, Metta, Fida"},
    {"id_rapat":"R38","hari":"5(Jumat)","jam":"14.00 Wib","peserta":"Supar, Gilang, Fida, Budi"}
]
"""

def perform_clustering_logic():
    # 1. Load Data
    data = json.loads(json_data_str)
    df = pd.DataFrame(data)

    # 2. Preprocessing
    def clean_day(x):
        match = re.search(r'(\d+)', str(x))
        return int(match.group(1)) if match else None
    
    def clean_hour(x):
        clean = str(x).replace(' Wib', '').replace(' wib', '').strip()
        try: return float(clean)
        except: return None

    df['hari_num'] = df['hari'].apply(clean_day)
    df['jam_num'] = df['jam'].apply(clean_hour)

    # 3. Clustering Anggota
    all_participants = []
    for p in df['peserta']:
        if pd.notna(p):
            all_participants.extend([x.strip() for x in p.split(',')])

    member_counts = pd.Series(all_participants).value_counts().reset_index()
    member_counts.columns = ['Nama', 'Hadir']

    # K-Means Process
    X = member_counts[['Hadir']].values
    k = 3 if len(X) >= 3 else len(X)
    kmeans = KMeans(n_clusters=k, random_state=42, n_init=10)
    member_counts['Cluster'] = kmeans.fit_predict(X)

    # Stats Calculation
    stats = {
        'total_rapat': len(df),
        'inertia': round(kmeans.inertia_, 2),
        'iterations': kmeans.n_iter_,
        'centroids': sorted([round(x[0], 2) for x in kmeans.cluster_centers_], reverse=True)
    }

    # Sorting Label (Agar 0=Jarang, 2=Sering)
    centroids = kmeans.cluster_centers_.flatten()
    sorted_idx = np.argsort(centroids)
    label_map = {old: new for new, old in enumerate(sorted_idx)}
    cat_names = {0: 'Jarang Hadir', 1: 'Cukup Sering', 2: 'Sering Hadir'}
    
    member_counts['Cluster'] = member_counts['Cluster'].map(label_map)
    member_counts['Kategori'] = member_counts['Cluster'].map(cat_names)
    members_data = member_counts.to_dict(orient='records')

    # 4. Mencari Waktu Kosong
    # Definisi Slot Kerja Standar (09.00 - 16.00), Istirahat 12.00
    standard_hours = [9.0, 10.0, 11.0, 13.0, 14.0, 15.0, 16.0]
    days_map = {1:'Senin', 2:'Selasa', 3:'Rabu', 4:'Kamis', 5:'Jumat'}
    
    # Cek slot yang benar-benar kosong (tidak ada satupun rapat)
    occupied_slots = set(zip(df['hari_num'], df['jam_num']))
    empty_slots = []

    for d in range(1, 6):
        for h in standard_hours:
            if (d, h) not in occupied_slots:
                empty_slots.append({
                    'hari': days_map[d],
                    'jam': f"{h:05.2f}".replace('.', ':')
                })

    return members_data, empty_slots, stats

@app.route('/')
def index():
    raw_data = json.loads(json_data_str)
    return render_template('home.html', raw_data=raw_data)

@app.route('/analyze')
def analyze():
    members, empty_slots, stats = perform_clustering_logic()
    return render_template('result.html', members=members, empty_slots=empty_slots, stats=stats)

if __name__ == '__main__':
    app.run(debug=True)