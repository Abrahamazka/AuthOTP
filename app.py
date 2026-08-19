from flask import Flask, request, jsonify

app = Flask (__name__)

@app.route('/analisa', methods=['POST'])
def analisa_laporan():

    data = request.json

    teks_laporan = data.get('teks', '')
    teks_bersih = teks_laporan.lower()

    if "mati" in teks_bersih or "hack" in teks_bersih or "error" in teks_bersih or "meninggal" in teks_bersih: hasil = "Kritis: Server down"
    elif "otp" in teks_bersih or "login" in teks_bersih or "password" in teks_bersih: hasil = "Tinggi: Ada kesalahan pada sistem login"
    elif "nama" in teks_bersih or "profil" in teks_bersih or "foto" in teks_bersih: hasil = "Biasa: Update profil"
    else: hasil = "Belum Diklasifikasi"

    return jsonify({"kategori": hasil})

if __name__ == '__main__':
    app.run(port=5000, debug=True)