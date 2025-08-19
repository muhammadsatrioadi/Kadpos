<?php

namespace App\Http\Controllers;

use App\Models\PosyanduData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;

class PosyanduController extends Controller
{
    // Konstanta untuk kategori dan jenis kelamin
    const KATEGORI_OPTIONS = ['Balita', 'Ibu Hamil', 'Ibu Menyusui', 'Lansia'];
    const JENIS_KELAMIN_OPTIONS = ['Laki-laki', 'Perempuan'];

    /**
     * Tampilkan form input data
     */
    public function index()
    {
        return view('posyandu.form', [
            'title' => 'Form Input Data Posyandu',
            'kategori_options' => self::KATEGORI_OPTIONS,
            'jenis_kelamin_options' => self::JENIS_KELAMIN_OPTIONS
        ]);
    }

    /**
     * Simpan data baru
     */
    public function store(Request $request)
    {
        $validator = $this->validatePosyanduData($request);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Terdapat kesalahan dalam pengisian form.');
        }

        $data = $request->all();
        
        // Hitung IMT otomatis
        if ($data['berat_badan'] && $data['tinggi_badan']) {
            $data['imt'] = PosyanduData::calculateIMT($data['berat_badan'], $data['tinggi_badan']);
        }

        $posyandu = PosyanduData::create($data);

