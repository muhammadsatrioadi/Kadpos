from flask import Flask, render_template, request, redirect, send_file
import csv
import os
from fpdf import FPDF
import io

app = Flask(__name__)
DATA_FILE = 'data.csv'

kolom_kolom = [
    "dusun", "nama", "kategori", "jenis_kelamin", "tanggal_lahir", "umur", "alamat", "nomor_ktp", "nomor_bpjs",
    "berat_badan", "tinggi_badan", "imt", "lingkar_perut", "tekanan_darah", "mental_dan_emosional", "keterangan"
]

def baca_data():
    if not os.path.exists(DATA_FILE):
        return []
    with open(DATA_FILE, newline='', encoding='utf-8') as f:
        reader = csv.DictReader(f)
        return list(reader)

def simpan_data(data):
    file_exists = os.path.exists(DATA_FILE)
    with open(DATA_FILE, 'a', newline='', encoding='utf-8') as f:
        writer = csv.DictWriter(f, fieldnames=kolom_kolom)
        if not file_exists:
            writer.writeheader()
        writer.writerow(data)

@app.route('/')
def index():
    return render_template('form.html', kolom_kolom=kolom_kolom)

@app.route('/simpan', methods=['POST'])
def simpan():
    data = {kolom: request.form.get(kolom, '') for kolom in kolom_kolom}
    simpan_data(data)
    return render_template('result.html', data=data)

@app.route('/riwayat')
def riwayat():
    keyword = request.args.get('keyword', '').lower()
    data = baca_data()
    if keyword:
        data = [row for row in data if keyword in row.get('nama', '').lower()]
    return render_template('riwayat.html', data=data, kolom_kolom=kolom_kolom)

@app.route('/hapus', methods=['POST'])
def hapus():
    data = baca_data()
    baru = [row for row in data if not all(request.form.get(k) == v for k, v in row.items())]
    with open(DATA_FILE, 'w', newline='', encoding='utf-8') as f:
        writer = csv.DictWriter(f, fieldnames=kolom_kolom)
        writer.writeheader()
        writer.writerows(baru)
    return redirect('/riwayat')

@app.route('/edit/<int:index>')
def edit(index):
    data = baca_data()
    return render_template('edit.html', data=data[index], index=index, kolom_kolom=kolom_kolom)

@app.route('/update/<int:index>', methods=['POST'])
def update(index):
    data = baca_data()
    for kolom in kolom_kolom:
        data[index][kolom] = request.form.get(kolom, '')
    with open(DATA_FILE, 'w', newline='', encoding='utf-8') as f:
        writer = csv.DictWriter(f, fieldnames=kolom_kolom)
        writer.writeheader()
        writer.writerows(data)
    return redirect('/riwayat')

@app.route('/download_excel')
def download_excel():
    keyword = request.args.get('keyword', '').lower()
    data = baca_data()
    if keyword:
        data = [row for row in data if keyword in row.get('nama', '').lower()]
    output = io.StringIO()
    writer = csv.DictWriter(output, fieldnames=kolom_kolom)
    writer.writeheader()
    writer.writerows(data)
    output.seek(0)
    return send_file(io.BytesIO(output.getvalue().encode()), mimetype='text/csv',
                     download_name='riwayat_posyandu.csv', as_attachment=True)

@app.route('/download_pdf')
def download_pdf():
    keyword = request.args.get('keyword', '').lower()
    data = baca_data()
    if keyword:
        data = [row for row in data if keyword in row.get('nama', '').lower()]
    pdf = FPDF()
    pdf.add_page()
    pdf.set_font("Arial", size=10)
    for i, row in enumerate(data):
        pdf.cell(0, 10, f"{i+1}. " + ', '.join([f"{k}: {v}" for k, v in row.items()]), ln=True)
    output = io.BytesIO()
    pdf.output(output)
    output.seek(0)
    return send_file(output, mimetype='application/pdf', download_name='riwayat_posyandu.pdf', as_attachment=True)

if __name__ == '__main__':
    app.run(debug=True)
