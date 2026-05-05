import ollama

def summarize_notulen(text):
    prompt = f"""
    Ringkas notulen rapat berikut dalam Bahasa Indonesia yang formal dan jelas.

    Format output:
    1. Ringkasan utama (maks 5 kalimat)
    2. Poin penting
    3. Keputusan rapat
    4. Action items (siapa melakukan apa)

    Notulen:
    {text}
    """

    response = ollama.chat(
        model='llama3',
        messages=[
            {"role": "user", "content": prompt}
        ]
    )

    return response['message']['content']


if __name__ == "__main__":
    notulen = """
    Rapat Evaluasi Termin 2 
    keputusan 
    1. Evaluasi perbaikan media sosial 
       keputusan yang diambil : 
        1. menggunakan resolusi gambar yang lebih tinggi untuk postingan Instagram agar lebih menarik
           tindakan : rahel harus mengupload ulang postingan terakhir deadline 24 april 2026
    """

    hasil = summarize_notulen(notulen)
    print("\n=== HASIL RINGKASAN ===\n")
    print(hasil)