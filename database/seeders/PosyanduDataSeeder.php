<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PosyanduData;
use Carbon\Carbon;

class PosyanduDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sampleData = [
            [
                'dusun' => 'Dusun Mawar',
                'nama' => 'Siti Aminah',
                'kategori' => 'Ibu Hamil',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '1995-03-15',
                'umur' => 29,
                'alamat' => 'Jl. Melati No. 123, RT 02/RW 05',
                'nomor_ktp' => '3201234567890123',
                'nomor_bpjs' => '0001234567890',
                'berat_badan' => 65.0,
                'tinggi_badan' => 160.0,
                'imt' => 25.4,
                'lingkar_perut' => 85.0,
                'tekanan_darah' => '120/80',
                'mental_dan_emosional' => 'Stabil, tidak ada keluhan',
                'keterangan' => 'Kehamilan trimester 2, kondisi sehat',
                'created_at' => Carbon::now()->subDays(5),
            ],
            [
                'dusun' => 'Dusun Melati',
                'nama' => 'Ahmad Fauzi',
                'kategori' => 'Balita',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => '2021-08-20',
                'umur' => 3,
                'alamat' => 'Jl. Anggrek No. 45, RT 01/RW 03',
                'nomor_ktp' => null,
                'nomor_bpjs' => '0009876543210',
                'berat_badan' => 14.0,
                'tinggi_badan' => 95.0,
                'imt' => 15.5,
                'lingkar_perut' => 50.0,
                'tekanan_darah' => null,
                'mental_dan_emosional' => 'Aktif, perkembangan normal',
                'keterangan' => 'Imunisasi lengkap sesuai jadwal',
                'created_at' => Carbon::now()->subDays(3),
            ],
            [
                'dusun' => 'Dusun Kenanga',
                'nama' => 'Ibu Sari Dewi',
                'kategori' => 'Ibu Menyusui',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '1992-11-08',
                'umur' => 32,
                'alamat' => 'Jl. Mawar No. 78, RT 03/RW 02',
                'nomor_ktp' => '3201987654321098',
                'nomor_bpjs' => '0005432167890',
                'berat_badan' => 58.0,
                'tinggi_badan' => 155.0,
                'imt' => 24.1,
                'lingkar_perut' => 78.0,
                'tekanan_darah' => '110/70',
                'mental_dan_emosional' => 'Baik, sedikit kelelahan',
                'keterangan' => 'Menyusui bayi usia 6 bulan',
                'created_at' => Carbon::now()->subDays(1),
            ],
            [
                'dusun' => 'Dusun Cempaka',
                'nama' => 'Pak Sutrisno',
                'kategori' => 'Lansia',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => '1955-07-12',
                'umur' => 69,
                'alamat' => 'Jl. Cempaka No. 12, RT 04/RW 01',
                'nomor_ktp' => '3201123456789012',
                'nomor_bpjs' => '0002468135790',
                'berat_badan' => 72.0,
                'tinggi_badan' => 168.0,
                'imt' => 25.5,
                'lingkar_perut' => 95.0,
                'tekanan_darah' => '140/90',
                'mental_dan_emosional' => 'Stabil, kadang merasa kesepian',
                'keterangan' => 'Riwayat hipertensi, kontrol rutin',
                'created_at' => Carbon::now()->subHours(6),
            ]
        ];

        foreach ($sampleData as $data) {
            PosyanduData::create($data);
        }
    }
}
