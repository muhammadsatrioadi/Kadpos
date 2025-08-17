<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PosyanduData extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'posyandu_data';

    protected $fillable = [
        'dusun',
        'nama',
        'kategori',
        'jenis_kelamin',
        'tanggal_lahir',
        'umur',
        'alamat',
        'nomor_ktp',
        'nomor_bpjs',
        'berat_badan',
        'tinggi_badan',
        'imt',
        'lingkar_perut',
        'tekanan_darah',
        'mental_dan_emosional',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'berat_badan' => 'decimal:1',
        'tinggi_badan' => 'decimal:1',
        'imt' => 'decimal:1',
        'lingkar_perut' => 'decimal:1',
        'umur' => 'integer'
    ];

    // Accessor untuk format tanggal Indonesia
    public function getTanggalLahirFormattedAttribute()
    {
        return $this->tanggal_lahir ? $this->tanggal_lahir->format('d/m/Y') : '';
    }

    // Accessor untuk status IMT
    public function getImtStatusAttribute()
    {
        if (!$this->imt) return '';
        
        if ($this->imt < 18.5) return 'Underweight';
        if ($this->imt >= 18.5 && $this->imt < 25) return 'Normal';
        if ($this->imt >= 25 && $this->imt < 30) return 'Overweight';
        return 'Obese';
    }

    // Accessor untuk warna status IMT
    public function getImtColorAttribute()
    {
        if (!$this->imt) return 'secondary';
        
        if ($this->imt < 18.5) return 'info';
        if ($this->imt >= 18.5 && $this->imt < 25) return 'success';
        if ($this->imt >= 25 && $this->imt < 30) return 'warning';
        return 'danger';
    }

    // Scope untuk pencarian
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%")
              ->orWhere('kategori', 'like', "%{$search}%")
              ->orWhere('dusun', 'like', "%{$search}%")
              ->orWhere('alamat', 'like', "%{$search}%");
        });
    }

    // Scope untuk filter kategori
    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    // Method untuk menghitung IMT otomatis
    public static function calculateIMT($beratBadan, $tinggiBadan)
    {
        if ($beratBadan <= 0 || $tinggiBadan <= 0) {
            return 0;
        }
        
        $tinggiMeter = $tinggiBadan / 100;
        return round($beratBadan / ($tinggiMeter * $tinggiMeter), 1);
    }
}