        return redirect()->route('posyandu.result', $posyandu->id)
            ->with('success', 'Data berhasil disimpan!');
    }

    /**
     * Tampilkan hasil setelah input
     */
    public function result($id)
    {
        $data = PosyanduData::findOrFail($id);
        
        return view('posyandu.result', [
            'title' => 'Data Berhasil Disimpan',
            'data' => $data
        ]);
    }

    /**
     * Tampilkan riwayat data dengan pencarian
     */
    public function riwayat(Request $request)
    {
        $query = PosyanduData::query()->orderBy('created_at', 'desc');

        // Filter pencarian
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->byKategori($request->kategori);
        }

        $data = $query->paginate(10)->withQueryString();
        $totalData = PosyanduData::count();

        return view('posyandu.riwayat', [
            'title' => 'Riwayat Data Posyandu',
            'data' => $data,
            'totalData' => $totalData,
            'kategori_options' => self::KATEGORI_OPTIONS,
            'currentSearch' => $request->search,
            'currentKategori' => $request->kategori
        ]);
    }

    /**
     * Tampilkan form edit
     */
    public function edit($id)
    {
        $data = PosyanduData::findOrFail($id);
        
        return view('posyandu.edit', [
            'title' => 'Edit Data Posyandu',
            'data' => $data,
            'kategori_options' => self::KATEGORI_OPTIONS,
            'jenis_kelamin_options' => self::JENIS_KELAMIN_OPTIONS
        ]);
    }

    /**
     * Update data
     */
    public function update(Request $request, $id)
    {
        $data = PosyanduData::findOrFail($id);
        $validator = $this->validatePosyanduData($request);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Terdapat kesalahan dalam pengisian form.');
        }

        $updateData = $request->all();
        
        // Hitung IMT otomatis
        if ($updateData['berat_badan'] && $updateData['tinggi_badan']) {
            $updateData['imt'] = PosyanduData::calculateIMT($updateData['berat_badan'], $updateData['tinggi_badan']);
        }

        $data->update($updateData);

        return redirect()->route('posyandu.riwayat')
            ->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Hapus data
     */
    public function destroy($id)
    {
        $data = PosyanduData::findOrFail($id);
        $nama = $data->nama;
        
        $data->delete();

        return redirect()->route('posyandu.riwayat')
            ->with('success', "Data {$nama} berhasil dihapus!");
    }

    /**
     * Export data ke CSV
     */
    public function exportCSV(Request $request)
    {
        $query = PosyanduData::query()->orderBy('created_at', 'desc');

        // Apply same filters as riwayat
        if ($request->filled('search')) {
            $query->search($request->search);
        }
        if ($request->filled('kategori')) {
            $query->byKategori($request->kategori);
        }

        $data = $query->get();

        $filename = 'riwayat_posyandu_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            
            // Header CSV
            fputcsv($file, [
                'No', 'Dusun', 'Nama', 'Kategori', 'Jenis Kelamin', 'Tanggal Lahir',
                'Umur', 'Alamat', 'Nomor KTP', 'Nomor BPJS', 'Berat Badan (kg)',
                'Tinggi Badan (cm)', 'IMT', 'Lingkar Perut (cm)', 'Tekanan Darah',
                'Lingkar Kepala (cm)', 'LILA (Lingkar Lengan Atas, cm)', 'Tekanan Darah',
                'Mental & Emosional', 'Keterangan', 'Tanggal Input'
            ]);

            // Data CSV
            foreach ($data as $index => $item) {
                fputcsv($file, [
                    $index + 1,
                    $item->dusun,
                    $item->nama,
                    $item->kategori,
                    $item->jenis_kelamin,
                    $item->tanggal_lahir_formatted,
                    $item->umur,
                    $item->alamat,
                    $item->nomor_ktp,
                    $item->nomor_bpjs,
                    $item->berat_badan,
                    $item->tinggi_badan,
                    $item->imt,
                    $item->lingkar_perut,
                    $item->lingkar_kepala,
                    $item->lila,
                    $item->tekanan_darah,
                    $item->mental_dan_emosional,
                    $item->keterangan,
                    $item->created_at->format('d/m/Y H:i')
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Export data ke PDF
     */
    public function exportPDF(Request $request)
    {
        $query = PosyanduData::query()->orderBy('created_at', 'desc');

        // Apply same filters as riwayat
        if ($request->filled('search')) {
            $query->search($request->search);
        }
        if ($request->filled('kategori')) {
            $query->byKategori($request->kategori);
        }

        $data = $query->get();
        $totalData = $data->count();

        $pdf = Pdf::loadView('posyandu.pdf', [
            'data' => $data,
            'totalData' => $totalData,
            'generatedAt' => now()->format('d/m/Y H:i:s')
        ]);

        $filename = 'riwayat_posyandu_' . date('Y-m-d_H-i-s') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Validasi data posyandu
     */
    private function validatePosyanduData(Request $request)
    {
        return Validator::make($request->all(), [
            'dusun' => 'required|string|max:100',
            'nama' => 'required|string|max:100',
            'kategori' => 'required|in:' . implode(',', self::KATEGORI_OPTIONS),
            'jenis_kelamin' => 'required|in:' . implode(',', self::JENIS_KELAMIN_OPTIONS),
            'tanggal_lahir' => 'required|date|before:today',
            'umur' => 'required|integer|min:0|max:150',
            'alamat' => 'required|string|max:255',
            'nomor_ktp' => 'nullable|string|size:16',
            'nomor_bpjs' => 'nullable|string|max:20',
            'berat_badan' => 'required|numeric|min:0.1|max:500',
            'tinggi_badan' => 'required|numeric|min:10|max:300',
            'lingkar_perut' => 'nullable|numeric|min:0|max:200',
            'lingkar_kepala' => 'nullable|numeric|min:0|max:100',
            'lila' => 'nullable|numeric|min:0|max:100',
            'tekanan_darah' => 'nullable|string|max:20',
            'mental_dan_emosional' => 'nullable|string|max:500',
            'keterangan' => 'nullable|string|max:500'
        ], [
            'required' => 'Field :attribute harus diisi.',
            'string' => 'Field :attribute harus berupa teks.',
            'numeric' => 'Field :attribute harus berupa angka.',
            'integer' => 'Field :attribute harus berupa bilangan bulat.',
            'date' => 'Field :attribute harus berupa tanggal yang valid.',
            'before' => 'Field :attribute harus sebelum hari ini.',
            'in' => 'Field :attribute tidak valid.',
            'size' => 'Field :attribute harus :size karakter.',
            'max' => 'Field :attribute maksimal :max karakter/angka.',
            'min' => 'Field :attribute minimal :min.'
        ]);
    }
}
