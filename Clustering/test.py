from flask import Flask, render_template_string
import pandas as pd
import numpy as np
from sklearn.cluster import KMeans
from sklearn.preprocessing import StandardScaler
import random

app = Flask(__name__)

# ==============================
# 1. Generate Dummy Meeting Data
# ==============================
np.random.seed(42)

def generate_dummy_meetings(n=100):
    data = []

    for i in range(n):
        hari = np.random.randint(1, 6)  # Senin–Jumat

        # Jam format HH:MM
        hour = random.randint(8, 17)
        minute = random.choice([0, 15, 30, 45])
        jam_str = f"{hour:02d}:{minute:02d}"

        jumlah_undangan = np.random.randint(5, 20)
        hadir = np.random.randint(0, jumlah_undangan)
        persen_hadir = hadir / jumlah_undangan

        data.append({
            "hari": hari,
            "jam_str": jam_str,
            "jumlah_undangan": jumlah_undangan,
            "hadir": hadir,
            "persen_hadir": persen_hadir
        })

    return pd.DataFrame(data)

df = generate_dummy_meetings()

# ==============================
# 2. Convert HH:MM → Float for Clustering
# ==============================
df["jam_float"] = df["jam_str"].apply(
    lambda x: int(x.split(":")[0]) + int(x.split(":")[1]) / 60
)

# ==============================
# 3. Clustering
# ==============================
features = df[["hari", "jam_float", "persen_hadir"]]
scaler = StandardScaler()
scaled = scaler.fit_transform(features)

kmeans = KMeans(n_clusters=3, random_state=42)
df["cluster"] = kmeans.fit_predict(scaled)

cluster_scores = df.groupby("cluster")["persen_hadir"].mean().sort_values(ascending=False)
best_cluster = cluster_scores.index[0]

# ==============================
# 4. Rekomendasi waktu
# ==============================
def rekomendasi_waktu_dummy():
    df_user = df.sample(10)
    scaled_user = scaler.transform(df_user[["hari", "jam_float", "persen_hadir"]])
    df_user["cluster"] = kmeans.predict(scaled_user)

    hasil = df_user[df_user["cluster"] == best_cluster]
    if hasil.empty:
        return "Tidak ada rekomendasi."

    rekom = (
        hasil.groupby(["hari", "jam_str"])
        .size()
        .reset_index()
        .sort_values(0, ascending=False)
        .iloc[0]
    )

    hari = int(rekom["hari"])
    jam = rekom["jam_str"]
    hari_map = ["Senin","Selasa","Rabu","Kamis","Jumat"]

    return f"Waktu rapat terbaik: {hari_map[hari-1]} jam {jam}"

# ==============================
# 5. Flask Web Template with Tailwind
# ==============================

template = """
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Clustering Rapat Dummy</title>
</head>
<body class="bg-slate-100 p-6">
  <div class="max-w-5xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Dashboard Clustering Rapat (Dummy)</h1>

    <div class="bg-white rounded-2xl shadow p-5 mb-8">
      <h2 class="text-xl font-semibold mb-3">Hasil Rekomendasi</h2>
      <p class="text-lg font-medium text-teal-600">{{ rekomendasi }}</p>
    </div>

    <div class="bg-white rounded-2xl shadow p-5">
      <h2 class="text-xl font-semibold mb-4">Daftar Rapat Dummy</h2>

      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="border-b bg-slate-50">
            <th class="p-2">Hari</th>
            <th class="p-2">Jam</th>
            <th class="p-2">Undangan</th>
            <th class="p-2">Hadir</th>
            <th class="p-2">Cluster</th>
          </tr>
        </thead>
        <tbody>
          {% for r in rapat %}
          <tr class="border-b hover:bg-slate-50">
            <td class="p-2">{{ hari_map[r.hari-1] }}</td>
            <td class="p-2">{{ r.jam_str }}</td>
            <td class="p-2">{{ r.jumlah_undangan }}</td>
            <td class="p-2">{{ r.hadir }}</td>
            <td class="p-2">Cluster {{ r.cluster }}</td>
          </tr>
          {% endfor %}
        </tbody>
      </table>

    </div>
  </div>
</body>
</html>
"""

@app.route("/")
def home():
    return render_template_string(
        template,
        rekomendasi=rekomendasi_waktu_dummy(),
        rapat=df.to_dict(orient="records"),
        hari_map=["Senin","Selasa","Rabu","Kamis","Jumat"]
    )

if __name__ == "__main__":
    app.run(debug=True)
